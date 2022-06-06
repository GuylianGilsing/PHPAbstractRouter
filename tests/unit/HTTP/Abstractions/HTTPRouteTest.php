<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\Tests\Unit\HTTP\Abstractions;

use ErrorException;
use PHPAbstractRouter\HTTP\Abstractions\HTTPRoute;
use PHPUnit\Framework\TestCase;
use stdClass;

final class HTTPRouteTest extends TestCase
{
    public function testIfConstructorIsWorkingCorrect(): void
    {
        // Arrange
        $method = 'GET';
        $path = '/test';
        $classString = '';
        $classMethodCallback = '';
        $middleware = [];

        // Act
        $route = new HTTPRoute($method, $path, $classString, $classMethodCallback, $middleware);

        // Assert
        $this->assertEquals($method, $route->getMethod());
        $this->assertEquals($path, $route->getPath());

        $this->assertIsArray($route->getMiddlewareStack());
        $this->assertEquals(count($middleware), count($route->getMiddlewareStack()));
    }

    public function testIfCanNotAddNumericValuesAsMiddleware(): void
    {
        // Arrange
        $this->expectException(ErrorException::class);
        $middleware = [12];

        // Act
        new HTTPRoute('GET', '/test', '', '', $middleware);
    }

    public function testIfCanNotAddNullAsMiddleware(): void
    {
        // Arrange
        $this->expectException(ErrorException::class);
        $middleware = [null];

        // Act
        new HTTPRoute('GET', '/test', '', '', $middleware);
    }

    public function testIfCanNotAddObjectsAsMiddleware(): void
    {
        // Arrange
        $this->expectException(ErrorException::class);
        $middleware = [new stdClass()];

        // Act
        new HTTPRoute('GET', '/test', '', '', $middleware);
    }
}
