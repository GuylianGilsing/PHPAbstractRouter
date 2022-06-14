<?php

declare(strict_types=1);

namespace PHPAbstractRouter\HTTP\Attributes;

use ErrorException;
use PHPAbstractRouter\HTTP\Validation\Middleware\MiddlewareValidationInterface;
use PHPAbstractRouter\HTTP\Validation\Middleware\MiddlewareValidator;

/**
 * Provides base functionality for a HTTP routing attribute.
 */
abstract class AbstractHTTPRoutingAttribute
{
    protected ?MiddlewareValidationInterface $middlewareValidator = null;

    /**
     * @param GuylianGilsing\PHPAbstractRouter\HTTP\Validation\Middleware\MiddlewareValidationInterface
     * $middlewareValidator A validator for the middleware stack class strings.
     */
    public function __construct(MiddlewareValidationInterface $middlewareValidator = new MiddlewareValidator())
    {
        $this->middlewareValidator = $middlewareValidator;
    }

    abstract public function getMethod(): string;

    abstract public function getPath(): string;

    /**
     * @return array<string> An array of class strings.
     */
    abstract public function getMiddlewareStack(): array;

    /**
     * Validates an array with the internally registered middleware validator
     * to make sure that every middleware string is registered properly.
     *
     * @param array<string> $middlewareStack an array of class strings.
     *
     * @throws ErrorException Throws an error when a non-compatible class string is found.
     */
    protected function validateMiddlewareArray(array $middlewareStack): void
    {
        $this->middlewareValidator->validate($middlewareStack);

        if (!$this->middlewareValidator->isValid())
        {
            throw new ErrorException($this->middlewareValidator->getErrorMessages()[0]);
        }
    }
}
