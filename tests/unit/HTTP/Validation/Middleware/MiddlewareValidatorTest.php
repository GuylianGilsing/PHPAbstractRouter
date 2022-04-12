<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\Tests\Unit\HTTP\Validation\Middleware;

use GuylianGilsing\PHPAbstractRouter\HTTP\Validation\Middleware\MiddlewareValidationInterface;
use GuylianGilsing\PHPAbstractRouter\HTTP\Validation\Middleware\MiddlewareValidator;
use PHPUnit\Framework\TestCase;
use stdClass;

final class MiddlewareValidatorTest extends TestCase
{
    public function testIfCanGetErrorMessagesAfterFailedValidation(): void
    {
        // Arrange
        $validator = $this->getValidator();

        // Act
        $validator->validate([1]);

        // Assert
        $this->assertFalse($validator->isValid());
        $this->assertNotEmpty($validator->getErrorMessages());
    }

    public function testErrorMessagesResetAfterNewValidation(): void
    {
        // Arrange
        $validator = $this->getValidator();

        // Act
        $validator->validate([1]);

        // Assert
        $this->assertFalse($validator->isValid());
        $this->assertNotEmpty($validator->getErrorMessages());

        // Act
        $validator->validate([stdClass::class]);

        // Assert
        $this->assertTrue($validator->isValid());
        $this->assertEmpty($validator->getErrorMessages());
    }

    public function testIfCanNotUseNumericValues(): void
    {
        // Arrange
        $validator = $this->getValidator();
        
        // Act
        $validator->validate([12]);

        // Assert
        $this->assertFalse($validator->isValid());
    }

    public function testIfCanNotUseNull(): void
    {
        // Arrange
        $validator = $this->getValidator();
        
        // Act
        $validator->validate([null]);

        // Assert
        $this->assertFalse($validator->isValid());
    }

    public function testIfCanNotUseObjects(): void
    {
        // Arrange
        $validator = $this->getValidator();
        
        // Act
        $validator->validate([new stdClass()]);

        // Assert
        $this->assertFalse($validator->isValid());
    }

    private function getValidator(): MiddlewareValidationInterface
    {
        return new MiddlewareValidator();
    }
}
