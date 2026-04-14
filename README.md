# ChildrensWorld

Laravel-based charity platform with multilingual public pages (EN/RU/KY), donation flow via QR, and a basic content management backend.

## Stack

- PHP 8.2+
- Laravel 12
- Blade + Tailwind CSS
- Vite
- MySQL (primary) / SQLite for tests

## Current Features

- Public website pages: Home, About, Programs, Children, Events, Blog, Reports, Contact, Donate, FAQ, Privacy, Terms
- Language switching: `EN`, `RU`, `KY`
- Donation flow:
  - donation intent creation
  - QR payload screen
  - sandbox paid action
  - webhook endpoint scaffold
- Basic CMS backend:
  - pages list/create/edit in dashboard
  - per-locale page translations

## Local Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install
```

## Run Locally

```bash
php artisan serve
npm run dev
```

## Build and Test

```bash
npm run build
php artisan test
```

## Important Paths

- Routes: `routes/web.php`
- Public layout: `resources/views/layouts/public.blade.php`
- Public pages: `resources/views/pages`
- CMS pages: `resources/views/admin/pages`
- Translations: `lang/en`, `lang/ru`, `lang/ky`
- Donation config: `config/donation.php`
- Migrations: `database/migrations`
