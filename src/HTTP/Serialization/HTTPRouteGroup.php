<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\HTTP\Serialization;

use ErrorException;
use GuylianGilsing\PHPAbstractRouter\Collections\Ordering\OrderInterface;
use GuylianGilsing\PHPAbstractRouter\HTTP\Deserialization\RoutesDeserializer;
use GuylianGilsing\PHPAbstractRouter\HTTP\Validation\Middleware\MiddlewareValidationInterface;
use GuylianGilsing\PHPAbstractRouter\HTTP\Validation\Middleware\MiddlewareValidator;

final class HTTPRouteGroup implements HTTPRouteGroupInterface, OrderInterface
{
    private string $path = '';
    private int $order = 0;
    private string $classString = '';
    private string $classMethodCallback = '';

    /**
     * @var array<HTTPRouteInterface> $routes
     */
    private array $routes = [];

    /**
     * @var array<string> $middlewareStack
     */
    private array $middlewareStack = [];

    private ?MiddlewareValidationInterface $middlewareValidator = null;

    /**
     * @param string $path The route group path.
     * @param int $order The index at which this route has been registered in a
     * global combined stack of routes and route groups.
     * @param array<string> $middlewareStack An array of class strings.
     * @param MiddlewareValidationInterface $middlewareValidator A validator for the middleware stack class strings.
     */
    public function __construct(
        string $path,
        int $order,
        array $middlewareStack = [],
        MiddlewareValidationInterface $middlewareValidator = new MiddlewareValidator()
    ) {
        $this->path = $path;
        $this->order = $order;
        $this->middlewareStack = $middlewareStack;
        $this->middlewareValidator = $middlewareValidator;

        $this->validateMiddlewareArray($middlewareStack);
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getOrder(): int
    {
        return $this->order;
    }

    /**
     * @return array<string> An array of class strings.
     */
    public function getMiddlewareStack(): array
    {
        return $this->middlewareStack;
    }

    /**
     * @param HTTPRouteInterface $route The route that you want to check.
     */
    public function routeExists(HTTPRouteInterface $route): bool
    {
        return isset($this->routes[$route->getPath()]) &&
               isset($this->routes[$route->getPath()][$route->getMethod()]);
    }

    /**
     * @param HTTPRouteInterface $route The route that you want to add.
     */
    public function addRoute(HTTPRouteInterface $route): void
    {
        if ($this->routeExists($route))
        {
            throw new ErrorException('Given route already exists within route group.');
        }

        $this->registerKeyWithEmptyArrayIfNotExists($this->routes, $route->getPath());
        $this->routes[$route->getPath()][$route->getMethod()] = $route;
    }

    /**
     * @return array<HTTPRouteInterface>
     */
    public function getAllRoutes(): array
    {
        return RoutesDeserializer::deserialize($this->routes);
    }

    /**
     * Validate an array of class strings.
     *
     * @param array<string> $middlewareStack An array of class strings.
     */
    private function validateMiddlewareArray(array $middlewareStack): void
    {
        $this->middlewareValidator->validate($middlewareStack);

        if (!$this->middlewareValidator->isValid())
        {
            throw new ErrorException($this->middlewareValidator->getErrorMessages()[0]);
        }
    }

    /**
     * Registers a key => value pair inside an array if the key is not set. The value will always be an empty array.
     *
     * @param array<string> $array The array that needs to register the key.
     * @param string $key The key you want to register.
     */
    private function registerKeyWithEmptyArrayIfNotExists(array &$array, string $key): void
    {
        if (!isset($array[$key]))
        {
            $array[$key] = [];
        }
    }
}
