<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\Tests\Integration\Mocks\Dispatching\HTTP;

use GuylianGilsing\PHPAbstractRouter\Collections\HTTP\HTTPRouteCollectionInterface;
use GuylianGilsing\PHPAbstractRouter\Dispatching\HTTP\HTTPRouteDispatcherInterface;
use PHPUnit\Framework\TestCase;

final class ManualAndClassRoutesDispatcherMock extends TestCase implements HTTPRouteDispatcherInterface
{
    /**
     * @var array<HTTPRouteCollectionInterface> $collections
     */
    private array $collections = [];

    /**
     * Dispatches a list of HTTP route collections.
     *
     * @param array<HTTPRouteCollectionInterface> $routeCollections
     */
    public function dispatch(array $routeCollections): void
    {
        // Assert
        $this->assertNotEmpty($this->collections);
        $this->assertEquals(1, count($this->collections));
        $this->assertEquals(1, count($routeCollections));

        $extractedCollection = $routeCollections[0];
        $expectedCollection = $this->collections[0];

        $this->compareCollectionData($expectedCollection, $extractedCollection);
    }

    /**
     * @param array<HTTPRouteCollectionInterface> $collection
     */
    public function setExpectedData(array $collections): void
    {
        $this->collections = $collections;
    }

    private function compareCollectionData(
        HTTPRouteCollectionInterface $expected,
        HTTPRouteCollectionInterface $received
    ): void {
        $this->assertEquals($expected, $received);
    }
}
