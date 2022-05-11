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
    private ?RouteAttributeCollectorInterface $routeAttributeCollector = null;

    public function __construct(
        HTTPRouteDispatcherInterface $routeDispatcher,
        RouteAttributeCollectorInterface $routeAttributeCollector = new RouteAttributeCollector()
    ) {
        $this->routeDispatcher = $routeDispatcher;
        $this->routeAttributeCollector = $routeAttributeCollector;

        $this->internalRouteCollection = new HTTPRouteCollection();
        $this->orderHandler = new RouteRegisterOrder();
        $this->routeRegisterer = new RouteRegistererFacade($this->internalRouteCollection, $this->orderHandler);
    }

    /**
     * @param string $className The name to the class. This is the name of `YOUR_CLASS_NAME::class`.
     *
     * @throws ErrorException This exception is thrown if no class name is given.
     * @throws ErrorException This exception is thrown if the class does not exist.
     */
    public function fromClass(string $className): void
    {
        $routeCollection = $this->routeAttributeCollector->collectFromClassName($className);

        if ($routeCollection !== null)
        {
            $this->orderHandler->setOrder($routeCollection->getTotalRouteCount());
            $this->routeCollections[] = $routeCollection;
        }
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
