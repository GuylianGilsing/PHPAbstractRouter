<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\Tests\Integration\Mocks\Dispatching\HTTP;

use GuylianGilsing\PHPAbstractRouter\Collections\HTTP\HTTPRouteCollectionInterface;
use GuylianGilsing\PHPAbstractRouter\Dispatching\HTTP\HTTPRouteDispatcherInterface;
use PHPUnit\Framework\TestCase;

final class GroupRouteDispatcherMock extends TestCase implements HTTPRouteDispatcherInterface
{
    private ?HTTPRouteCollectionInterface $routeCollection = null;

    /**
     * Dispatches a list of HTTP route collections.
     *
     * @param array<HTTPRouteCollectionInterface> $routeCollections
     */
    public function dispatch(array $routeCollections): void
    {
        // Assert
        $this->assertNotNull($this->routeCollection);
        $this->assertEquals(1, count($routeCollections));

        $expectedRoutes = $this->routeCollection->getAllRoutes();
        $expectedRouteGroups = $this->routeCollection->getAllRouteGroups();

        $receivedRoutes = $routeCollections[0]->getAllRoutes();
        $receivedRouteGroups = $routeCollections[0]->getAllRouteGroups();

        $this->assertEquals(count($expectedRoutes), count($receivedRoutes));
        $this->assertEquals(count($expectedRouteGroups), count($receivedRouteGroups));
        $this->assertGreaterThan(0, count($receivedRouteGroups));

        $receivedRouteGroupRoutes = $receivedRouteGroups[0]->getAllRoutes();

        $routeCount = 0;
        foreach ($expectedRouteGroups[0]->getAllRoutes() as $route)
        {
            $this->assertEquals($route, $receivedRouteGroupRoutes[$routeCount]);
            $routeCount += 1;
        }
    }

    public function setExpectedData(HTTPRouteCollectionInterface $routeCollection)
    {
        $this->routeCollection = $routeCollection;
    }
}
