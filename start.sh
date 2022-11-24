#!/usr/bin/env bash
cd /app

echo "Running composer"
composer install --no-dev

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force

exec /usr/bin/supervisord -n