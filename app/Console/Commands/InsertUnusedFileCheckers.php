<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\UnusedFileChecker;
use Carbon\Carbon;

class InsertUnusedFileCheckers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'maketestdata:unused_file_checkers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'unused_file_checkersに指定したディレクトリからデータベースに登録する。';

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
        $paramMap = [
            ['baseDirName' => 'images', 'type' => 'avatar'],
            ['baseDirName' => 'images', 'type' => 'post'],
            ['baseDirName' => 'videos', 'type' => 'post'],
        ];

        /*
            このコマンドは本番環境では使いません
            「unused_file_checkers」のテストデータを作成するためのコマンドです。
            
            CleanupUnusedFiles.phpの実装と同時に、
            アップロードしたファイルを保存時に、「unused_file_checkers」にデータ登録する実装にしたが
            その段階では、storageにファイルはあるが、「unused_file_checkers」にはデータが無かった

            storageにあるファイルをls -ltrのイメージとなるように、
            古いもの順にソートかけてファイルの最終更新日時より、
            CleanupUnusedFiles.phpの実装での絞りに使ってるcreated_atに値を指定してデータ登録する
            
            storageにあるが「unused_file_checkers」にデータがない状況にて、
            「unused_file_checkers」のデータを作るためのコマンドである。

            ローカル環境での完全にテスト用のコマンド。
        */
        foreach ($paramMap as $pair) {
            $baseDirName = $pair['baseDirName'];
            $type = $pair['type'];

            $directoryPath = storage_path("app/public/{$baseDirName}/{$type}");

            $this->eachDirectory($type, $directoryPath);
        }

        return 0;
    }

    private function eachDirectory($type, $directoryPath)
    {
        if (!\File::exists($directoryPath)) {
            $this->info("directory not found: {$directoryPath}");
            return;
        }

        // ディレクトリ内のUUIDフォルダを取得
        $uuidDirectories = \File::directories($directoryPath);
        // ls -ltrのイメージになるように古いもの順で並び替え
        usort($uuidDirectories, function ($a, $b) {
            return filemtime($a) - filemtime($b);
        });

        // 各UUIDフォルダの中身を確認
        foreach ($uuidDirectories as $uuidDirectory) {

            // uuidのフォルダ内に1ファイルの構成だから基本的に1回しかループを回らないはず

            // uuid
            $uuid = basename($uuidDirectory);

            $files = \File::files($uuidDirectory);
            // ls -ltrのイメージになるように古いもの順で並び替え
            usort($files, function ($a, $b) {
                return filemtime($a) - filemtime($b);
            });

            foreach ($files as $file) {
                // fileName
                $fileName = $file->getFilename();

                $exists = UnusedFileChecker::where('type', $type)
                    ->where('uuid', $uuid)
                    ->where('file_name', $fileName)
                    ->exists();
                if ($exists) {
                    $this->info("already exists. uuid: {$uuid}, fileName: {$fileName}, type: {$type}");
                } else {
                    // ファイルの最終更新日時を取得し、日本時間に変換
                    $fileCreatedAt = Carbon::createFromTimestamp(filemtime($file))->timezone('Asia/Tokyo');

                    // insert
                    $unusedFileChecker = new UnusedFileChecker;
                    $unusedFileChecker->type = $type;
                    $unusedFileChecker->check_count = 0;
                    $unusedFileChecker->uuid = $uuid;
                    $unusedFileChecker->file_name = $fileName;
                    $unusedFileChecker->created_at = $fileCreatedAt;
                    $unusedFileChecker->save();

                    $this->info("Inserted record. uuid: {$uuid}, fileName: {$fileName}, type: {$type}");
                }
            }
        }
    }
}
