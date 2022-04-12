<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\HTTP\Validation\Middleware;

interface MiddlewareValidationInterface
{
    /**
     * Validate an array of class strings.
     *
     * @param array<string> $middlewareStack An array of class strings.
     */
    public function validate(array $middlewareStack): void;

    /**
     * Indicates if the `validate()` method was succesful.
     */
    public function isValid(): bool;

    /**
     * @return array<string>
     */
    public function getErrorMessages(): array;
}
