<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\Tests;

use ErrorException;
use GuylianGilsing\PHPAbstractRouter\Collections\HTTP\HTTPRouteCollection;
use GuylianGilsing\PHPAbstractRouter\HTTP\Serialization\HTTPRoute;
use GuylianGilsing\PHPAbstractRouter\HTTP\Serialization\HTTPRouteGroup;
use GuylianGilsing\PHPAbstractRouter\Tests\Integration\Mocks\Dispatching\HTTP\OrderCheckDispatcherMock;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

final class OrderCheckDispatcherMockTest extends TestCase
{
    public function testIfCorrectOrderDoesNotThrowExceptions(): void
    {
        // Arrange
        $mock = new OrderCheckDispatcherMock();

        $collection = new HTTPRouteCollection();
        $route1 = new HTTPRoute('GET', '/', 1, '', '');
        $route2 = new HTTPRoute('GET', '/test', 2, '', '');

        $group1 = new HTTPRouteGroup('/testing', 3);
        $route3 = new HTTPRoute('GET', '/test', 4, '', '');
        $route4 = new HTTPRoute('POST', '/test', 5, '', '');
        $group1->addRoute($route3);
        $group1->addRoute($route4);

        $collection->addRoute($route1);
        $collection->addRoute($route2);
        $collection->addRouteGroup($group1);

        // Act + assert
        $mock->dispatch([$collection]);
    }

    public function testIfIncorrectOrderDoesThrowExceptions(): void
    {
        // Arrange
        $mock = new OrderCheckDispatcherMock();

        $collection = new HTTPRouteCollection();
        $route1 = new HTTPRoute('GET', '/', 1, '', '');
        $route2 = new HTTPRoute('GET', '/test', 2, '', '');

        $group1 = new HTTPRouteGroup('/testing', 4);
        $route3 = new HTTPRoute('GET', '/test', 5, '', '');
        $route4 = new HTTPRoute('POST', '/test', 3, '', '');
        $group1->addRoute($route3);
        $group1->addRoute($route4);

        $collection->addRoute($route1);
        $collection->addRoute($route2);
        $collection->addRouteGroup($group1);

        $this->expectException(ErrorException::class);
        $this->expectException(ExpectationFailedException::class);

        // Act + assert
        $mock->dispatch([$collection]);
    }
}
