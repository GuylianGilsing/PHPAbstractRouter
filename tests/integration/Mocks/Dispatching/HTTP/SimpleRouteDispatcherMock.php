<?php
namespace GuylianGilsing\PHPAbstractRouter\Tests\Integration\Mocks\Dispatching\HTTP;

use ErrorException;
use GuylianGilsing\PHPAbstractRouter\Collections\HTTP\HTTPRouteCollectionInterface;
use GuylianGilsing\PHPAbstractRouter\Dispatching\HTTP\HTTPRouteDispatcherInterface;
use PHPUnit\Framework\TestCase;

final class SimpleRouteDispatcherMock extends TestCase implements HTTPRouteDispatcherInterface
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

        $routeCount = 0;
        foreach ($this->routeCollection->getAllRoutes() as $route)
        {
            $this->assertEquals($route, $receivedRoutes[$routeCount]);
            $routeCount += 1;
        }
    }

    public function setExpectedData(HTTPRouteCollectionInterface $routeCollection)
    {
        $this->routeCollection = $routeCollection;
    }
}
