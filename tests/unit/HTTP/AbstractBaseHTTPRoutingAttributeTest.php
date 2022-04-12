<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\Tests\Unit\HTTP;

use ErrorException;
use GuylianGilsing\PHPAbstractRouter\HTTP\AbstractBaseHTTPRoutingAttribute;
use GuylianGilsing\PHPAbstractRouter\HTTP\DELETE;
use GuylianGilsing\PHPAbstractRouter\HTTP\GET;
use GuylianGilsing\PHPAbstractRouter\HTTP\OPTIONS;
use GuylianGilsing\PHPAbstractRouter\HTTP\POST;
use GuylianGilsing\PHPAbstractRouter\HTTP\PUT;
use PHPUnit\Framework\TestCase;
use stdClass;

final class AbstractBaseHTTPRoutingAttributeTest extends TestCase
{
    public function testGET(): void
    {
        $this->runTests(GET::class, 'GET', '/test', []);
    }

    public function testPOST(): void
    {
        $this->runTests(POST::class, 'POST', '/test', []);
    }

    public function testPUT(): void
    {
        $this->runTests(PUT::class, 'PUT', '/test', []);
    }

    public function testDELETE(): void
    {
        $this->runTests(DELETE::class, 'DELETE', '/test', []);
    }

    public function testOPTIONS(): void
    {
        $this->runTests(OPTIONS::class, 'OPTIONS', '/test', []);
    }

    private function runTests(string $class, string $method, string $path, array $middleware): void
    {
        // Arrange
        $route = new $class($path, $middleware);

        // Act
        $this->testIfConstructorIsWorkingCorrect($route, $path, $method, $middleware);

        $this->testIfCanNotUseValueAsMiddleware($class, [12]); // Numeric
        $this->testIfCanNotUseValueAsMiddleware($class, [null]); // Null
        $this->testIfCanNotUseValueAsMiddleware($class, [new stdClass()]); // Objects
    }

    private function testIfConstructorIsWorkingCorrect(
        AbstractBaseHTTPRoutingAttribute $route,
        string $path,
        string $method,
        array $middleware
    ): void {
        // Assert
        $this->assertEquals($path, $route->getPath());
        $this->assertEquals($method, $route->getMethod());

        $this->assertIsArray($route->getMiddlewareStack());
        $this->assertEquals(count($middleware), count($route->getMiddlewareStack()));
    }

    private function testIfCanNotUseValueAsMiddleware(string $class, mixed $value): void
    {
        // Arrange
        $this->expectException(ErrorException::class);

        // Act
        new $class('/test', [$value]);
    }
}
