<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\HTTP\Validation\Middleware;

final class MiddlewareValidator implements MiddlewareValidationInterface
{
    /**
     * @var array<string> $errorMessages
     */
    private array $errorMessages = [];

    /**
     * Validate an array of class strings.
     *
     * @param array<string> $middlewareStack An array of class strings.
     */
    public function validate(array $middlewareStack): void
    {
        $this->errorMessages = [];

        foreach ($middlewareStack as $middleware)
        {
            if (!is_string($middleware))
            {
                $this->errorMessages[] = '
                    Given value in middleware stack is not a string. Please enter a valid class file path.
                ';
                return;
            }

            if (!class_exists($middleware, false))
            {
                $this->errorMessages[] = '
                    Given middleware class name does not exist. Please enter a valid class name.
                ';
                return;
            }
        }
    }

    public function isValid(): bool
    {
        return count($this->errorMessages) === 0;
    }

    /**
     * @return array<string>
     */
    public function getErrorMessages(): array
    {
        return $this->errorMessages;
    }
}
