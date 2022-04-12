<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\Tests\Unit\HTTP\Collecting\Extracting\Extractors;

use GuylianGilsing\PHPAbstractRouter\Tests\Fixtures\AttributeClasses\OnlyRoutesClass;
use GuylianGilsing\PHPAbstractRouter\HTTP\Collecting\Extracting\Extractors\RoutesExtractor;
use GuylianGilsing\PHPAbstractRouter\HTTP\Serialization\HTTPRouteInterface;
use GuylianGilsing\PHPAbstractRouter\Tests\Fixtures\AttributeClasses\ComplexTestClass;
use GuylianGilsing\PHPAbstractRouter\Tests\Fixtures\AttributeClasses\OnlyGroupClass;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class RoutesExtractorTest extends TestCase
{
    public function testCanExtractSimpleFile(): void
    {
        // Arrange
        $reflectionClass = new ReflectionClass(OnlyRoutesClass::class);

        // Act
        $routes = RoutesExtractor::extract($reflectionClass);

        // Assert
        $this->assertNotEmpty($routes);
        $this->testIfRouteOrderIsStillCorrect($routes);
    }

    public function testCanExtractComplexFile(): void
    {
        // Arrange
        $reflectionClass = new ReflectionClass(ComplexTestClass::class);

        // Act
        $routes = RoutesExtractor::extract($reflectionClass);

        // Assert
        $this->assertNotEmpty($routes);
        $this->testIfRouteOrderIsStillCorrect($routes);
    }

    public function testCanNotExtractOnlyGroupFile(): void
    {
        // Arrange
        $reflectionClass = new ReflectionClass(OnlyGroupClass::class);

        // Act
        $routes = RoutesExtractor::extract($reflectionClass);

        // Assert
        $this->assertEmpty($routes);
    }

    /**
     * @param array<HTTPRouteInterface> $routes
     */
    private function testIfRouteOrderIsStillCorrect(array $routes): void
    {
        $expectedOrder = 0;

        foreach($routes as $route)
        {
            $expectedOrder += 1;

            $this->assertInstanceOf(HTTPRouteInterface::class, $route);
            $this->assertEquals($expectedOrder, $route->getOrder());
        }
    }
}
