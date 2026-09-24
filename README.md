# FÉM Stúdió

The landing page and admin area for FÉM, a fictional industrial design studio in Budapest. The public page follows the supplied Figma design. The admin area manages the hero section and the references, and receives contact messages.

## Tech stack

- PHP 8.3+ (developed on 8.4) and Laravel 13
- Blade components, Tailwind CSS v4 and Vite
- SQLite
- Pest for tests and Laravel Pint for code style

## Main features

**Public site**

- Responsive landing page with a header, hero, references ("Munkáink") and footer
- Hero and references are loaded from the database, with the Figma content as a fallback
- Contact modal with an asynchronous form, Hungarian validation messages and rate limiting

**Admin area** (HTTP Basic authentication; routes `/admin/hero`, `/admin/references` and `/admin/messages`)

- Edit the hero title, description and background image
- Create, list, edit and delete references (title, cover image, date)
- Contact message inbox, newest first
- CSV export of all messages (UTF-8, Excel-compatible)
- E-mail notification to the configured administrator addresses for each new message

## Requirements

- PHP 8.3+ with the `sqlite` and `gd` extensions
- Composer
- Node.js 20.19+ or 22.12+ (required by Vite 8)

## Installation

```bash
git clone https://github.com/apolloniiaa/laravel-probafeladat.git fem
cd fem

composer install
npm install

cp .env.example .env
php artisan key:generate

touch database/database.sqlite
php artisan migrate
php artisan storage:link

npm run build
```

Set the notification recipients in `.env` (comma-separated). With the default `MAIL_MAILER=log`, the e-mails are written to `storage/logs/laravel.log`:

```dotenv
MAIL_ADMIN_ADDRESSES=admin@example.com
```

Create an administrator account for the admin area:

```bash
php artisan tinker --execute="App\Models\User::create(['name' => 'Admin', 'email' => 'admin@example.com', 'password' => 'password'])"
```

Start the application with `php artisan serve` (or through Laravel Herd), then open `/` for the site and `/admin/hero` for the admin area. The browser displays an HTTP Basic Authentication login prompt; enter the e-mail address and password above there.

Run the tests with:

```bash
php artisan test
```

## Admin access

The administrator account and these credentials are created by running the Tinker command in the Installation section.

- Admin URL: `/admin/hero`
- E-mail: `admin@example.com`
- Password: `password`

The same credentials give access to the References and Messages sections of the admin area.
