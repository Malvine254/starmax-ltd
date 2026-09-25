# Deploy Laravel TenantPro on GoDaddy Shared Hosting

## 0. If You Have No Terminal Access
Use the built-in admin page:
- `https://starmaxltd.com/admin/deployment-tools`

From there, you can run:
- Clear all caches
- Rebuild config/routes/views cache
- Create storage symlink
- Run migrations and seeders
- Generate APP_KEY
- Validate vendor folder presence

Set `DEPLOYMENT_TOOL_TOKEN` in `.env` to protect this page.

## 1. Prepare Local Build
1. In `laravel-app`, copy `.env.godaddy.example` to `.env` and set database credentials.
2. Generate key:
   ```bash
   php artisan key:generate
   ```
3. Run migrations + seeders:
   ```bash
   php artisan migrate --force
   php artisan db:seed --force
   ```
4. Optional optimization:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```
5. Build dependencies locally and upload with project:
   ```bash
   composer install --no-dev --optimize-autoloader
   ```

## 2. Upload to GoDaddy (cPanel)
1. Create folder `laravel` in your account root (one level above `public_html`).
2. Upload all files from `laravel-app` into that `laravel` folder.
3. Copy contents of `laravel/public` into `public_html`.
4. Edit `public_html/index.php` paths:
   - `../vendor/autoload.php` -> `../laravel/vendor/autoload.php`
   - `../bootstrap/app.php` -> `../laravel/bootstrap/app.php`
5. Copy `laravel/.env` to `laravel/.env` on server and set production values.
6. Ensure `laravel/storage` and `laravel/bootstrap/cache` are writable (755/775 depending on host policy).

## 3. Run Database Migrations on Host
Use cPanel Terminal (if available) or SSH:
```bash
cd ~/laravel
php artisan migrate --force
php artisan db:seed --force
```

If terminal is unavailable, run these from `/admin/deployment-tools`.

## 4. Default Admin Login
- Email: `admin@starmaxltd.com`
- Password: `ChangeMe123!`

Change password immediately after first login.

## 5. Verify
- Public site: `https://starmaxltd.com/`
- Admin login: `https://starmaxltd.com/admin/login`
- API auth login: `POST https://starmaxltd.com/api/auth/login`

## 6. Important Notes
- Android app can keep using API endpoints under `/api/*`.
- If Sanctum migration is missing, ensure `personal_access_tokens` table exists.
- Keep `APP_DEBUG=false` in production.
# Bulk event invitations

Install the updated Composer dependencies (`composer install --no-dev --optimize-autoloader`). CSV and XLSX imports use OpenSpout and require PHP's zip, XML reader and DOM extensions. In Admin > Event registrations, choose an event, upload a CSV/XLSX recipient list, review extracted recipients and send. Only the first worksheet is read; supported columns are name, email, phone and company. Email is required. Files are limited to 5 MB and 1,000 data rows. Format phone columns as text to preserve leading zeros. Invalid rows are reported and duplicate email addresses within the file are removed. Clicking Send saves new attendees to the event before queuing invitations. Existing event/email records are preserved; email failures do not remove saved attendees.

Invitations use Laravel's configured queue. Use `QUEUE_CONNECTION=database` and run a worker (`php artisan queue:work --tries=3 --timeout=60`), or schedule `php artisan queue:work --stop-when-empty --tries=3 --timeout=60` through hosting cron with overlapping runs prevented. Keep SMTP timeouts below the worker timeout. Run existing migrations to ensure the jobs table exists. Monitor `php artisan queue:failed` for failed deliveries; the UI reports queued invitations, not confirmed delivery. With `QUEUE_CONNECTION=sync`, email sending occurs during the request and large batches can time out.
