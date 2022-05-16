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
        - [Dispatching routes](#dispatching-routes)
        - [Writing a custom dispatcher](#writing-a-custom-dispatcher)

<!-- /TOC -->

## What is this exactly?
PHPAbstractRouter is a framework agnostic router that lets you define routes manually, or through attributes. It is up to the person using this package to create a custom dispatcher class that actually bridges the abstract router with their framework/library of choice.

## Installation
```bash
$ composer require guyliangilsing/php-abstract-router
```

## Usage
### Defining routes manually
You can manually define routes through the `RouterFacade`:
```php
use GuylianGilsing\PHPAbstractRouter\HTTP\Facades\Routing\RouterFacade;

$dispatcher = // Your custom dispatcher here...
$router = new RouterFacade($dispatcher);

// Without chaining
$router->register()->get('/', MyController::class,'renderIndex');
$router->register()->get('/about', MyController::class, 'renderAbout');

// With chaining
$router->register()->get('/', MyController::class,'renderIndex')
                    ->get('/about', MyController::class, 'renderAbout');
```

### Defining routes through attributes
You can define your routes inside classes through attributes:
```php
use GuylianGilsing\PHPAbstractRouter\HTTP\GET;
use GuylianGilsing\PHPAbstractRouter\HTTP\Group;
use GuylianGilsing\PHPAbstractRouter\HTTP\POST;

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
use GuylianGilsing\PHPAbstractRouter\HTTP\Facades\Routing\RouterFacade;

$dispatcher = // Your custom dispatcher here...
$router = new RouterFacade($dispatcher);

// Without chaining
$router->register()->fromClass(MyController::class);
```

### Defining group routes
Group routes can be defined through the `GroupRouteRegistererFacade` facade:
```php
use GuylianGilsing\PHPAbstractRouter\HTTP\Facades\Routing\RouterFacade;
use GuylianGilsing\PHPAbstractRouter\HTTP\Facades\Routing\GroupRouteRegistererFacade;

$dispatcher = // Your custom dispatcher here...
$router = new RouterFacade($dispatcher);

$router->register()->group('/test', function(GroupRouteRegistererFacade $group) {
    $group->get('', MyController::class, 'renderIndex');
    $group->get('/about', MyController::class, 'renderAbout');
});
```

### Dispatching routes
Dispatching routes basically means to register the collected routes with your framework/library of choice. Dispatching can be done through the `dispatch()` method that is present on the `RouterFacade`:
```php
use GuylianGilsing\PHPAbstractRouter\HTTP\Facades\Routing\RouterFacade;

$dispatcher = // Your custom dispatcher here...
$router = new RouterFacade($dispatcher);

// Register your routes here...

$router->dispatch();
```

### Writing a custom dispatcher
Dispatchers only have to implement the `HTTPRouteDispatcherInterface` interface to work with the abstract router:
```php
use GuylianGilsing\PHPAbstractRouter\Dispatching\HTTP\HTTPRouteDispatcherInterface;

final class MyDispatcher implements HTTPRouteDispatcherInterface
{
    /**
     * Dispatches a list of HTTP route collections.
     *
     * @param array<HTTPRouteCollectionInterface> $routeCollections
     */
    public function dispatch(array $routeCollections): void
    {
        // Your registration logic here...
    }
}
```

When the `dispatch()` method on the `RouterFacade` class is being called, it will send an array of `HTTPRouteCollectionInterface` to the dispatcher. Each collection contains all registered routes.
