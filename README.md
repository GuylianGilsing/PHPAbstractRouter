# PHPAbstractRouter
A simple package that provides you with a framework agnostic router.

## Table of contents
<!-- TOC -->

- [PHPAbstractRouter](#phpabstractrouter)
    - [Table of contents](#table-of-contents)
    - [What is this exactly?](#what-is-this-exactly)
    - [Installation](#installation)
    - [Usage](#usage)
        - [Defining routes manually](#defining-routes-manually)
        - [Defining routes through attributes](#defining-routes-through-attributes)
        - [Defining group routes](#defining-group-routes)
        - [Integrating a routing backend](#integrating-a-routing-backend)

<!-- /TOC -->

## What is this exactly?
PHPAbstractRouter is a framework agnostic router that lets you define routes manually, or through attributes. It is up to the person using this package to provide the router with an actual routing backend. A backend could be a framework (like slim 4), or an actual router (like FastRoute).

## Installation
```bash
$ composer require guyliangilsing/php-abstract-router
```

## Usage
### Defining routes manually
You can manually define routes through the `Router` class:
```php
use use PHPAbstractRouter\HTTP\Router;;

$routeRegisterer = // Your bridge class...
$router = new Router($routeRegisterer);

$router->get('/', MyController::class,'renderIndex');
$router->get('/about', MyController::class, 'renderAbout');
```

### Defining routes through attributes
You can define your routes inside classes through attributes:
```php
use PHPAbstractRouter\HTTP\Attributes\GET;
use PHPAbstractRouter\HTTP\Attributes\Group;
use PHPAbstractRouter\HTTP\Attributes\POST;

#[Group('/test')]
final class MyController
{
    #[GET('/')]
    public function renderIndex(): string
    {
        return "index.php";
    }

    #[POST('/')]
    public function indexPOST(): string
    {
        return "POST index.php";
    }

    #[GET('/about')]
    public function renderAbout(): string
    {
        return "about.php";
    }

    #[POST('/about')]
    public function aboutPOST(): string
    {
        return "POST about.php";
    }
}
```

Once you have defined your routes, you then can let the `RouterFacade` collect them:
```php
use use PHPAbstractRouter\HTTP\Router;;

$routeRegisterer = // Your bridge class...
$router = new Router($routeRegisterer);

$router->fromClass(MyController::class);
```

### Defining group routes
Group routes can be defined through the `GroupRouter` class:
```php
use PHPAbstractRouter\HTTP\GroupRouter;
use PHPAbstractRouter\HTTP\Router;

$dispatcher = // Your custom dispatcher here...
$router = new RouterFacade($dispatcher);

$router->group('/test', function(GroupRouter $group) {
    $group->get('', MyController::class, 'renderIndex');
    $group->get('/about', MyController::class, 'renderAbout');
});
```

### Integrating a routing backend
To integrate your preferred routing backend, you only have to implement the `BackendRouteRegistererInterface` interface:

```php
use PHPAbstractRouter\HTTP\BackendRouteRegistererInterface;

final class BackendRouteRegisterer implements BackendRouteRegistererInterface
{
    public function route(HTTPRoute $route): void
    {
        // Todo:: Implement your registration logic here...
    }

    public function routeGroup(HTTPRouteGroup $group): void
    {
        // Todo:: Implement your registration logic here...
    }
}
```

Once you have implemented this interface, you can pass it to the `Router` class through its constructor.
