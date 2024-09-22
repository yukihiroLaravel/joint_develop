<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\Helper;

use Carbon\Carbon;
use App\UnusedFileChecker;
use App\UserImage;
use App\PostImage;

class CleanupUnusedFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup:unused-files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'データベース内で参照されていないファイルをストレージから削除する';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private function outputInfo($msg)
    {
        // コンソール
        $this->info($msg . "\n");
        // ログ
        \Log::Info($msg . "\n");
    }

    private function outputError($msg)
    {
        // コンソール
        $this->error($msg . "\n");
        // ログ
        \Log::error($msg . "\n");
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $helper = Helper::getInstance();

            $exclusionDays = config('app.exclusionDays');
            $exclusionHours = config('app.exclusionHours');
            $exclusionMinutes = config('app.exclusionMinutes');
            $exclusionSeconds = config('app.exclusionSeconds');
            $cleanupUnusedFilesTakeCount = config('app.cleanupUnusedFilesTakeCount');

            $types = [
                'avatar',
                'post',
            ];

            foreach ($types as $type) {
                /*
                    アプリ側で「user_images」、「post_images」のDELETE/INSERT処理をしている
                    当クリーンナップ処理では、「user_images」、「post_images」に存在するかで
                    削除対象とすべきかを判定している。
                    そのため、タイミングによっては、意図しないものまで、削除対象となってしまう
    
                    これを防ぐためには、$helper->doWithLock()からの
                    コールバック処理とする形で、排他ロックするしかない。
                */
                $helper->doWithLock($type, function () use (
                    $helper,
                    $type,
                    $exclusionDays,
                    $exclusionHours,
                    $exclusionMinutes,
                    $exclusionSeconds,
                    $cleanupUnusedFilesTakeCount
                ) {
                    $this->doProcess(
                        $helper,
                        $type,
                        $exclusionDays,
                        $exclusionHours,
                        $exclusionMinutes,
                        $exclusionSeconds,
                        $cleanupUnusedFilesTakeCount
                    );
                });
            }

            return 0;
        } catch (\Exception $e) {
            $this->outputError('******************************************');
            $this->outputError('Exception Message: ' . $e->getMessage());
            $this->outputError('Stack Trace: ' . $e->getTraceAsString());
            $this->outputError('******************************************');
            throw $e;
        }
    }

    /**
     * $typeごとのクリーンナップ処理を行う。
     */
    private function doProcess(
        $helper,
        $type,
        $exclusionDays,
        $exclusionHours,
        $exclusionMinutes,
        $exclusionSeconds,
        $cleanupUnusedFilesTakeCount
    ) {
        $isAvatar = ($type === 'avatar');
        $isPost = ($type === 'post');
        if(!$isAvatar && !$isPost) {
            throw new \Exception("invalid type value : '{$type}'");
        }

        /*
            処理対象の抽出のクエリに関する説明

            ・typeで絞る

            ・created_atが除外すべき現在時刻からの期間よりも古い 
                まさに、今、画面操作で画像追加してて、あと少しで登録／更新系のボタンを押して
                DB反映されそうなものまで、未だDB反映されてないということで削除対象になってしまうのを防ぐため
            
            ・check_countの昇順
                当クリーンナップ処理による判定をあまりやってないものを優先的に処理したい
            
            ・idの昇順
                check_countが同じ値ならば、純粋に古いものを優先的に処理したい

            ・take($cleanupUnusedFilesTakeCount)
                上記に対して、先頭、$cleanupUnusedFilesTakeCount件分の取得のクエリとする
                こうすることで「unused_file_checkers」の件数が膨大になっても
                クエリ自体の負荷は、$cleanupUnusedFilesTakeCount件分となり
                後続のループ処理も$cleanupUnusedFilesTakeCount件分の処理量しかない
            
            1回の処理でクリーンナップ処理を完全にやってしまうのではなく
            $cleanupUnusedFilesTakeCount件分ずつ処理して、高負荷にならないようにする
            消し漏れを防ぐため、check_countの昇順で行う配慮とする。

            削除対象であるものは、
                sotrageからの削除と、「unused_file_checkers」からのレコード削除を行う。
            削除対象でないものは、
                「unused_file_checkers」のcheck_countをカウントアップし、
                次回以降の処理対象を抽出時の優先度を下げる。
            
            ユーザは古いものも新しいものも、画面操作で削除してくる可能性があるため(どれを削除するか事前にわからない)
            check_countで優先度を管理しながら、当コマンドが複数回、実行されていく中で、
            徐々に、不要なファイルが削除されていく状況となるような運用にする。
        */

        // 処理対象から除外すべき現在時刻からの期間
        $exclusionPeriod = Carbon::now('Asia/Tokyo')->subDays($exclusionDays)->subHours($exclusionHours)->subMinutes($exclusionMinutes)->subSeconds($exclusionSeconds);

        $unusedFileCheckers = UnusedFileChecker::where('type', $type)
            ->where('created_at', '<', $exclusionPeriod)
            ->orderBy('check_count', 'asc')
            ->orderBy('id', 'asc')
            ->take($cleanupUnusedFilesTakeCount)
            ->get();

        $toDeleteList = []; // 蓄積リスト(削除対象であるもの)
        $toKeepList = [];   // 蓄積リスト(削除対象ではないもの)

        foreach ($unusedFileCheckers as $unusedFileChecker) {
            $uuid = $unusedFileChecker->uuid;
            $fileName = $unusedFileChecker->file_name;

            $exists = false;

            if ($isAvatar) {
                // UserImageモデルでデータを確認
                $exists = UserImage::where('uuid', $uuid)
                    ->where('file_name', $fileName)
                    ->exists();
            }
            
            if ($isPost) {
                // PostImageモデルでデータを確認
                $exists = PostImage::where('uuid', $uuid)
                    ->where('file_name', $fileName)
                    ->exists();
            }

            // 判定結果に応じてリストに追加
            if ($exists) {
                $toKeepList[] = [
                    'type' => $type,
                    'uuid' => $uuid,
                    'file_name' => $fileName,
                ];
            } else {
                $toDeleteList[] = [
                    'type' => $type,
                    'uuid' => $uuid,
                    'file_name' => $fileName,
                ];
            }
        }

        /*
            ループ処理の不整合を回避するため
            ( ループ処理中に、ループ対象のソースが変わる不整合)

            上記のループ処理を終えた後に、蓄積分について別個に処理をすべき
        */

        // 削除対象であるリストのループ処理
        foreach ($toDeleteList as $item) {

            // ストレージから削除
            $helper->deleteImageOnStorage($item['type'], $item['uuid']);

            // DBからレコード削除
            $QueryBuilder = $this->getCommonUnusedFileQueryBuilder($item['type'], $item['uuid'], $item['file_name']);
            $QueryBuilder->delete();

            $this->outputInfo("{$item['type']}, {$item['uuid']}, {$item['file_name']} : を削除しました。");
        }

        // 削除対象ではないリストのループ処理
        foreach ($toKeepList as $item) {

            // check_countのカウントアップ
            $QueryBuilder = $this->getCommonUnusedFileQueryBuilder($item['type'], $item['uuid'], $item['file_name']);
            $unusedFileChecker = $QueryBuilder->first();
            if($unusedFileChecker) {

                $fromCheckCount = $unusedFileChecker->check_count;
                $toCheckCount = $fromCheckCount + 1;

                $unusedFileChecker->check_count = $toCheckCount;
                $unusedFileChecker->updated_at = now();
                $unusedFileChecker->save();
    
                $this->outputInfo("{$item['type']}, {$item['uuid']}, {$item['file_name']} : のcheck_countを{$fromCheckCount}から{$toCheckCount}にカウントアップしました。");    
            } else {
                throw new \Exception("invalid QueryBuilder type : {$item['type']}, uuid : {$item['uuid']}, file_name : {$item['file_name']}");
            }
        }
    }

    /**
     * 「unused_file_checkers」を$type, $uuid, $fileNameで絞ったクエリビルダを返す
     */
    private function getCommonUnusedFileQueryBuilder($type, $uuid, $fileName)
    {
        return UnusedFileChecker::where('type', $type)
            ->where('uuid', $uuid)
            ->where('file_name', $fileName);
    }
}
