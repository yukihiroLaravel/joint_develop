#!/usr/bin/env bash

if [ ! -e /var/www/html/public/storage ] && [ ! -L /var/www/html/public/storage ]; then
    /usr/bin/php /var/www/html/artisan storage:link
fi