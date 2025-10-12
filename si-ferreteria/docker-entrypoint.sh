#!/bin/bash

set -e

echo "Running migrations..."
php artisan migrate --force --no-interaction

echo "Creating storage link..."
php artisan storage:link --force || true

echo "Optimizing application..."
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

echo "Starting application on port ${PORT:-8080}..."
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
