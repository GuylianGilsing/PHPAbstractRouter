<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\Tests\Unit\HTTP\Deserialization;

use GuylianGilsing\PHPAbstractRouter\HTTP\Deserialization\RoutesDeserializer;
use GuylianGilsing\PHPAbstractRouter\HTTP\Serialization\HTTPRoute;
use PHPUnit\Framework\TestCase;

final class RoutesDeserializerTests extends TestCase
{
    public function testIfCanDeserializeSerializedArray(): void
    {
        // Arrange
        $testRoute1 = new HTTPRoute('GET', '/test', 1, '', '');
        $testRoute2 = new HTTPRoute('POST', '/test', 2, '', '');
        $testRoute3 = new HTTPRoute('GET', '/test/test', 3, '', '');
        $testRoute4 = new HTTPRoute('GET', '/test/test/test', 4, '', '');
        
        $serialized = [
            $testRoute1->getPath() => [
                $testRoute1->getMethod() => $testRoute1,
                $testRoute2->getMethod() => $testRoute2,
            ],
            $testRoute3->getPath() => [
                $testRoute3->getMethod() => $testRoute3,
            ],
            $testRoute4->getPath() => [
                $testRoute4->getMethod() => $testRoute4,
            ],
        ];

        // Act
        $deserialized = RoutesDeserializer::deserialize($serialized);

        // Assert
        $this->assertEquals(4, count($deserialized));

        $this->assertEquals($testRoute1, $deserialized[0]);
        $this->assertEquals($testRoute2, $deserialized[1]);
        $this->assertEquals($testRoute3, $deserialized[2]);
        $this->assertEquals($testRoute4, $deserialized[3]);
    }
}
