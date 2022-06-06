<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\Tests\Integration\HTTP\Collecting;

use PHPAbstractRouter\HTTP\Abstractions\HTTPRouteGroup;
use PHPAbstractRouter\HTTP\Attributes\Collecting\RouteAttributeCollector;
use PHPAbstractRouter\HTTP\Attributes\Collecting\RouteAttributeCollectorInterface;
use PHPAbstractRouter\HTTP\Attributes\Extracting\RouteAttributeExtractor;
use PHPAbstractRouter\Tests\Fixtures\AttributeClasses\ComplexTestClass;
use PHPAbstractRouter\Tests\Fixtures\AttributeClasses\OnlyGroupClass;
use PHPAbstractRouter\Tests\Fixtures\AttributeClasses\OnlyRoutesClass;
use PHPUnit\Framework\TestCase;

final class RouteAttributeCollectorTest extends TestCase
{
    public function testIfCanCollectFromOnlyRoutesClassFile(): void
    {
        // Arrange
        $attributeCollector = $this->getRouteAttributeCollector();

        // Act
        $routes = $attributeCollector->fromClass(OnlyRoutesClass::class);

        // Assert
        $this->assertNotEmpty($routes);
        $this->assertEquals(2, count($routes));
    }

    public function testIfCanCollectFromOnlyGroupClassFile(): void
    {
        // Arrange
        $attributeCollector = $this->getRouteAttributeCollector();

        // Act
        $routes = $attributeCollector->fromClass(OnlyGroupClass::class);

        // Assert
        $this->assertNotEmpty($routes);
        $this->assertEquals(1, count($routes));

        $this->assertInstanceOf(HTTPRouteGroup::class, $routes[0]);
        $this->assertEmpty($routes[0]->getAllRoutes());
    }

    public function testIfCanCollectFromComplexClassFile(): void
    {
        // Arrange
        $attributeCollector = $this->getRouteAttributeCollector();

        // Act
        $routes = $attributeCollector->fromClass(ComplexTestClass::class);

        // Assert
        $this->assertNotEmpty($routes);
        $this->assertEquals(1, count($routes));

        $this->assertInstanceOf(HTTPRouteGroup::class, $routes[0]);
        $groupRoutes = $routes[0]->getAllRoutes();

        $this->assertNotEmpty($groupRoutes);
        $this->assertEquals(4, count($groupRoutes));
    }

    private function getRouteAttributeCollector(): RouteAttributeCollectorInterface
    {
        return new RouteAttributeCollector(new RouteAttributeExtractor());
    }
}
