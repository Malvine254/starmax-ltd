# Deploy the Starmax Website on GoDaddy Shared Hosting

## 0. If You Have No Terminal Access
Use the built-in admin page:
- `https://starmaxltd.com/admin/server-tools`

From there, you can run:
- Clear all caches
- Rebuild config/routes/views cache
- Create storage symlink
- Run migrations and seeders
- Generate APP_KEY
- Validate vendor folder presence

The page does not require an admin login, but every command requires the deployment token. Set this in the production `.env`:
```dotenv
DEPLOYMENT_TOOL_TOKEN=123456789
```
Keep the token private and replace the example with a longer random value when possible. Requests are rate limited, commands are allowlisted, and arbitrary Artisan commands cannot be submitted.

## 1. Prepare Local Build
1. In the project root, copy `.env.example` to `.env` and set database and mail credentials.
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
2. Upload the application into that `laravel` folder. When updating an existing deployment, remove files deleted from the repository as well as uploading changed files; an overlay-only upload leaves retired code behind.
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

If terminal is unavailable, run these from `/admin/server-tools`.

After installing dependencies and uploading code, refresh cached providers and routes:

```bash
php artisan optimize:clear
php artisan package:discover
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

When removing the old API dependency, stale generated `bootstrap/cache/packages.php`
and `bootstrap/cache/services.php` files can reference Sanctum. If Artisan cannot
boot, remove only those two generated cache files, then run the commands above.
Never upload an old vendor archive over a fresh Composer installation.

## 4. Admin Login
Set `ADMIN_LOGIN_EMAIL` and `ADMIN_LOGIN_PASSWORD` before seeding.
The password must contain at least 12 characters. No default credentials are supplied.

## 5. Verify
- Public site: `https://starmaxltd.com/`
- Admin login: `https://starmaxltd.com/admin/login`
- Grace Sellah portfolio: `https://starmaxltd.com/grace-sellah`
- Grace Sellah editor: `https://starmaxltd.com/grace-sellah/admin`
- Retired API paths such as `/api/auth/login` should return 404.

## 6. Important Notes
- This deployment serves the company website and its admin plus Grace Sellah's portfolio. It no longer hosts the Tenant Pro API or rental-management application.
- Historical migrations and database records are preserved. Do not drop old tables or run `migrate:fresh` as part of this update.
- Old promotional events saved in the database are not automatically deleted; review them in the admin.
- Keep `APP_DEBUG=false` in production.
# Bulk event invitations

Install the updated Composer dependencies (`composer install --no-dev --optimize-autoloader`). CSV and XLSX imports use OpenSpout and require PHP's zip, XML reader and DOM extensions. In Admin > Event registrations, choose an event, upload a CSV/XLSX recipient list, review extracted recipients and send. Only the first worksheet is read; supported columns are name, email, phone and company. Email is required. Files are limited to 5 MB and 1,000 data rows. Format phone columns as text to preserve leading zeros. Invalid rows are reported and duplicate email addresses within the file are removed. Clicking Send saves new attendees to the event before queuing invitations. Existing event/email records are preserved; email failures do not remove saved attendees.

Invitations use Laravel's configured queue. Use `QUEUE_CONNECTION=database` and run a worker (`php artisan queue:work --tries=3 --timeout=60`), or schedule `php artisan queue:work --stop-when-empty --tries=3 --timeout=60` through hosting cron with overlapping runs prevented. Keep SMTP timeouts below the worker timeout. Run existing migrations to ensure the jobs table exists. Monitor `php artisan queue:failed` for failed deliveries; the UI reports queued invitations, not confirmed delivery. With `QUEUE_CONNECTION=sync`, email sending occurs during the request and large batches can time out.
