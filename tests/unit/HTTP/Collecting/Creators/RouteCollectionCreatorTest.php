<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\Tests\Unit\HTTP\Collecting\Creators;

use GuylianGilsing\PHPAbstractRouter\HTTP\Collecting\Creators\RouteCollectionCreator;
use GuylianGilsing\PHPAbstractRouter\HTTP\Collecting\Creators\RouteCollectionCreatorInterface;
use GuylianGilsing\PHPAbstractRouter\HTTP\Serialization\HTTPRoute;
use GuylianGilsing\PHPAbstractRouter\HTTP\Serialization\HTTPRouteGroup;
use PHPUnit\Framework\TestCase;

final class RouteCollectionCreatorTest extends TestCase
{
    public function testIfCanCreateOnlyGroupCollection(): void
    {
        // Arrange
        $collectionCreator = $this->getRouteCollectionCreator();
        
        // Create group 1
        $group1 = new HTTPRouteGroup('/test1', 1);
        $route1 = new HTTPRoute('GET', '/1', 3, '', '');
        $route2 = new HTTPRoute('GET', '/2', 4, '', '');

        $group1->addRoute($route1);
        $group1->addRoute($route2);
        
        // Create group 2
        $group2 = new HTTPRouteGroup('/test2', 2);
        $route3 = new HTTPRoute('GET', '/3', 5, '', '');
        $route4 = new HTTPRoute('GET', '/4', 6, '', '');

        $group2->addRoute($route3);
        $group2->addRoute($route4);
        
        $routes = [
            $group1,
            $group2,
        ];

        // Act
        $routeCollection = $collectionCreator->create($routes);

        // Assert
        $collectionGroups = $routeCollection->getAllRouteGroups();
        $this->assertNotEmpty($collectionGroups);
        $this->assertEquals(2, count($collectionGroups));

        $collecrionRoutes = $routeCollection->getAllRoutes();
        $this->assertEmpty($collecrionRoutes);
    }

    public function testIfCanCreateOnlyRouteCollection(): void
    {
        // Arrange
        $collectionCreator = $this->getRouteCollectionCreator();
        
        $route1 = new HTTPRoute('GET', '/1', 3, '', '');
        $route2 = new HTTPRoute('GET', '/2', 4, '', '');
        $route3 = new HTTPRoute('GET', '/3', 5, '', '');
        $route4 = new HTTPRoute('GET', '/4', 6, '', '');
        
        $routes = [
            $route1,
            $route2,
            $route3,
            $route4,
        ];

        // Act
        $routeCollection = $collectionCreator->create($routes);

        // Assert
        $collectionGroups = $routeCollection->getAllRouteGroups();
        $this->assertEmpty($collectionGroups);

        $collectionRoutes = $routeCollection->getAllRoutes();
        $this->assertNotEmpty($collectionRoutes);
        $this->assertEquals(4, count($collectionRoutes));
    }

    public function testIfCanCreateComplexCollection(): void
    {
        // Arrange
        $collectionCreator = $this->getRouteCollectionCreator();
        
        // Create group 1
        $group1 = new HTTPRouteGroup('/test1', 1);
        $route1 = new HTTPRoute('GET', '/1', 3, '', '');
        $route2 = new HTTPRoute('GET', '/2', 4, '', '');

        $group1->addRoute($route1);
        $group1->addRoute($route2);
        
        // Create group 2
        $group2 = new HTTPRouteGroup('/test2', 2);
        $route3 = new HTTPRoute('GET', '/3', 5, '', '');
        $route4 = new HTTPRoute('GET', '/4', 6, '', '');

        $group2->addRoute($route3);
        $group2->addRoute($route4);
        
        $route5 = new HTTPRoute('GET', '/5', 7, '', '');
        $route6 = new HTTPRoute('GET', '/6', 8, '', '');

        $routes = [
            $group1,
            $group2,
            $route5,
            $route6,
        ];

        // Act
        $routeCollection = $collectionCreator->create($routes);

        // Assert
        $collectionGroups = $routeCollection->getAllRouteGroups();
        $this->assertNotEmpty($collectionGroups);
        $this->assertEquals(2, count($collectionGroups));

        $collectionRoutes = $routeCollection->getAllRoutes();
        $this->assertNotEmpty($collectionRoutes);
        $this->assertEquals(2, count($collectionRoutes));
    }

    private function getRouteCollectionCreator(): RouteCollectionCreatorInterface
    {
        return new RouteCollectionCreator();
    }
}
