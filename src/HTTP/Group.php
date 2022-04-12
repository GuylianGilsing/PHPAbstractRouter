<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\HTTP;

use Attribute;
use ErrorException;
use GuylianGilsing\PHPAbstractRouter\HTTP\Validation\Middleware\MiddlewareValidationInterface;
use GuylianGilsing\PHPAbstractRouter\HTTP\Validation\Middleware\MiddlewareValidator;

/**
 * Declares a class as a group of HTTP routes.
 */
#[Attribute(Attribute::TARGET_CLASS)]
final class Group
{
    private string $path = '';

    /**
     * @var array<string> $middlewareStack An array of class strings.
     */
    private array $middlewareStack = [];

    private ?MiddlewareValidationInterface $middlewareValidator = null;

    /**
     * @param string $path The route group path.
     * @param array<string> $middlewareStack An array of class strings.
     * @param MiddlewareValidationInterface $middlewareValidator A validator for the middleware stack class strings.
     */
    public function __construct(
        string $path,
        array $middlewareStack,
        MiddlewareValidationInterface $middlewareValidator = new MiddlewareValidator()
    ) {
        $this->path = $path;
        $this->middlewareStack = $middlewareStack;
        $this->middlewareValidator = $middlewareValidator;

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

    /**
     * Validate an array of class strings.
     *
     * @param array<string> $middlewareStack An array of class strings.
     */
    private function validateMiddlewareArray(array $middlewareStack): void
    {
        $this->middlewareValidator->validate($middlewareStack);

        if (!$this->middlewareValidator->isValid())
        {
            throw new ErrorException($this->middlewareValidator->getErrorMessages()[0]);
        }
    }
}
