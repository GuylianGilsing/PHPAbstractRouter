<?php

declare(strict_types=1);

namespace PHPAbstractRouter\Tests\Unit\HTTP\Attributes\Extracting\Extractors;

use PHPAbstractRouter\HTTP\Attributes\Extracting\Extractors\RoutesExtractor;
use PHPAbstractRouter\Tests\Fixtures\AttributeClasses\ComplexTestClass;
use PHPAbstractRouter\Tests\Fixtures\AttributeClasses\OnlyGroupClass;
use PHPAbstractRouter\Tests\Fixtures\AttributeClasses\OnlyRoutesClass;
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
    }

    public function testCanExtractComplexFile(): void
    {
        // Arrange
        $reflectionClass = new ReflectionClass(ComplexTestClass::class);

        // Act
        $routes = RoutesExtractor::extract($reflectionClass);

        // Assert
        $this->assertNotEmpty($routes);
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
}
