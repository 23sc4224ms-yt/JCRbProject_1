#!/usr/bin/env bash
set -e

php artisan storage:link || true
php artisan config:cache
php artisan view:cache
php artisan migrate --force

exec /init
