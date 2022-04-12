<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\Tests\Integration\HTTP\Collecting\Extracting;

use GuylianGilsing\PHPAbstractRouter\HTTP\Collecting\Extracting\RouteAttributeExtractor;
use GuylianGilsing\PHPAbstractRouter\HTTP\Collecting\Extracting\RouteAttributeExtractorInterface;
use GuylianGilsing\PHPAbstractRouter\HTTP\Serialization\HTTPRouteGroupInterface;
use GuylianGilsing\PHPAbstractRouter\HTTP\Serialization\HTTPRouteInterface;
use GuylianGilsing\PHPAbstractRouter\Tests\Fixtures\AttributeClasses\ComplexTestClass;
use GuylianGilsing\PHPAbstractRouter\Tests\Fixtures\AttributeClasses\OnlyGroupClass;
use GuylianGilsing\PHPAbstractRouter\Tests\Fixtures\AttributeClasses\OnlyRoutesClass;
use GuylianGilsing\PHPAbstractRouter\Tests\Fixtures\AttributeClasses\SimpleTestClass;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class RouteAttributeExtractorTest extends TestCase
{
    public function testIfCanExtractOnlyGroupFile(): void
    {
        // Arrange
        $extractor = $this->getExtractor();
        $reflectionClass = new ReflectionClass(OnlyGroupClass::class);

        // Act
        $routes = $extractor->fromReflectionClass($reflectionClass);

        // Assert
        $this->assertNotEmpty($routes);
        $this->assertEquals(1, count($routes));

        $this->assertInstanceOf(HTTPRouteGroupInterface::class, $routes[0]);
        $this->assertEmpty($routes[0]->getAllRoutes());
    }

    public function testIfCanExtractOnlyRoutesFile(): void
    {
        // Arrange
        $extractor = $this->getExtractor();
        $reflectionClass = new ReflectionClass(OnlyRoutesClass::class);

        // Act
        $routes = $extractor->fromReflectionClass($reflectionClass);

        // Assert
        $this->assertNotEmpty($routes);
        $this->testIfRouteOrderIsStillCorrect($routes);
    }

    public function testIfCanExtractGroupWithRoutesFile(): void
    {
        // Arrange
        $extractor = $this->getExtractor();
        $reflectionClass = new ReflectionClass(SimpleTestClass::class);

        // Act
        $routes = $extractor->fromReflectionClass($reflectionClass);

        // Assert
        $this->assertNotEmpty($routes);
        $this->assertEquals(1, count($routes));

        $this->assertInstanceOf(HTTPRouteGroupInterface::class, $routes[0]);
        $groupRoutes = $routes[0]->getAllRoutes();
        
        $this->assertNotEmpty($groupRoutes);
        $this->testIfRouteOrderIsStillCorrect($groupRoutes, $routes[0]->getOrder());
    }

    public function testIfCanExtractComplexRouteFile(): void
    {
        // Arrange
        $extractor = $this->getExtractor();
        $reflectionClass = new ReflectionClass(ComplexTestClass::class);

        // Act
        $routes = $extractor->fromReflectionClass($reflectionClass);

        // Assert
        $this->assertNotEmpty($routes);
    }

    /**
     * @param array<HTTPRouteInterface> $routes
     */
    private function testIfRouteOrderIsStillCorrect(array $routes, $startOrder = 0): void
    {
        $expectedOrder = $startOrder;

        foreach($routes as $route)
        {
            $expectedOrder += 1;

            $this->assertInstanceOf(HTTPRouteInterface::class, $route);
            $this->assertEquals($expectedOrder, $route->getOrder());
        }
    }

    private function getExtractor(): RouteAttributeExtractorInterface
    {
        return new RouteAttributeExtractor();
    }
}
