<?php

declare(strict_types=1);

namespace PHPAbstractRouter\HTTP\Attributes;

use PHPAbstractRouter\HTTP\Validation\Middleware\MiddlewareValidationInterface;
use PHPAbstractRouter\HTTP\Validation\Middleware\MiddlewareValidator;

/**
 * Base HTTP routing attribute.
 */
abstract class AbstractBaseHTTPRoutingAttribute extends AbstractHTTPRoutingAttribute
{
    private string $path = '';

    /**
     * @var array<string> $middlewareStack
     */
    private array $middlewareStack = [];

    /**
     * @param string $path The path of the route.
     * @param array<string> $middlewareStack An array of class strings.
     * @param GuylianGilsing\PHPAbstractRouter\HTTP\Validation\Middleware\MiddlewareValidationInterface
     * $middlewareValidator A validator for the middleware stack class strings.
     */
    public function __construct(
        string $path,
        array $middlewareStack = [],
        MiddlewareValidationInterface $middlewareValidator = new MiddlewareValidator()
    ) {
        $this->path = $path;
        $this->middlewareStack = $middlewareStack;
        parent::__construct($middlewareValidator);

        $this->validateMiddlewareArray($middlewareStack);
    }

    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return array<string> An array of class strings.
     */
    public function getMiddlewareStack(): array
    {
        return $this->middlewareStack;
    }
}
