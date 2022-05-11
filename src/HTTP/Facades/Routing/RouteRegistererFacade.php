<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\HTTP\Facades\Routing;

use GuylianGilsing\PHPAbstractRouter\Collections\HTTP\HTTPRouteCollectionInterface;
use GuylianGilsing\PHPAbstractRouter\HTTP\Serialization\HTTPRoute;
use GuylianGilsing\PHPAbstractRouter\HTTP\Serialization\HTTPRouteGroup;

final class RouteRegistererFacade
{
    private ?HTTPRouteCollectionInterface $routeCollection = null;
    private ?RouteRegisterOrder $orderHandler = null;

    public function __construct(HTTPRouteCollectionInterface $routeCollection, RouteRegisterOrder $orderHandler)
    {
        $this->routeCollection = $routeCollection;
        $this->orderHandler = $orderHandler;
    }

    /**
     * Validate an array of class strings.
     *
     * @param array<string> $middlewareStack An array of class strings.
     */
    public function get(
        string $path,
        string $classString,
        string $classMethod,
        array $middlewareStack = []
    ): RouteRegistererFacade {
        $this->registerRoute('GET', $path, $classString, $classMethod, $middlewareStack);
        return $this;
    }

    /**
     * Validate an array of class strings.
     *
     * @param array<string> $middlewareStack An array of class strings.
     */
    public function post(
        string $path,
        string $classString,
        string $classMethod,
        array $middlewareStack = []
    ): RouteRegistererFacade {
        $this->registerRoute('POST', $path, $classString, $classMethod, $middlewareStack);
        return $this;
    }

    /**
     * Validate an array of class strings.
     *
     * @param array<string> $middlewareStack An array of class strings.
     */
    public function put(
        string $path,
        string $classString,
        string $classMethod,
        array $middlewareStack = []
    ): RouteRegistererFacade {
        $this->registerRoute('PUT', $path, $classString, $classMethod, $middlewareStack);
        return $this;
    }

    /**
     * Validate an array of class strings.
     *
     * @param array<string> $middlewareStack An array of class strings.
     */
    public function delete(
        string $path,
        string $classString,
        string $classMethod,
        array $middlewareStack = []
    ): RouteRegistererFacade {
        $this->registerRoute('DELETE', $path, $classString, $classMethod, $middlewareStack);
        return $this;
    }

    /**
     * Validate an array of class strings.
     *
     * @param array<string> $middlewareStack An array of class strings.
     */
    public function options(
        string $path,
        string $classString,
        string $classMethod,
        array $middlewareStack = []
    ): RouteRegistererFacade {
        $this->registerRoute('OPTIONS', $path, $classString, $classMethod, $middlewareStack);
        return $this;
    }

    /**
     * Validate an array of class strings.
     *
     * @param array<string> $middlewareStack An array of class strings.
     */
    public function group(string $path, callable $callback, array $middlewareStack = []): RouteRegistererFacade
    {
        $group = new HTTPRouteGroup($path, 0, $middlewareStack);

        $routeRegisterer = new GroupRouteRegistererFacade($group, 0);
        call_user_func($callback, $routeRegisterer);

        $this->routeCollection->addRouteGroup($group);
        return $this;
    }

    /**
     * Validate an array of class strings.
     *
     * @param array<string> $middlewareStack An array of class strings.
     */
    private function registerRoute(
        string $method,
        string $path,
        string $classString,
        string $classMethod,
        array $middlewareStack = []
    ): void {
        $this->orderHandler->add(1);

        $route = new HTTPRoute(
            $method,
            $path,
            $this->orderHandler->getOrder(),
            $classString,
            $classMethod,
            $middlewareStack
        );

        $this->routeCollection->addRoute($route);
    }
}
