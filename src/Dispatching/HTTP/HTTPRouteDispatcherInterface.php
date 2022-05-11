<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\Dispatching\HTTP;

interface HTTPRouteDispatcherInterface
{
    /**
     * Dispatches a list of HTTP route collections.
     *
     * @param array<HTTPRouteCollectionInterface> $routeCollections
     */
    public function dispatch(array $routeCollections): void;
}
