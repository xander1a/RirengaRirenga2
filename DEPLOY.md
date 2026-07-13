# Deploying BYIZA Eco-lodge to cPanel Shared Hosting

This app is built to run without a Node runtime or Redis in production. Frontend
assets are pre-compiled locally and uploaded as static files; caching/queues use
the `database`/`file` drivers, which any shared host supports.

## 1. Build assets locally

On your machine (not on the server):

```
npm install
npm run build
```

This produces `public/build/` (compiled CSS/JS). Commit/upload this folder —
cPanel hosts generally do not give you a Node environment to run Vite.

## 2. Upload files

Recommended cPanel layout:

- Upload the entire Laravel project to a folder **outside** `public_html`,
  e.g. `/home/USER/byiza-app`.
- Point your domain's document root to `/home/USER/byiza-app/public`
  (cPanel → Domains → set "Document Root"), **or** if you cannot change the
  document root, copy the contents of `public/` into `public_html/` and edit
  `public_html/index.php` to point `require` paths at `../byiza-app/...`.
- Make sure `storage/`, `bootstrap/cache/`, and `database/database.sqlite`
  (if using SQLite) are writable by the web server user.

## 3. Configure `.env`

Copy `.env.example` to `.env` on the server and set:

```
APP_NAME="BYIZA Eco-lodge"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cpaneluser_byiza
DB_USERNAME=cpaneluser_byiza
DB_PASSWORD=your-mysql-password

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

MAIL_MAILER=smtp
MAIL_HOST=mail.yourdomain.com
MAIL_PORT=587
MAIL_USERNAME=info@yourdomain.com
MAIL_PASSWORD=your-mail-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=info@yourdomain.com
MAIL_FROM_NAME="BYIZA Eco-lodge"

# TODO: fill in once provided by MTN MoMo
MOMO_SUBSCRIPTION_KEY=
MOMO_API_USER=
MOMO_API_KEY=
MOMO_TARGET_ENV=production
MOMO_CALLBACK_URL=https://yourdomain.com/booking/payment/callback

# TODO: fill in once provided by Flutterwave
FLUTTERWAVE_PUBLIC_KEY=
FLUTTERWAVE_SECRET_KEY=
```

Create the MySQL database and user via cPanel → MySQL Databases, then run:

```
php artisan key:generate   # if APP_KEY is not already set
php artisan migrate --force
php artisan db:seed --force   # only on first deploy, creates demo accounts + content
php artisan storage:link
```

> ⚠️ Change or remove the seeded demo accounts' passwords before going live.

## 4. Cache config for production

```
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Re-run these any time you change `.env`, routes, or config files.

## 5. Cron job (queue + scheduler)

Most shared hosts run queued jobs via the database driver without a worker,
but if you want emails sent in the background, add a cron job in cPanel:

```
* * * * * php /home/USER/byiza-app/artisan schedule:run >> /dev/null 2>&1
```

## 6. File permissions

```
chmod -R 755 storage bootstrap/cache
```

Ensure the web server user (often `nobody` or your cPanel username) can
write to `storage/`, `storage/logs/`, `storage/framework/`, and
`bootstrap/cache/`.

## 7. HTTPS

Enable AutoSSL / Let's Encrypt in cPanel and force HTTPS by setting
`APP_URL` to `https://...`. The app assumes HTTPS in production for secure
cookies and payment callbacks.

## 8. Outstanding TODOs before go-live

- MTN MoMo Collections API credentials (`MOMO_*` env vars)
- Flutterwave card payment credentials (`FLUTTERWAVE_*` env vars)
- Bank transfer account details (currently placeholder text in
  `resources/views/emails/booking-confirmation.blade.php` and reservation
  confirmation views)
- Replace placeholder logo/PWA icons in `public/icons/` with final branded
  artwork
- Confirm exact physical address / location for the Contact and About pages
- Change all seeded demo account passwords

## Demo accounts (seeded by `db:seed`)

| Role      | Email                          | Password     |
|-----------|---------------------------------|--------------|
| Director  | director@byizaecolodge.com      | director123  |
| Manager   | manager@byizaecolodge.com        | manager123   |
| Staff     | staff@byizaecolodge.com          | staff123     |
| Customer  | guest@example.com                | guest123     |

Change these immediately after first login in production.
