# India Uncaged

Official website for India Uncaged — a photography-led wildlife travel and expedition platform.

## Stack
- Laravel 12
- PHP 8.2+
- MySQL
- Blade + custom CSS/JavaScript
- GitHub for source control
- Hostinger Premium for production hosting

## Local development
1. Copy `.env.example` to `.env`.
2. Set `APP_KEY`, database credentials and `APP_URL`.
3. Run `composer install`.
4. Run `php artisan key:generate`.
5. Run `php artisan migrate`.
6. Create the first owner with `php artisan indiauncaged:create-owner`.
7. Run `php artisan storage:link`.

## Hostinger deployment
The production document root should point to Laravel's `public/` directory. Keep the Laravel application root, `.env`, `vendor/`, `storage/` and `bootstrap/` outside the public web root whenever Hostinger's configuration allows it.

After uploading/cloning:
`composer install --no-dev --optimize-autoloader`
`php artisan migrate --force`
`php artisan storage:link`
`php artisan optimize`
`php artisan indiauncaged:create-owner`

Set production `.env` values including a real `APP_KEY`, MySQL credentials, `APP_URL`, `SESSION_SECURE_COOKIE=true`, and `APP_DEBUG=false`. Never commit `.env`.

## Git workflow
- `main` = stable production
- `development` = active build/testing
- Create a PR into `main` only after staging/production-like testing.