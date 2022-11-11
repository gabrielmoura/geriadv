# Optimize
Run:

```bash
composer install --no-dev
composer dump-autoload --optimize --apcu
php artisan optimize
php artisan event:cache
php artisan view:cache
php artisan opcache:compile --force
```
