<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\Tests\Unit\HTTP\Serialization;

use ErrorException;
use GuylianGilsing\PHPAbstractRouter\HTTP\Serialization\HTTPRouteGroup;
use PHPUnit\Framework\TestCase;
use stdClass;

final class HTTPRouteGroupTest extends TestCase
{
    public function testIfConstructorIsWorkingCorrect(): void
    {
        // Arrange
        $path = '/test';
        $order = 1;
        $middleware = [];

        // Act
        $group = new HTTPRouteGroup($path, $order, $middleware);

        // Assert
        $this->assertEquals($path, $group->getPath());
        $this->assertEquals($order, $group->getOrder());

        $this->assertIsArray($group->getMiddlewareStack());
        $this->assertEquals(count($middleware), count($group->getMiddlewareStack()));
    }

    public function testIfCanNotAddNumericValuesAsMiddleware(): void
    {
        // Arrange
        $this->expectException(ErrorException::class);
        $middleware = [12];

        // Act
        new HTTPRouteGroup('/test', 1, $middleware);
    }

    public function testIfCanNotAddNullAsMiddleware(): void
    {
        // Arrange
        $this->expectException(ErrorException::class);
        $middleware = [null];

        // Act
        new HTTPRouteGroup('/test', 1, $middleware);
    }

    public function testIfCanNotAddObjectsAsMiddleware(): void
    {
        // Arrange
        $this->expectException(ErrorException::class);
        $middleware = [new stdClass()];

        // Act
        new HTTPRouteGroup('/test', 1, $middleware);
    }
}
