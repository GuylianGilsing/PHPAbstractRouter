<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\Tests\Integration\HTTP\Collecting;

use GuylianGilsing\PHPAbstractRouter\HTTP\Collecting\RouteAttributeCollector;
use GuylianGilsing\PHPAbstractRouter\HTTP\Collecting\RouteAttributeCollectorInterface;
use GuylianGilsing\PHPAbstractRouter\Tests\Fixtures\AttributeClasses\ComplexTestClass;
use GuylianGilsing\PHPAbstractRouter\Tests\Fixtures\AttributeClasses\OnlyGroupClass;
use GuylianGilsing\PHPAbstractRouter\Tests\Fixtures\AttributeClasses\OnlyRoutesClass;
use GuylianGilsing\PHPAbstractRouter\Tests\Fixtures\AttributeClasses\SimpleTestClass;
use PHPUnit\Framework\TestCase;

final class RouteAttributeCollectorTest extends TestCase
{
    public function testIfCanCollectFromOnlyRoutesClassFile(): void
    {
        // Arrange
        $attributeCollector = $this->getRouteAttributeCollector();

        // Act
        $routeCollection = $attributeCollector->collectFromClassName(OnlyRoutesClass::class);

        // Assert
        $this->assertNotNull($routeCollection);

        $collectionGroups = $routeCollection->getAllRouteGroups();
        $this->assertEmpty($collectionGroups);

        $collectionRoutes = $routeCollection->getAllRoutes();
        $this->assertNotEmpty($collectionRoutes);
        $this->assertEquals(2, count($collectionRoutes));
    }

    public function testIfCanCollectFromOnlyGroupClassFile(): void
    {
        // Arrange
        $attributeCollector = $this->getRouteAttributeCollector();

        // Act
        $routeCollection = $attributeCollector->collectFromClassName(OnlyGroupClass::class);

        // Assert
        $this->assertNotNull($routeCollection);

        $collectionGroups = $routeCollection->getAllRouteGroups();
        $this->assertNotEmpty($collectionGroups);
        $this->assertEquals(1, count($collectionGroups));

        $groupRoutes = $collectionGroups[0]->getAllRoutes();
        $this->assertEmpty($groupRoutes);
        
        $collectionRoutes = $routeCollection->getAllRoutes();
        $this->assertEmpty($collectionRoutes);
    }

    public function testIfCanCollectFromComplexClassFile(): void
    {
        // Arrange
        $attributeCollector = $this->getRouteAttributeCollector();

        // Act
        $routeCollection = $attributeCollector->collectFromClassName(ComplexTestClass::class);

        // Assert
        $this->assertNotNull($routeCollection);

        $collectionGroups = $routeCollection->getAllRouteGroups();
        $this->assertNotEmpty($collectionGroups);
        $this->assertEquals(1, count($collectionGroups));

        $groupRoutes = $collectionGroups[0]->getAllRoutes();
        $this->assertNotEmpty($groupRoutes);
        $this->assertEquals(4, count($groupRoutes));
        
        $collectionRoutes = $routeCollection->getAllRoutes();
        $this->assertEmpty($collectionRoutes);
    }

    public function testIfOrderIsCorrectAfterCollectingFromTwoClasses(): void
    {
        // Arrange
        $attributeCollector = $this->getRouteAttributeCollector();

        // Act
        $routeCollection1 = $attributeCollector->collectFromClassName(SimpleTestClass::class);
        $routeCollection2 = $attributeCollector->collectFromClassName(ComplexTestClass::class);

        // Assert
        $this->testIfOrderIntegerOfCollectionsAreCorrect([
            $routeCollection1,
            $routeCollection2,
        ]);
    }

    /**
     * @param array<HTTPRouteCollectionInterface> $collections
     */
    private function testIfOrderIntegerOfCollectionsAreCorrect(array $collections): void
    {
        $expectedOrder = 0;

        /**
         * @var \GuylianGilsing\PHPAbstractRouter\Collections\HTTP\HTTPRouteCollectionInterface $collection
         */
        foreach ($collections as $collection)
        {
            $groups = $collection->getAllRouteGroups();
            
            // Check route groups
            foreach ($groups as $group)
            {
                $expectedOrder += 1;
                $this->assertEquals($expectedOrder, $group->getOrder());
            
                foreach ($group->getAllRoutes() as $route)
                {
                    $expectedOrder += 1;
                    $this->assertEquals($expectedOrder, $route->getOrder());
                }
            }

            // Check routes
            foreach ($collection->getAllRoutes() as $route)
            {
                $expectedOrder += 1;
                $this->assertEquals($expectedOrder, $route->getOrder());
            }
        }
    }

    private function getRouteAttributeCollector(): RouteAttributeCollectorInterface
    {
        return new RouteAttributeCollector();
    }
}
