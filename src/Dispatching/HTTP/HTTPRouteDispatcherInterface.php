<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\Dispatching\HTTP;

use GuylianGilsing\PHPAbstractRouter\Collections\HTTP\HTTPRouteCollectionInterface;

interface HTTPRouteDispatcherInterface
{
    /**
     * Dispatches a list of HTTP route collections.
     *
     * @param array<HTTPRouteCollectionInterface> $routeCollections
     */
    public function dispatch(array $routeCollections): void;
}
