<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\Tests\Integration\HTTP\Facades\Routing;

use GuylianGilsing\PHPAbstractRouter\Collections\HTTP\HTTPRouteCollection;
use GuylianGilsing\PHPAbstractRouter\Collections\HTTP\HTTPRouteCollectionInterface;
use GuylianGilsing\PHPAbstractRouter\HTTP\Facades\Routing\RouterFacade;
use GuylianGilsing\PHPAbstractRouter\HTTP\Serialization\HTTPRoute;
use GuylianGilsing\PHPAbstractRouter\Tests\Fixtures\AttributeClasses\OnlyRoutesClass;
use GuylianGilsing\PHPAbstractRouter\Tests\Fixtures\AttributeClasses\SimpleTestClass;
use GuylianGilsing\PHPAbstractRouter\Tests\Integration\Mocks\Dispatching\HTTP\SimpleRouteDispatcherMock;
use PHPUnit\Framework\TestCase;

final class RouterFacadeTest extends TestCase
{
    public function testIfCanRegisterSimpleRoutes(): void
    {
        // Arrange
        $expectedData = $this->getSimpleExpectedData();

        $mock = new SimpleRouteDispatcherMock('SimpleRouteDispatcherMock');
        $mock->setExpectedData($expectedData);

        $router = new RouterFacade($mock);

        // Act
        $router->register()->get('/', OnlyRoutesClass::class, 'renderIndex');
        $router->register()->get('/about', OnlyRoutesClass::class, 'renderAbout');

        // Assert
        $router->dispatch(); // Assertions are being done within the mock
    }

    public function testIfCanGetRoutesFromOnlyRoutesFile(): void
    {
        // Arrange
        $expectedData = $this->getSimpleExpectedData();

        $mock = new SimpleRouteDispatcherMock('SimpleRouteDispatcherMock');
        $mock->setExpectedData($expectedData);

        $router = new RouterFacade($mock);

        // Act
        $router->fromClass(OnlyRoutesClass::class);

        // Assert
        $router->dispatch(); // Assertions are being done within the mock
    }

    private function getSimpleExpectedData(): HTTPRouteCollectionInterface
    {
        $expectedData = new HTTPRouteCollection();

        $route1 = new HTTPRoute('GET', '/', 1, OnlyRoutesClass::class, 'renderIndex');
        $route2 = new HTTPRoute('GET', '/about', 2, OnlyRoutesClass::class, 'renderAbout');

        $expectedData->addRoute($route1);
        $expectedData->addRoute($route2);

        return $expectedData;
    }
}
