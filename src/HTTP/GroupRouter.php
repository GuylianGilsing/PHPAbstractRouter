<?php

declare(strict_types=1);

namespace PHPAbstractRouter\HTTP;

use PHPAbstractRouter\HTTP\Abstractions\HTTPRoute;
use PHPAbstractRouter\HTTP\Abstractions\HTTPRouteGroup;

final class GroupRouter
{
    private HTTPRouteGroup $group;

    public function __construct(HTTPRouteGroup $group)
    {
        $this->group = $group;
    }

    /**
     * Registers an HTTP GET route.
     *
     * @param string $path The path/url of the route.
     * @param string $className The `CLASS_NAME_HERE::class` string.
     * @param string $classMethod The name of the method inside the class that you want to tie to this route.
     * (Use an empty string to use the class's magic methods.)
     * @param array<string> $middlewareStack An array of `CLASS_NAME_HERE::class` strings.
     * Middleware will be invoked through class magic methods,
     */
    public function get(
        string $path,
        string $className,
        string $classMethod = '',
        array $middlewareStack = []
    ): void {
        $this->registerRoute('GET', $path, $className, $classMethod, $middlewareStack);
    }

    /**
     * Registers an HTTP POST route.
     *
     * @param string $path The path/url of the route.
     * @param string $className The `CLASS_NAME_HERE::class` string.
     * @param string $classMethod The name of the method inside the class that you want to tie to this route.
     * (Use an empty string to use the class's magic methods.)
     * @param array<string> $middlewareStack An array of `CLASS_NAME_HERE::class` strings.
     * Middleware will be invoked through class magic methods,
     */
    public function post(
        string $path,
        string $className,
        string $classMethod = '',
        array $middlewareStack = []
    ): void {
        $this->registerRoute('POST', $path, $className, $classMethod, $middlewareStack);
    }

    /**
     * Registers an HTTP PUT route.
     *
     * @param string $path The path/url of the route.
     * @param string $className The `CLASS_NAME_HERE::class` string.
     * @param string $classMethod The name of the method inside the class that you want to tie to this route.
     * (Use an empty string to use the class's magic methods.)
     * @param array<string> $middlewareStack An array of `CLASS_NAME_HERE::class` strings.
     * Middleware will be invoked through class magic methods,
     */
    public function put(
        string $path,
        string $className,
        string $classMethod = '',
        array $middlewareStack = []
    ): void {
        $this->registerRoute('PUT', $path, $className, $classMethod, $middlewareStack);
    }

    /**
     * Registers an HTTP DELETE route.
     *
     * @param string $path The path/url of the route.
     * @param string $className The `CLASS_NAME_HERE::class` string.
     * @param string $classMethod The name of the method inside the class that you want to tie to this route.
     * (Use an empty string to use the class's magic methods.)
     * @param array<string> $middlewareStack An array of `CLASS_NAME_HERE::class` strings.
     * Middleware will be invoked through class magic methods,
     */
    public function delete(
        string $path,
        string $className,
        string $classMethod = '',
        array $middlewareStack = []
    ): void {
        $this->registerRoute('DELETE', $path, $className, $classMethod, $middlewareStack);
    }

    /**
     * Registers an HTTP OPTIONS route.
     *
     * @param string $path The path/url of the route.
     * @param string $className The `CLASS_NAME_HERE::class` string.
     * @param string $classMethod The name of the method inside the class that you want to tie to this route.
     * (Use an empty string to use the class's magic methods.)
     * @param array<string> $middlewareStack An array of `CLASS_NAME_HERE::class` strings.
     * Middleware will be invoked through class magic methods,
     */
    public function options(
        string $path,
        string $className,
        string $classMethod = '',
        array $middlewareStack = []
    ): void {
        $this->registerRoute('OPTIONS', $path, $className, $classMethod, $middlewareStack);
    }

    /**
     * Registeres the route with the intermediary class.
     *
     * @param string $method The route's HTTP method.
     * @param string $path The path/url of the route.
     * @param string $className The `CLASS_NAME_HERE::class` string.
     * @param string $classMethod The name of the method inside the class that you want to tie to this route.
     * (Use an empty string to use the class's magic methods.)
     * @param array<string> $middlewareStack An array of `CLASS_NAME_HERE::class` strings.
     * Middleware will be invoked through class magic methods,
     */
    private function registerRoute(
        string $method,
        string $path,
        string $className,
        string $classMethod = '',
        array $middlewareStack = []
    ): void {
        $route = new HTTPRoute($method, $path, $className, $classMethod, $middlewareStack);
        $this->group->addRoute($route);
    }
}
