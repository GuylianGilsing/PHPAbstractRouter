<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\Tests\Integration\HTTP\Facades\Routing;

use GuylianGilsing\PHPAbstractRouter\Collections\HTTP\HTTPRouteCollection;
use GuylianGilsing\PHPAbstractRouter\Collections\HTTP\HTTPRouteCollectionInterface;
use GuylianGilsing\PHPAbstractRouter\HTTP\Facades\Routing\GroupRouteRegistererFacade;
use GuylianGilsing\PHPAbstractRouter\HTTP\Facades\Routing\RouterFacade;
use GuylianGilsing\PHPAbstractRouter\HTTP\Serialization\HTTPRoute;
use GuylianGilsing\PHPAbstractRouter\HTTP\Serialization\HTTPRouteGroup;
use GuylianGilsing\PHPAbstractRouter\Tests\Fixtures\AttributeClasses\OnlyRoutesClass;
use GuylianGilsing\PHPAbstractRouter\Tests\Fixtures\AttributeClasses\SimpleTestClass;
use GuylianGilsing\PHPAbstractRouter\Tests\Integration\Mocks\Dispatching\HTTP\GroupRouteDispatcherMock;
use GuylianGilsing\PHPAbstractRouter\Tests\Integration\Mocks\Dispatching\HTTP\ManualAndClassRoutesDispatcherMock;
use GuylianGilsing\PHPAbstractRouter\Tests\Integration\Mocks\Dispatching\HTTP\OnlyRoutesRouteDispatcherMock;
use PHPUnit\Framework\TestCase;

final class RouterFacadeTest extends TestCase
{
    public function testIfCanRegisterSimpleRoutes(): void
    {
        // Arrange
        $expectedData = $this->getSimpleExpectedData();

        $mock = new OnlyRoutesRouteDispatcherMock();
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

        $mock = new OnlyRoutesRouteDispatcherMock();
        $mock->setExpectedData($expectedData);

        $router = new RouterFacade($mock);

        // Act
        $router->register()->fromClass(OnlyRoutesClass::class);

        // Assert
        $router->dispatch(); // Assertions are being done within the mock
    }

    public function testIfCanRegisterGroupRoutes(): void
    {
        // Arrange
        $expectedData = $this->getOnlyRoutesExpectedData();

        $mock = new GroupRouteDispatcherMock();
        $mock->setExpectedData($expectedData);

        $router = new RouterFacade($mock);

        // Act
        $router->register()->group('/test', function(GroupRouteRegistererFacade $group) {
            $group->get('', SimpleTestClass::class, 'renderIndex');
            $group->get('/about', SimpleTestClass::class, 'renderAbout');
        });

        // Assert
        $router->dispatch(); // Assertions are being done within the mock
    }

    public function testIfCanRegisterManualAndClassRoutes(): void
    {
        // Arrange
        $expectedData = $this->getManualAndClassExpectedData();

        $mock = new ManualAndClassRoutesDispatcherMock();
        $mock->setExpectedData($expectedData);

        $router = new RouterFacade($mock);

        // Act
        $router->register()->fromClass(OnlyRoutesClass::class)
                            ->get('/new-test', '', '')
                            ->post('/new-test', '', '')
                            ->get('/testing', '', '');

        // Assert
        $router->dispatch();
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

    private function getOnlyRoutesExpectedData(): HTTPRouteCollectionInterface
    {
        $expectedData = new HTTPRouteCollection();

        $group = new HTTPRouteGroup('/test', 1);
        $route1 = new HTTPRoute('GET', '', 2, SimpleTestClass::class, 'renderIndex');
        $route2 = new HTTPRoute('GET', '/about', 3, SimpleTestClass::class, 'renderAbout');

        $group->addRoute($route1);
        $group->addRoute($route2);

        $expectedData->addRouteGroup($group);

        return $expectedData;
    }

    /**
     * @return array<HTTPRouteCollection>
     */
    private function getManualAndClassExpectedData(): array
    {
        $collection = $this->getSimpleExpectedData();
        $route1 = new HTTPRoute('GET', '/new-test', 3, '', '');
        $route2 = new HTTPRoute('POST', '/new-test', 4, '', '');
        $route3 = new HTTPRoute('GET', '/testing', 5, '', '');

        $collection->addRoute($route1);
        $collection->addRoute($route2);
        $collection->addRoute($route3);

        return [
            $collection
        ];
    }
}
