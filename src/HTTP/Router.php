<?php

declare(strict_types=1);

namespace PHPAbstractRouter\HTTP;

use PHPAbstractRouter\HTTP\Abstractions\HTTPRoute;
use PHPAbstractRouter\HTTP\Abstractions\HTTPRouteGroup;
use PHPAbstractRouter\HTTP\Attributes\Collecting\RouteAttributeCollectorInterface;

final class Router
{
    private RouteRegistererInterface $routerRegisterer;
    private RouteAttributeCollectorInterface $routeAttributeCollector;

    public function __construct(
        RouteRegistererInterface $routerRegisterer,
        RouteAttributeCollectorInterface $routeAttributeCollector
    ) {
        $this->routerRegisterer = $routerRegisterer;
        $this->routeAttributeCollector = $routeAttributeCollector;
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
     * Registers routes from a controller class.
     *
     * @param string $className The `CLASS_NAME_HERE::class` string.
     */
    public function controller(string $className): void
    {
        $extractedRoutes = $this->routeAttributeCollector->fromClass($className);

        foreach ($extractedRoutes as $extractedRoute)
        {
            if ($extractedRoute instanceof HTTPRoute)
            {
                $this->routerRegisterer->route($extractedRoute);
            }
            elseif ($extractedRoute instanceof HTTPRouteGroup)
            {
                $this->routerRegisterer->routeGroup($extractedRoute);
            }
        }
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
        $this->routerRegisterer->route($route);
    }
}
