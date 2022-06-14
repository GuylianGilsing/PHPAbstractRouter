<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\Tests\Integration\HTTP;

use PHPAbstractRouter\HTTP\Abstractions\HTTPRoute;
use PHPAbstractRouter\HTTP\Abstractions\HTTPRouteGroup;
use PHPAbstractRouter\HTTP\Attributes\Collecting\RouteAttributeCollector;
use PHPAbstractRouter\HTTP\Attributes\Extracting\RouteAttributeExtractor;
use PHPAbstractRouter\HTTP\GroupRouter;
use PHPAbstractRouter\HTTP\Router;
use PHPAbstractRouter\Tests\Fixtures\AttributeClasses\ComplexTestClass;
use PHPAbstractRouter\Tests\Fixtures\AttributeClasses\OnlyRoutesClass;
use PHPAbstractRouter\Tests\Fixtures\Middleware\SimpleMiddleware;
use PHPAbstractRouter\Tests\Integration\Mocks\MockBackendRouteRegisterer;
use PHPUnit\Framework\TestCase;

final class RouterTest extends TestCase
{
    public function testIfCanRegisterNormalRoutes(): void
    {
        // Arrange
        $routeRegisterer = new MockBackendRouteRegisterer();
        $router = $this->getRouter($routeRegisterer);

        $expectedRoute1 = new HTTPRoute('GET', '/test', 'testClass', 'testMethod');
        $expectedRoute2 = new HTTPRoute('POST', '/test', 'testClass', 'testMethod');

        // Act
        $router->get('/test', 'testClass', 'testMethod');
        $router->post('/test', 'testClass', 'testMethod');

        // Assert
        $result = $routeRegisterer->getRegisteredRoutes();

        $this->assertNotEmpty($result);
        $this->assertEquals(2, count($result));

        $this->assertEquals($expectedRoute1, $result[0]);
        $this->assertEquals($expectedRoute2, $result[1]);
    }

    public function testIfCanRegisterNormalGroupRoute(): void
    {
        // Arrange
        $routeRegisterer = new MockBackendRouteRegisterer();
        $router = $this->getRouter($routeRegisterer);

        $expectedRoute1 = new HTTPRoute('GET', '/1', 'testClass', 'testMethod');
        $expectedRoute2 = new HTTPRoute('GET', '/2', 'testClass', 'testMethod');
        $expectedRoute3 = new HTTPRoute('POST', '/test', 'testClass', 'testMethod');

        $expectedGroup1 = new HTTPRouteGroup('/test');
        $expectedGroup1->addRoute($expectedRoute1);
        $expectedGroup1->addRoute($expectedRoute2);

        // Act
        $router->group('/test', function(GroupRouter $group)
        {
            $group->get('/1', 'testClass', 'testMethod');
            $group->get('/2', 'testClass', 'testMethod');
        });
        $router->post('/test', 'testClass', 'testMethod');

        // Assert
        $result = $routeRegisterer->getRegisteredRoutes();

        $this->assertNotEmpty($result);
        $this->assertEquals(2, count($result));

        $this->assertEquals($expectedGroup1, $result[0]);
        $this->assertEquals($expectedRoute3, $result[1]);
    }

    public function testIfCanRegisterFromController(): void
    {
        // Arrange
        $routeRegisterer = new MockBackendRouteRegisterer();
        $router = $this->getRouter($routeRegisterer);

        $expectedRoute1 = new HTTPRoute('GET', '/', OnlyRoutesClass::class, 'renderIndex');
        $expectedRoute2 = new HTTPRoute('GET', '/about', OnlyRoutesClass::class, 'renderAbout');

        // Act
        $router->controller(OnlyRoutesClass::class);

        // Assert
        $result = $routeRegisterer->getRegisteredRoutes();

        $this->assertNotEmpty($result);
        $this->assertEquals(2, count($result));

        $this->assertEquals($expectedRoute1, $result[0]);
        $this->assertEquals($expectedRoute2, $result[1]);
    }

    public function testIfCanRegisterGroupFromController(): void
    {
        // Arrange
        $routeRegisterer = new MockBackendRouteRegisterer();
        $router = $this->getRouter($routeRegisterer);

        $expectedRoute1 = new HTTPRoute('GET', '/', ComplexTestClass::class, 'renderIndex', [SimpleMiddleware::class]);
        $expectedRoute2 = new HTTPRoute('POST', '/', ComplexTestClass::class, 'indexPOST');
        $expectedRoute3 = new HTTPRoute('GET', '/about', ComplexTestClass::class, 'renderAbout');
        $expectedRoute4 = new HTTPRoute('POST', '/about', ComplexTestClass::class, 'aboutPOST');

        $expectedGroup1 = new HTTPRouteGroup('/test', [SimpleMiddleware::class]);
        $expectedGroup1->addRoute($expectedRoute1);
        $expectedGroup1->addRoute($expectedRoute2);
        $expectedGroup1->addRoute($expectedRoute3);
        $expectedGroup1->addRoute($expectedRoute4);

        // Act
        $router->controller(ComplexTestClass::class);

        // Assert
        $result = $routeRegisterer->getRegisteredRoutes();

        $this->assertNotEmpty($result);
        $this->assertEquals(1, count($result));

        $this->assertInstanceOf(HTTPRouteGroup::class, $result[0]);
        $this->assertEquals($expectedGroup1, $result[0]);
    }

    public function testIfCanRegisterNormalAndControllerRoutes(): void
    {
        // Arrange
        $routeRegisterer = new MockBackendRouteRegisterer();
        $router = $this->getRouter($routeRegisterer);

        $expectedRoute1 = new HTTPRoute('GET', '/test', 'testClass', 'testMethod');
        $expectedRoute2 = new HTTPRoute('GET', '/', OnlyRoutesClass::class, 'renderIndex');
        $expectedRoute3 = new HTTPRoute('GET', '/about', OnlyRoutesClass::class, 'renderAbout');
        $expectedRoute4 = new HTTPRoute('POST', '/test', 'testClass', 'testMethod');

        // Act
        $router->get('/test', 'testClass', 'testMethod');
        $router->controller(OnlyRoutesClass::class);
        $router->post('/test', 'testClass', 'testMethod');

        // Assert
        $result = $routeRegisterer->getRegisteredRoutes();

        $this->assertNotEmpty($result);
        $this->assertEquals(4, count($result));

        $this->assertEquals($expectedRoute1, $result[0]);
        $this->assertEquals($expectedRoute2, $result[1]);
        $this->assertEquals($expectedRoute3, $result[2]);
        $this->assertEquals($expectedRoute4, $result[3]);
    }

    private function getRouter(MockBackendRouteRegisterer $routeRegisterer): Router
    {
        return new Router(
            $routeRegisterer,
            new RouteAttributeCollector(new RouteAttributeExtractor())
        );
    }
}
