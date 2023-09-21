[![Latest Version on Packagist](https://img.shields.io/packagist/v/masoudi/laravel-visitors.svg?style=flat)](https://packagist.org/packages/masoudi/laravel-visitors)
[![Total Downloads](https://img.shields.io/packagist/dt/masoudi/laravel-visitors.svg?style=flat)](https://packagist.org/packages/masoudi/laravel-visitors)
[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg?style=flat)](https://opensource.org/licenses/MIT)

<img style="display:block;width: 90%; margin: 1rem auto; max-width: 600px; height: auto; border-radius: 1rem" src="https://github.com/rezamasoudi/laravel-visitors/assets/109284641/e2e56ec9-794c-4fd6-96a3-6125c64cf9ab">

# Laravel Visitors

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

```bash
php artisan migrate
```

Prepare model to working with visitors

```php
use Masoudi\Laravel\Visitors\Contracts\Visitable;
use Masoudi\Laravel\Visitors\Traits\InteractsWithVisitors;

class Article extends Model implements Visitable
{
    use InteractsWithVisitors;
}
```

# Documentation

- [Interact with all visitors](#interact-with-all-visitors)
- [Interact with model visitors](#interact-with-model-visitors)
- [Interact with A specific model visitors](#interact-with-a-specific-model-visitors)
- [Visit A model](#visit-a-model)
- [Visit a request](#visit-a-request)
- [Visit by add middleware](#Visit-by-add-middleware)
- [Retrieve visitors between two time](#retrieve-visitors-between-two-time)
- [Retrieve visitors by user id](#retrieve-visitors-by-user-id)
- [Retrieve visitors by platform name](#retrieve-visitors-by-platform-name)
- [Retrieve visitors by browser name](#retrieve-visitors-by-browser-name)
- [Retrieve visitors by IP start range](#retrieve-visitors-by-ip-start-range)
- [Retrieve visitors by IP end range](#retrieve-visitors-by-ip-end-range)
- [Retrieve visitors by referrers urls](#retrieve-visitors-by-referrers-urls)
- [Retrieve visitors by visit urls](#retrieve-visitors-by-visit-urls)

## Interact with all visitors

The function `visitors()` returns a query builder of all visitors so you can work with that as below

```php
$totalVisits = visitors()->count();

// Get ip unique count 
$totalUniqueVisits = visitors()->uniqueCount();
```

## Interact with model visitors

Every model that has used `InteractsWithVisitors` trait has a static method that returns a query builder specific to the
visitors of that model.

```php
$articlesVisitors = Article::visitors()->get();
```

## Interact with A specific model visitors

Every model that has used `InteractsWithVisitors` trait has a public method that returns a query builder specific to the
visitors of that model.

```php
$article = Article::find(1);
$visitors = $article->visitors()->get();
```

## Visit a model

```php
$article = Article::find(1);

# visit model
$article->visit();
```

## Visit a request

```php
class PostController extends Controller {

    function index(Request $request){
    
        $request->visit();
        
        // Another codes ...
    }
}
```

## Visit by add middleware

After add `visitor` middleware to a route or group route when that route called , a visit will be created for that
routes

```php
// routes/web.php
Route::middleware("visitor")->get("/support", "PageController@support");

Route::middleware("visitor")->group(function (){
        Route::get("posts/{slug}", "PostController@index");
        Route::get("articles/{slug}", "ArticleController@index");
});
```

## Retrieve visitors by user id

```php
$visiCount = visitors()->authId(auth()->id())->count();
```

## Retrieve visitors between two time

```php
$startTime = Carbon::now()->startOfMonth()->toDateTime();
$endTime  = Carbon::now()->toDateTime();

$visiCount = visitors()->range($startTime, $endTime)->count();
```

## Retrieve visitors by platform name

```php
use Masoudi\Laravel\Visitors\Contracts\VisitorPlatform;

$visiCount = visitors()->platform(VisitorPlatform::ANDROID)->count();
```

## Retrieve visitors by browser name

```php
use Masoudi\Laravel\Visitors\Contracts\VisitorBrowser;

$visiCount = visitors()->browser(VisitorBrowser::CHROME)->count();
```

## Retrieve visitors by IP start range

```php
$visiCount = visitors()->ipStarts('127.0')->count();
```

## Retrieve visitors by IP end range

```php
$visiCount = visitors()->ipEnds('0.1')->count();
```

## Retrieve visitors by referrers urls

```php
$visiCount = visitors()->referrers('https://google.com', 'https://facebook.com')->count();
```

## Retrieve visitors by visit urls

```php
$visiCount = visitors()->paths('/support', '/articles/any-slug')->count();
```

[CHANGELOG](CHANGELOG.md) • [LICENSE](LICENSE.md)
