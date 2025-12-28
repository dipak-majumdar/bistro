# Bistro Banners Package

A dynamic banner management system for Laravel applications.

## Installation

```bash
composer require bistro/banners
```

## Usage

### 1. Register the Service Provider

Add to `config/app.php`:

```php
'providers' => [
    // ...
    Bistro\Banners\BannerServiceProvider::class,
],
```

### 2. Publish Assets

```bash
php artisan vendor:publish --provider="Bistro\Banners\BannerServiceProvider"
```

### 3. Run Migrations

```bash
php artisan migrate
```

### 4. Display Banners

In your Blade template:

```blade
@include('banners::home-banners')
```

Or use the component:

```blade
<x-banners::home-banners />
```

## Features

- Dynamic banner management
- Multiple positions (home, category, product)
- Responsive images (desktop/mobile)
- Scheduled publishing
- Sort order control
- Admin CRUD interface

## Configuration

Publish the config file:

```bash
php artisan vendor:publish --tag=banners-config
```

Edit `config/banners.php` to customize settings.

## Admin Routes

- `/admin/banners` - Index
- `/admin/banners/create` - Create
- `/admin/banners/{id}/edit` - Edit
- `/admin/banners/{id}` - Show
- `/admin/banners/{id}/toggle` - Toggle status

## License

MIT
