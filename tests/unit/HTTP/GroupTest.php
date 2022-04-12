<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\Tests\Unit\HTTP;

use ErrorException;
use GuylianGilsing\PHPAbstractRouter\HTTP\Group;
use PHPUnit\Framework\TestCase;
use stdClass;

final class GroupTest extends TestCase
{
    public function testIfConstructorIsWorkingCorrect(): void
    {
        // Arrange
        $path = '/test';
        $middleware = [];

        // Act
        $group = new Group($path, $middleware);

        // Assert
        $this->assertEquals($path, $group->getPath());

        $this->assertIsArray($group->getMiddlewareStack());
        $this->assertEquals(count($middleware), count($group->getMiddlewareStack()));
    }

    public function testIfCanNotAddNumericValuesAsMiddleware(): void
    {
        // Arrange
        $this->expectException(ErrorException::class);
        $middleware = [12];

        // Act
        new Group('/test', $middleware);
    }

    public function testIfCanNotAddNullAsMiddleware(): void
    {
        // Arrange
        $this->expectException(ErrorException::class);
        $middleware = [null];

        // Act
        new Group('/test', $middleware);
    }

    public function testIfCanNotAddObjectsAsMiddleware(): void
    {
        // Arrange
        $this->expectException(ErrorException::class);
        $middleware = [new stdClass()];

        // Act
        new Group('/test', $middleware);
    }
}
