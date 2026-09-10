#!/bin/sh

# Jalankan migrasi (Railway akan menjalankan ini di deploy phase)
# php artisan migrate --force

# Cache config dan route untuk production
php artisan config:cache
php artisan route:cache

# Mulai PHP-FPM & Nginx
php-fpm & nginx -g 'daemon off;'