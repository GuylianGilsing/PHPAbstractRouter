<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\Tests\Integration\Collections\HTTP;

use ErrorException;
use GuylianGilsing\PHPAbstractRouter\Collections\HTTP\HTTPRouteCollection;
use GuylianGilsing\PHPAbstractRouter\HTTP\Serialization\HTTPRoute;
use GuylianGilsing\PHPAbstractRouter\HTTP\Serialization\HTTPRouteGroup;
use PHPUnit\Framework\TestCase;

final class HTTPRouteCollectionTest extends TestCase
{
    public function testIfCanAddRoutes(): void
    {
        // Arrange
        $collection = $this->getTestRouteCollection();
        $route = new HTTPRoute('GET', '/test', 1, '', '');

        // Act
        $collection->addRoute($route);

        // Assert
        $routes = $collection->getAllRoutes();

        $this->assertNotEmpty($routes);
        $this->assertEquals(1, count($routes));
    }

    public function testIfCanNotAddIdenticalRoutes(): void
    {
        // Arrange
        $this->expectException(ErrorException::class);

        $collection = $this->getTestRouteCollection();
        $route = new HTTPRoute('GET', '/test', 1, '', '');
        $collection->addRoute($route);

        // Act
        $collection->addRoute($route);
    }

    public function testIfCanAddSamePathRoutes(): void
    {
        // Arrange
        $collection = $this->getTestRouteCollection();
        $route1 = new HTTPRoute('GET', '/test', 1, '', '');
        $route2 = new HTTPRoute('POST', '/test', 2, '', '');

        // Act
        $collection->addRoute($route1);
        $collection->addRoute($route2);

        // Assert
        $routes = $collection->getAllRoutes();

        $this->assertNotEmpty($routes);
        $this->assertEquals(2, count($routes));

        $this->assertEquals($route1, $routes[0]);
        $this->assertEquals($route2, $routes[1]);
    }

    public function testIfhasRouteReturnsTrue(): void
    {
        // Arrange
        $collection = $this->getTestRouteCollection();
        $route = new HTTPRoute('GET', '/test', 1, '', '');
        $collection->addRoute($route);

        // Act
        $hasRoute = $collection->hasRoute($route);

        // Assert
        $this->assertTrue($hasRoute);
    }

    public function testIfhasRouteReturnsFalse(): void
    {
        // Arrange
        $collection = $this->getTestRouteCollection();
        $route = new HTTPRoute('GET', '/test', 1, '', '');

        // Act
        $hasRoute = $collection->hasRoute($route);

        // Assert
        $this->assertFalse($hasRoute);
    }

    public function testIfCanAddRouteGroups(): void
    {
        // Arrange
        $collection = $this->getTestRouteCollection();
        $group = new HTTPRouteGroup('/test', 1);

        // Act
        $collection->addRouteGroup($group);

        // Assert
        $groups = $collection->getAllRouteGroups();

        $this->assertNotEmpty($groups);
        $this->assertEquals(1, count($groups));
    }

    public function testIfCanAddSamePathRouteGroups(): void
    {
        // Arrange
        $collection = $this->getTestRouteCollection();
        $group1 = new HTTPRouteGroup('/test', 1);
        $group2 = new HTTPRouteGroup('/test', 2);

        // Act
        $collection->addRouteGroup($group1);
        $collection->addRouteGroup($group2);

        // Assert
        $groups = $collection->getAllRouteGroups();

        $this->assertNotEmpty($groups);
        $this->assertEquals(2, count($groups));

        $this->assertEquals($group1, $groups[0]);
        $this->assertEquals($group2, $groups[1]);
    }

    private function getTestRouteCollection(): HTTPRouteCollection
    {
        return new HTTPRouteCollection();
    }
}
