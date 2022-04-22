<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\Tests\Unit\HTTP\Collecting\Extracting\Extractors;

use GuylianGilsing\PHPAbstractRouter\HTTP\Collecting\Ordering\OrderCalculator;
use GuylianGilsing\PHPAbstractRouter\HTTP\Collecting\Ordering\OrderCalculatorInterface;
use GuylianGilsing\PHPAbstractRouter\HTTP\Serialization\HTTPRoute;
use GuylianGilsing\PHPAbstractRouter\HTTP\Serialization\HTTPRouteGroup;
use PHPUnit\Framework\TestCase;

final class OrderCalculatorTest extends TestCase
{
    public function testIfOrderIsCorrectWithListOfRoutes(): void
    {
        // Arrange
        $orderCalculator = $this->getOrderCalculator();

        $route1 = new HTTPRoute('GET', '/test1', 1, '', '');
        $route2 = new HTTPRoute('GET', '/test1', 2, '', '');
        $route3 = new HTTPRoute('GET', '/test1', 3, '', '');
        $route4 = new HTTPRoute('GET', '/test1', 4, '', '');
        $route5 = new HTTPRoute('GET', '/test1', 5, '', '');

        $routes = [
            $route1,
            $route2,
            $route3,
            $route4,
            $route5,
        ];

        // Act
        $calculatedOrder = $orderCalculator->calculate($routes);

        // Assert
        $this->assertEquals(5, $calculatedOrder);
    }

    public function testIfOrderIsCorrectWithListOfRouteGroups(): void
    {
        // Arrange
        $orderCalculator = $this->getOrderCalculator();

        $group1 = new HTTPRouteGroup('/test1', 1);
        $route1 = new HTTPRoute('GET', '/test1', 2, '', '');
        $route2 = new HTTPRoute('GET', '/test2', 3, '', '');

        $group1->addRoute($route1);
        $group1->addRoute($route2);

        $group2 = new HTTPRouteGroup('/test2', 4);
        $route3 = new HTTPRoute('GET', '/test1', 5, '', '');
        $route4 = new HTTPRoute('GET', '/test2', 6, '', '');
        
        $group2->addRoute($route3);
        $group2->addRoute($route4);

        $group3 = new HTTPRouteGroup('/test3', 7);
        $route5 = new HTTPRoute('GET', '/test1', 8, '', '');

        $group3->addRoute($route5);

        $routes = [
            $group1,
            $group2,
            $group3,
        ];

        // Act
        $calculatedOrder = $orderCalculator->calculate($routes);

        // Assert
        $this->assertEquals(8, $calculatedOrder);
    }

    public function testIfOrderIsCorrectWithListOfRoutesAndRouteGroups(): void
    {
        // Arrange
        $orderCalculator = $this->getOrderCalculator();

        $group1 = new HTTPRouteGroup('/test1', 1);
        $route1 = new HTTPRoute('GET', '/test1', 2, '', '');
        $route2 = new HTTPRoute('GET', '/test2', 3, '', '');

        $group1->addRoute($route1);
        $group1->addRoute($route2);

        $group2 = new HTTPRouteGroup('/test2', 4);
        $route3 = new HTTPRoute('GET', '/test1', 5, '', '');
        $route4 = new HTTPRoute('GET', '/test2', 6, '', '');
        
        $group2->addRoute($route3);
        $group2->addRoute($route4);

        $group3 = new HTTPRouteGroup('/test3', 7);
        $route5 = new HTTPRoute('GET', '/test1', 8, '', '');

        $group3->addRoute($route5);

        $route6 = new HTTPRoute('GET', '/test4', 9, '', '');
        $route7 = new HTTPRoute('GET', '/test5', 10, '', '');

        $routes = [
            $group1,
            $group2,
            $group3,
            $route6,
            $route7,
        ];

        // Act
        $calculatedOrder = $orderCalculator->calculate($routes);

        // Assert
        $this->assertEquals(10, $calculatedOrder);
    }

    private function getOrderCalculator(): OrderCalculatorInterface
    {
        return new OrderCalculator();
    }
}
