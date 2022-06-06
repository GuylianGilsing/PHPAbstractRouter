<?php

declare(strict_types=1);

namespace PHPAbstractRouter\Tests\Unit\HTTP\Attributes\Extracting\Extractors;

use PHPAbstractRouter\HTTP\Abstractions\HTTPRouteGroup;
use PHPAbstractRouter\HTTP\Attributes\Extracting\Extractors\RouteGroupsExtractor;
use PHPAbstractRouter\Tests\Fixtures\AttributeClasses\OnlyGroupClass;
use PHPAbstractRouter\Tests\Fixtures\AttributeClasses\OnlyRoutesClass;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class RouteGroupsExtractorTest extends TestCase
{
    public function testCanExtractGroupFromSimpleFile(): void
    {
        // Arrange
        $reflectionClass = new ReflectionClass(OnlyGroupClass::class);

        // Act
        $group = RouteGroupsExtractor::extract($reflectionClass);

        // Assert
        $this->assertNotNull($group);
        $this->assertInstanceOf(HTTPRouteGroup::class, $group);
    }

    public function testCanNotExtractGroupFromNonGroupFile(): void
    {
        // Arrange
        $reflectionClass = new ReflectionClass(OnlyRoutesClass::class);

        // Act
        $group = RouteGroupsExtractor::extract($reflectionClass);

        // Assert
        $this->assertNull($group);
    }
}
