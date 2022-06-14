<?php

declare(strict_types=1);

namespace PHPAbstractRouter\Tests\Integration\Mocks;

use PHPAbstractRouter\HTTP\Abstractions\HTTPRoute;
use PHPAbstractRouter\HTTP\Abstractions\HTTPRouteGroup;
use PHPAbstractRouter\HTTP\BackendRouteRegistererInterface;

final class MockBackendRouteRegisterer implements BackendRouteRegistererInterface
{
    /**
     * @var array<HTTPRoute|HTTPRouteGroup> $arrayRef
     */
    private array $routes = [];

    public function route(HTTPRoute $route): void
    {
        $this->routes[] = $route;
    }

    public function routeGroup(HTTPRouteGroup $group): void
    {
        $this->routes[] = $group;
    }

    public function getRegisteredRoutes(): array
    {
        return $this->routes;
    }
}
