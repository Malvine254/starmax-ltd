# Starmax Ltd Website

Laravel 12 application for the Starmax public website, website administration,
and Grace Sellah's portfolio.

## Application scope

- Public company pages, services, product-development information, and contact forms.
- Events, registration, invitations, attendance, and certificates.
- Session-authenticated website admin at `/admin/login`.
- Grace Sellah's portfolio at `/grace-sellah` and editor at `/grace-sellah/admin`.
- Token-protected, allowlisted hosting tools at `/admin/server-tools`.

Tenant Pro's API, rental-management controllers/models/views, demo links, and
Sanctum dependency have been removed. There are no application endpoints under
`/api/*`. Admin authentication continues to use sessions and the `ADMIN` role.

Historical migrations are intentionally retained for deployment compatibility,
including the shared user/admin schema. No cleanup migration drops tables,
columns, accounts, roles, tokens, or existing records. Old rental data is not
exposed by the application. Do not run `migrate:fresh` on an existing database.
Previously saved event or contact content is also unchanged; review old
Tenant Pro promotional events in the admin before republishing them.

## Development and verification

Requires PHP 8.2+, Composer, and the project's supported Node/Vite environment.

```shell
composer install
npm ci
```

Copy `.env.example` to `.env`, configure the database and mail, and generate an
application key. On a new development database:

```shell
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan serve
npm run dev
```

Set `ADMIN_LOGIN_EMAIL` and a password of at least 12 characters in
`ADMIN_LOGIN_PASSWORD` before running the admin seeder. There is no default
admin password.

```shell
php artisan test
npm run build
composer validate --strict
```

See [GoDaddy deployment](DEPLOY_GODADDY.md) for production deployment and
cache refresh requirements.

## Content maintenance

Service descriptions are defined in `SiteController::serviceData()` and rendered
through shared service templates. The catalog distinguishes service capabilities
from delivered projects and does not promise fixed support periods or SLAs.
When changing service offerings, update desktop/mobile navigation, contact
options and validation, and `ServiceContentTest` together.
Services and products share a grouped mega-menu partial. Desktop menus support
hover, click, keyboard activation, Escape dismissal, and outside-click dismissal;
tablet/mobile navigation uses the scrollable compact menu.

The products page describes custom development options, not commercially
available software packages. Armely links are credited only as contributions
by a Starmax-associated developer, not Starmax-contracted work. Confirm delivery
scope and technologies with project owners before adding case-study claims.

Content references:

- [Core Web Vitals](https://web.dev/articles/vitals): loading, interaction, and layout stability.
- [WCAG 2.2](https://www.w3.org/TR/WCAG22/): accessibility guidance, not a certification claim.
- [Adaptive Android layouts](https://developer.android.com/develop/ui/compose/layouts/adaptive): device and window-size adaptation.

The broader homepage, portfolio-verification, and contact-field expansion brief
is outside this update's agreed services/products scope.
