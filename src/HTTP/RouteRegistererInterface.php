<?php

declare(strict_types=1);

namespace PHPAbstractRouter\HTTP;

use PHPAbstractRouter\HTTP\Abstractions\HTTPRoute;
use PHPAbstractRouter\HTTP\Abstractions\HTTPRouteGroup;

/**
 * Interface for intermediary classes that act as a bridge between the abstract router and an actual backend.
 */
interface RouteRegistererInterface
{
    public function route(HTTPRoute $route): void;
    public function routeGroup(HTTPRouteGroup $group): void;
}
