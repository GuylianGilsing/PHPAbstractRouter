<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\HTTP\Facades\Routing;

use GuylianGilsing\PHPAbstractRouter\Collections\HTTP\HTTPRouteCollection;
use GuylianGilsing\PHPAbstractRouter\Collections\HTTP\HTTPRouteCollectionInterface;
use GuylianGilsing\PHPAbstractRouter\Dispatching\HTTP\HTTPRouteDispatcherInterface;
use GuylianGilsing\PHPAbstractRouter\HTTP\Collecting\RouteAttributeCollector;
use GuylianGilsing\PHPAbstractRouter\HTTP\Collecting\RouteAttributeCollectorInterface;

final class RouterFacade
{
    /**
     * @var array<HTTPRouteCollectionInterface> $routeCollections
     */
    private array $routeCollections = [];
    private ?HTTPRouteCollectionInterface $internalRouteCollection = null;
    private ?RouteRegisterOrder $orderHandler = null;
    private ?RouteRegistererFacade $routeRegisterer = null;
    private ?HTTPRouteDispatcherInterface $routeDispatcher = null;

    public function __construct(
        HTTPRouteDispatcherInterface $routeDispatcher,
        RouteAttributeCollectorInterface $routeAttributeCollector = new RouteAttributeCollector()
    ) {
        $this->routeDispatcher = $routeDispatcher;
        $this->routeAttributeCollector = $routeAttributeCollector;

        $this->internalRouteCollection = new HTTPRouteCollection();
        $this->orderHandler = new RouteRegisterOrder();
        $this->routeRegisterer = new RouteRegistererFacade($routeAttributeCollector, $this->internalRouteCollection, $this->orderHandler);
    }

    public function register(): RouteRegistererFacade
    {
        return $this->routeRegisterer;
    }

    /**
     * Dispatches all registered routes.
     */
    public function dispatch(): void
    {
        if ($this->internalRouteCollection->getTotalRouteCount() > 0)
        {
            $this->routeCollections[] = $this->internalRouteCollection;
        }

        $this->routeDispatcher->dispatch($this->routeCollections);
    }
}
