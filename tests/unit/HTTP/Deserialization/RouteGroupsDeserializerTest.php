<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\Tests\Unit\HTTP\Deserialization;

use GuylianGilsing\PHPAbstractRouter\HTTP\Deserialization\RouteGroupsDeserializer;
use GuylianGilsing\PHPAbstractRouter\HTTP\Serialization\HTTPRouteGroup;
use PHPUnit\Framework\TestCase;

final class RouteGroupsDeserializerTest extends TestCase
{
    public function testIfCanDeserializeSerializedArray(): void
    {
        // Arrange
        $group1 = new HTTPRouteGroup('/test', 1);
        $group2 = new HTTPRouteGroup('/test', 2);
        $group3 = new HTTPRouteGroup('/test', 3);
        $group4 = new HTTPRouteGroup('/test/test', 4);
        $group5 = new HTTPRouteGroup('/test/test', 5);
        $group6 = new HTTPRouteGroup('/test/test/test', 6);

        $serialized = [
            $group1->getPath() => [
                $group1,
                $group2,
                $group3,
            ],
            $group4->getPath() => [
                $group4,
                $group5,
            ],
            $group6->getPath() => [
                $group6
            ],
        ];

        // Act
        $deserialized = RouteGroupsDeserializer::deserialize($serialized);

        // Assert
        $this->assertEquals(6, count($deserialized));

        $this->assertEquals($group1, $deserialized[0]);
        $this->assertEquals($group2, $deserialized[1]);
        $this->assertEquals($group3, $deserialized[2]);
        $this->assertEquals($group4, $deserialized[3]);
        $this->assertEquals($group5, $deserialized[4]);
        $this->assertEquals($group6, $deserialized[5]);
    }
}
