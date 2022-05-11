<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\HTTP\Facades\Routing;

use GuylianGilsing\PHPAbstractRouter\HTTP\Serialization\HTTPRoute;
use GuylianGilsing\PHPAbstractRouter\HTTP\Serialization\HTTPRouteGroupInterface;

final class GroupRouteRegistererFacade
{
    private ?HTTPRouteGroupInterface $group = null;
    private int $currentOrder = 0;

    public function __construct(HTTPRouteGroupInterface $group, int $order = 0)
    {
        $this->group = $group;
        $this->currentOrder = $order;
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
    ): GroupRouteRegistererFacade {
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
    ): GroupRouteRegistererFacade {
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
    ): GroupRouteRegistererFacade {
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
    ): GroupRouteRegistererFacade {
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
    ): GroupRouteRegistererFacade {
        $this->registerRoute('OPTIONS', $path, $classString, $classMethod, $middlewareStack);
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
        $this->currentOrder += 1;

        $route = new HTTPRoute($method, $path, $this->currentOrder, $classString, $classMethod, $middlewareStack);
        $this->group->addRoute($route);
    }
}
