#!/usr/bin/env sh

# Run user scripts, if they exist
for f in /var/www/html/.fly/scripts/*.sh; do
    # Bail out this loop if any script exits with non-zero status code
    bash "$f" || break
done
chown -R www-data:www-data /var/www/html

##############################################
# php.iniの設定追加
##############################################
# ここではローカル用のentrypoint.shと同期をとった内容を記述する予定だったが
# 下記の経緯があり、それはしないことにした。
#
# fly.ioでのphpInfo()を表示して調査した結果
# はじめから
# upload_max_filesize = 100M
# post_max_size = 100M
# memory_limit = 256M
# になっていたので、この件について環境を変更する必要性がないと判断した。
#
# ちなみに、phpInfo()の情報では
# /etc/php/7.4/fpm/php.ini
# を見に行っており
# その中身で
# upload_max_filesize = 2M
# post_max_size = 8M
# memory_limit = 128M
# の設定値の記載があるにも関わらずである。
# 
# fly.io側では、実行ユーザwww-dataでphp-fpmが起動しており
# php-fpmがwebサーバーのようである
# その設定ファイルと思しき
# /etc/php/7.4/fpm/pool.d/www.conf
# に
# php_admin_value[post_max_size] = ${PHP_POST_MAX_SIZE}
# php_admin_value[upload_max_filesize] = ${PHP_UPLOAD_MAX_FILE_SIZE}
# php_admin_value[memory_limit] = ${PHP_MEMORY_LIMIT}
# の指定があり、環境変数の値より上書きしているようである
#
# この環境変数を定義している箇所まで、調査していない
# 冒頭のとおり
# fly.ioでのphpInfo()を表示して調査した結果
# はじめから
# upload_max_filesize = 100M
# post_max_size = 100M
# memory_limit = 256M
# になっていたので、調査を打ち切った。
# ローカル用のentrypoint.shと同期をとった内容を記述はしないことにした
##############################################

##############################################
# ffmpegのsetup(永続化環境へのコピー)
##############################################
# BASE_DIR の定義
# ★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
# ★注意事項★
# ローカルはパスに「laravelapp」が含まれるが、fly.ioにはない
# ローカルとfly.ioとで同期をとってスクリプトのメンテナンスをする際には、ここの変数値で
# 「laravelapp」の有無が異なることを注意してください。
# ★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
BASE_DIR="/var/www/html/storage/app/public"

# ★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
# 特記事項
# ★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
# 当、entrypoint.shは
# ローカルは、「docker compose up -d」を実行したとき
# fly.ioは、デプロイ時および、休止状態からマシンが復帰時
# で動作する。
# fly.ioは、デプロイ時に動作に関して、
# 先に、fly.ioデプロイ用のDockerfileでの
# apt-get update
# apt-get install -y --fix-missing ffmpeg libx264-dev libx265-dev
# でシステム領域に、ffmpegおよび、関連の*.soをシステム領域にインストールされる
# その後、当、entrypoint.shが動作し、
# システム領域にあるffmpegおよび、関連の*.soを
# storage/app/public/ffmpeg-binの配下にコピーする
#
# storage/app/public配下は、flyボリュームをマウントしている領域のため永続化対象である。
# 
# 次にマシンが休止状態となったときに、システム領域がリセットされても
# storage/app/public/ffmpeg-binの配下のffmpegおよび、関連の*.soを使って
# ffmpegのコマンドライン実行が可能となる
#
# 下記の配慮を行い、いつ、起動されても当スクリプトが正常終了するような実装としている
#
#   mkdir -pとしている配慮
#     mkdirは、「-p」のオプションがあれば、既に作成しようとしているディレクトリがあっても
#     特にエラーになることもなく、ユーザ問い合わせで固まることもなく、なにもせず正常終了します
#
#   cp -uとしている配慮
#     cpは、「-u」のオプションがあれば、
#     コピー元が存在して、かつ、コピー先がない場合は、コピーする
#     コピー元が存在して、かつ、コピー先もあるが、コピー元の更新日時のほうが新しい場合は、コピーする
#     上記、以外の場合は、なにもしない。
#     なにもしない場合は、
#     特にエラーになることもなく、ユーザ問い合わせで固まることもなく、なにもせず正常終了します
#
# 上記の配慮のため、マシンが休止し復帰時にシステム領域がリセットされているケースなどで
# 当、entrypoint.shが実行されたケースでも問題が発生しない実装となっているのである。
# ★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★

# ログファイルの場所を定義
LOGFILE="$BASE_DIR/ffmpeg_setup.log"

# 複数回実行時の開始位置がわかるように区切り線を記録
echo "********************" >> $LOGFILE

# ログファイルの所有者をwww-dataに変更する
echo "Starting chown for ffmpeg_setup.log file" >> $LOGFILE
chown www-data:www-data $LOGFILE 2>> $LOGFILE
result=$?
if [ $result -ne 0 ]; then
    echo "chown ffmpeg_setup.log failed with exit code: $result, error: $(tail -n 1 $LOGFILE)" >> $LOGFILE
else
    echo "chown ffmpeg_setup.log succeeded, exit code: $result" >> $LOGFILE
fi

# mkdir コマンドの実行とログ記録
echo "Starting mkdir for ffmpeg-bin directory" >> $LOGFILE
mkdir -p $BASE_DIR/ffmpeg-bin 2>> $LOGFILE
result=$?
if [ $result -ne 0 ]; then
    echo "mkdir failed with exit code: $result, error: $(tail -n 1 $LOGFILE)" >> $LOGFILE
else
    echo "mkdir succeeded, exit code: $result" >> $LOGFILE
fi

# .so ファイルのコピーとログ記録
echo "Starting copy of .so files" >> $LOGFILE
cp -u /usr/lib/x86_64-linux-gnu/libav*.so* $BASE_DIR/ffmpeg-bin 2>> $LOGFILE
result=$?
if [ $result -ne 0 ]; then
    echo "cp for .so files failed with exit code: $result, error: $(tail -n 1 $LOGFILE)" >> $LOGFILE
else
    echo "cp for .so files succeeded, exit code: $result" >> $LOGFILE
fi

# ffmpeg バイナリのコピーとログ記録
echo "Starting copy of ffmpeg binary" >> $LOGFILE
cp $(which ffmpeg) $BASE_DIR/ffmpeg-bin 2>> $LOGFILE
result=$?
if [ $result -ne 0 ]; then
    echo "ffmpeg copy failed with exit code: $result, error: $(tail -n 1 $LOGFILE)" >> $LOGFILE
else
    echo "ffmpeg copy succeeded, exit code: $result" >> $LOGFILE
fi

# chown コマンドの実行とログ記録
echo "Starting chown for ffmpeg-bin directory" >> $LOGFILE
chown -R www-data:www-data $BASE_DIR/ffmpeg-bin 2>> $LOGFILE
result=$?
if [ $result -ne 0 ]; then
    echo "chown failed with exit code: $result, error: $(tail -n 1 $LOGFILE)" >> $LOGFILE
else
    echo "chown succeeded, exit code: $result" >> $LOGFILE
fi

# chmod コマンドの実行とログ記録
echo "Starting chmod for ffmpeg-bin directory" >> $LOGFILE
chmod -R 755 $BASE_DIR/ffmpeg-bin 2>> $LOGFILE
result=$?
if [ $result -ne 0 ]; then
    echo "chmod failed with exit code: $result, error: $(tail -n 1 $LOGFILE)" >> $LOGFILE
else
    echo "chmod succeeded, exit code: $result" >> $LOGFILE
fi
##############################################

if [ $# -gt 0 ]; then
    # If we passed a command, run it as root
    exec "$@"
else
    exec supervisord -c /etc/supervisor/supervisord.conf
fi
