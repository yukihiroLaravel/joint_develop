<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\Helper;
use Carbon\Carbon;

class GenerateThumbnail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:thumbnail {video} {thumbnail}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '指定した動画ファイルからサムネイルを生成する';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /*
            動画関係の実装を開始したかなりの初期段階で、
            アップロードUIや、カルーセルの起動前の表示で、動画に対するサムネイル画像の
            画面表示が必要になると思いまして、Helper.phpのgenerateThumbnailFromVideo()
            を実装しましたが、「ffmpegおよび、関連の*.so」の環境構築のスクリプトとの連携した分なども
            含めてローカルと、fly.ioでの動作確認用に作成しました。

            「Helper.phpのgenerateThumbnailFromVideo()」の単体テスト用(パフォーマンス計測)
            で使ったコマンドのため、本番運用に必要なものではありません。
        */

        // 処理開始時の日時を取得
        $startTime = Carbon::now();
        $this->info("処理開始: " . $startTime->toDateTimeString());

        $helper = Helper::getInstance();

        // コマンドの引数から動画ファイルパスを取得
        $videoFilePath = $this->argument('video');
        // コマンドの引数からサムネイルの保存先を取得
        $thumbnailFilePath = $this->argument('thumbnail');

        // サムネイル生成処理の実行
        try {
            $helper->generateThumbnailFromVideo($videoFilePath, $thumbnailFilePath);
            $this->info("サムネイル生成に成功しました: {$thumbnailFilePath}");
        } catch (\Exception $e) {
            $this->error("サムネイル生成に失敗しました");
            throw $e;
        }

        // 処理終了時の日時を取得
        $endTime = Carbon::now();
        $this->info("処理終了: " . $endTime->toDateTimeString());

        // 処理時間を計算
        $duration = $startTime->diffInSeconds($endTime);
        $this->info("処理時間: {$duration} 秒");
    }
}
