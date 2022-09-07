[![Latest Version on Packagist](https://img.shields.io/packagist/v/masoudi/laravel-visitors.svg?style=flat)](https://packagist.org/packages/masoudi/laravel-visitors)
[![Total Downloads](https://img.shields.io/packagist/dt/masoudi/laravel-visitors.svg?style=flat)](https://packagist.org/packages/masoudi/laravel-visitors)
[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg?style=flat)](https://opensource.org/licenses/MIT)

Laravel Visitors
========================
Laravel package to tracking visitors

## Installation

Install package via Composer
```bash
composer require masoudi/laravel-visitors
```

Publish and migrate migration
```bash
php artisan vendor:publish --tag=masoudi-laravel-visitors
```

Prepaire model to working with visitors
```php
use Masoudi\Laravel\Visitors\Contracts\Visitable;
use Masoudi\Laravel\Visitors\Traits\InteractsWithVisitor;

class Article extends Model implements Visitable
{
    use InteractsWithVisitor;
}
```

## How to user
Documentation will be ready soon :)

[CHANGELOG](CHANGELOG.md) • [LICENSE](LICENSE.md)
