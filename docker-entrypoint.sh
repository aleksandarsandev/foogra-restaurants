#!/bin/sh
set -e

php artisan migrate --force
php artisan db:seed --force
php artisan storage:link --force

exec apache2-foreground
