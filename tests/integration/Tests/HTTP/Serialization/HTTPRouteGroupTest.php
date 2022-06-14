<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\Tests\Integration\HTTP\Serialization;

use ErrorException;
use PHPAbstractRouter\HTTP\Abstractions\HTTPRoute;
use PHPAbstractRouter\HTTP\Abstractions\HTTPRouteGroup;
use PHPUnit\Framework\TestCase;

final class HTTPRouteGroupTest extends TestCase
{
    public function testIfCanAddRoutes(): void
    {
        // Arrange
        $group = $this->getTestRouteGroup();
        $route = new HTTPRoute('GET', '/test', '', '');

        // Act
        $group->addRoute($route);

        // Assert
        $routes = $group->getAllRoutes();

        $this->assertNotEmpty($routes);
        $this->assertEquals(1, count($routes));
    }

    public function testIfCanNotAddIdenticalRoutes(): void
    {
        // Arrange
        $this->expectException(ErrorException::class);

        $group = $this->getTestRouteGroup();
        $route = new HTTPRoute('GET', '/test', '', '');
        $group->addRoute($route);

        // Act
        $group->addRoute($route);
    }

    public function testIfCanAddSamePathRoutes(): void
    {
        // Arrange
        $group = $this->getTestRouteGroup();
        $route1 = new HTTPRoute('GET', '/test', '', '');
        $route2 = new HTTPRoute('POST', '/test', '', '');

        // Act
        $group->addRoute($route1);
        $group->addRoute($route2);

        // Assert
        $routes = $group->getAllRoutes();

        $this->assertNotEmpty($routes);
        $this->assertEquals(2, count($routes));

        $this->assertEquals($route1, $routes[0]);
        $this->assertEquals($route2, $routes[1]);
    }

    public function testIfRouteExistsReturnsTrue(): void
    {
        // Arrange
        $group = $this->getTestRouteGroup();
        $route = new HTTPRoute('GET', '/test', '', '');
        $group->addRoute($route);

        // Act
        $routeExists = $group->routeExists($route);

        // Assert
        $this->assertTrue($routeExists);
    }

    public function testIfRouteExistsReturnsFalse(): void
    {
        // Arrange
        $group = $this->getTestRouteGroup();
        $route = new HTTPRoute('GET', '/test', '', '');

        // Act
        $routeExists = $group->routeExists($route);

        // Assert
        $this->assertFalse($routeExists);
    }

    private function getTestRouteGroup(): HTTPRouteGroup
    {
        return new HTTPRouteGroup('/test');
    }
}
