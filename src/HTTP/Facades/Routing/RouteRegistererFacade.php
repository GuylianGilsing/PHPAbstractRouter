<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\HTTP\Facades\Routing;

use GuylianGilsing\PHPAbstractRouter\Collections\HTTP\HTTPRouteCollectionInterface;
use GuylianGilsing\PHPAbstractRouter\HTTP\Collecting\RouteAttributeCollectorInterface;
use GuylianGilsing\PHPAbstractRouter\HTTP\Serialization\HTTPRoute;
use GuylianGilsing\PHPAbstractRouter\HTTP\Serialization\HTTPRouteGroup;

final class RouteRegistererFacade
{
    private ?RouteAttributeCollectorInterface $routeAttributeCollector = null;
    private ?HTTPRouteCollectionInterface $routeCollection = null;
    private ?RouteRegisterOrder $orderHandler = null;

    public function __construct(
        RouteAttributeCollectorInterface $routeAttributeCollector,
        HTTPRouteCollectionInterface $routeCollection,
        RouteRegisterOrder $orderHandler
    ) {
        $this->routeAttributeCollector = $routeAttributeCollector;
        $this->routeCollection = $routeCollection;
        $this->orderHandler = $orderHandler;
    }

    /**
     * @param string $className The name to the class. This is the name of `YOUR_CLASS_NAME::class`.
     *
     * @throws ErrorException This exception is thrown if no class name is given.
     * @throws ErrorException This exception is thrown if the class does not exist.
     */
    public function fromClass(string $className): RouteRegistererFacade
    {
        $this->routeAttributeCollector->updateTotalRouteExtractedCount($this->orderHandler->getOrder());
        $routeCollection = $this->routeAttributeCollector->collectFromClassName($className);

        if ($routeCollection !== null)
        {
            $this->orderHandler->setOrder($routeCollection->getTotalRouteCount());
            $this->routeCollection->fromExistingCollection($routeCollection);
        }

        return $this;
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
        $this->orderHandler->add(1);
        $group = new HTTPRouteGroup($path, $this->orderHandler->getOrder(), $middlewareStack);

        $routeRegisterer = new GroupRouteRegistererFacade($group, $this->orderHandler->getOrder());
        call_user_func($callback, $routeRegisterer);

        $this->orderHandler->add($group->getTotalRouteCount());
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
