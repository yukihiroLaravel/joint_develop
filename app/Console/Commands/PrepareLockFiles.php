<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PrepareLockFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prepare:lock-files {user?} {group?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '複数のロック名のロックファイルをストレージに準備する。';

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
        $user = $this->argument('user');
        $group = $this->argument('group');

        $lockNames = [
            'avatar',
            'post',
        ];

        foreach ($lockNames as $lockName) {
            // ロックファイルのパスを指定
            $lockFilePath = storage_path("app/public/{$lockName}.lock");

            // ロックファイルが存在しなければ作成
            if (!\File::exists($lockFilePath)) {
                // ゼロバイトのロックファイルを作成
                \File::put($lockFilePath, '');
                $this->info("created at: {$lockFilePath}");
            } else {
                $this->info("already exists: {$lockFilePath}");
            }

            if($user && $group) {
                /*
                    例として、
                        php artisan prepare:lock-files www-data www-data
                    での実行時
                        $userは、www-data
                        $groupは、www-data
                    である。
                    このとき、
                        chown www-data:www-data ロックファイル
                    のLinuxコマンドに相当する処理がしたい
                    さもなければ、
                        ロックファイルの所有者が、
                        php artisan prepare:lock-files www-data www-data
                        の実行ユーザ(rootなど)となってしまい
                        app/Helpers/Helper.phpのdoWithLock()が権限エラーで
                        正常動作しないだろう。

                    dockerコンテナ内をroot以外で作業する環境のケースは、
                    sudoコマンドが使えるようにDockerfileを構成し、docker compose buidしているなどの前提で
                        sudo php artisan prepare:lock-files www-data www-data
                    などすればよろしいだろう。
                */
                $isOK = true;
                if ($isOK) {
                    if (!chown($lockFilePath, $user)) {
                        $this->error("Failed to chwon {$lockFilePath} to {$user}");
                        $isOK = false;
                    }
                }
                if ($isOK) {
                    if (!chgrp($lockFilePath, $group)) {
                        $this->error("Failed to chgrp {$lockFilePath} to {$group}");
                        $isOK = false;
                    }
                }
            }
        }

        return 0;
    }
}
