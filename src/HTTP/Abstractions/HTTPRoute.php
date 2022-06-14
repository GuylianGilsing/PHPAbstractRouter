<?php

declare(strict_types=1);

namespace PHPAbstractRouter\HTTP\Abstractions;

use ErrorException;
use PHPAbstractRouter\HTTP\Validation\Middleware\MiddlewareValidationInterface;
use PHPAbstractRouter\HTTP\Validation\Middleware\MiddlewareValidator;

final class HTTPRoute
{
    private string $method = '';
    private string $path = '';
    private string $className = '';
    private string $classMethod = '';

    /**
     * @var array<string> $middlewareStack
     */
    private array $middlewareStack = [];

    private ?MiddlewareValidationInterface $middlewareValidator = null;

    /**
     * @param string $method The HTTP method.
     * @param string $path The path/url of the route
     * @param string $className The `CLASS_NAME_HERE::class` string.
     * @param string $classMethod The name of the method inside the class that you want to tie to this route.
     * (Use an empty string to use the class's magic methods.)
     * Middleware will be invoked through class magic methods,
     * @param array<string> $middlewareStack An array of `CLASS_NAME_HERE::class` strings.
     * Middleware will be invoked through class magic methods,
     * @param MiddlewareValidationInterface
     * $middlewareValidator A validator for the middleware stack class strings.
     */
    public function __construct(
        string $method,
        string $path,
        string $className,
        string $classMethod,
        array $middlewareStack = [],
        MiddlewareValidationInterface $middlewareValidator = new MiddlewareValidator()
    ) {
        $this->method = $method;
        $this->path = $path;
        $this->className = $className;
        $this->classMethod = $classMethod;
        $this->middlewareStack = $middlewareStack;
        $this->middlewareValidator = $middlewareValidator;

        $this->validateMiddlewareArray($middlewareStack);
    }

    public function getMethod(): string
    {
        return $this->method;
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

    public function getClassName(): string
    {
        return $this->className;
    }

    public function getClassMethod(): string
    {
        return $this->classMethod;
    }

    /**
     * Validate an array of class strings.
     *
     * @param array<string> $middlewareStack An array of class strings.
     *
     * @throws ErrorException Throws this exception if the middleware string is not valid.
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
