#!/usr/bin/env bash
set -e

if [ -n "$RENDER_EXTERNAL_URL" ] && [ -z "$APP_URL" ]; then
    export APP_URL="$RENDER_EXTERNAL_URL"
fi

if [ -n "$APP_KEY" ] && [[ "$APP_KEY" != base64:* ]]; then
    export APP_KEY="base64:$APP_KEY"
fi

php artisan storage:link || true
php artisan config:cache
php artisan view:cache
php artisan migrate --force

exec /init
