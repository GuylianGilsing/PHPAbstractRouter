<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\HTTP\Collecting\Creators;

use GuylianGilsing\PHPAbstractRouter\Collections\HTTP\HTTPRouteCollectionInterface;

interface RouteCollectionCreatorInterface
{
    /**
     * @param array<HTTPRouteInterface|HTTPRouteGroupInterface> $routes
     *
     * @return ?HTTPRouteCollectionInterface Returns a route collection when there are routes passed, null otherwise.
     */
    public function create(array $routes): ?HTTPRouteCollectionInterface;
}
