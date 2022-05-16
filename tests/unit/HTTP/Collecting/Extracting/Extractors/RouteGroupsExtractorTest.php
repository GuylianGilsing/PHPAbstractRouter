<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\Tests\Unit\HTTP\Collecting\Extracting\Extractors;

use GuylianGilsing\PHPAbstractRouter\Collections\Ordering\OrderInterface;
use GuylianGilsing\PHPAbstractRouter\Tests\Fixtures\AttributeClasses\OnlyGroupClass;
use GuylianGilsing\PHPAbstractRouter\Tests\Fixtures\AttributeClasses\OnlyRoutesClass;
use GuylianGilsing\PHPAbstractRouter\HTTP\Collecting\Extracting\Extractors\RouteGroupsExtractor;
use GuylianGilsing\PHPAbstractRouter\HTTP\Serialization\HTTPRouteGroupInterface;
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
        $this->assertInstanceOf(HTTPRouteGroupInterface::class, $group);
        $this->assertInstanceOf(OrderInterface::class, $group);

        $this->assertEquals(1, $group->getOrder());
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
