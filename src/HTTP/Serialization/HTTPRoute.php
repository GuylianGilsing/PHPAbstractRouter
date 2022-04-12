<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\HTTP\Serialization;

use ErrorException;
use GuylianGilsing\PHPAbstractRouter\HTTP\Validation\Middleware\MiddlewareValidationInterface;
use GuylianGilsing\PHPAbstractRouter\HTTP\Validation\Middleware\MiddlewareValidator;

final class HTTPRoute implements HTTPRouteInterface
{
    private string $method = '';
    private string $path = '';
    private int $order = 0;
    private string $classString = '';
    private string $classMethodCallback = '';

    /**
     * @var array<string> $middlewareStack
     */
    private array $middlewareStack = [];

    private ?MiddlewareValidationInterface $middlewareValidator = null;

    /**
     * @param string $method The route method.
     * @param string $path The route path.
     * @param int $order The index at which this route has been registered in a
     * global combined stack of routes and route groups.
     * @param array<string> $middlewareStack An array of class strings.
     * @param MiddlewareValidationInterface
     * $middlewareValidator A validator for the middleware stack class strings.
     */
    public function __construct(
        string $method,
        string $path,
        int $order,
        string $classString,
        string $classMethodCallback,
        array $middlewareStack = [],
        MiddlewareValidationInterface $middlewareValidator = new MiddlewareValidator()
    ) {
        $this->method = $method;
        $this->path = $path;
        $this->order = $order;
        $this->classString = $classString;
        $this->classMethodCallback = $classMethodCallback;
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

    public function getOrder(): int
    {
        return $this->order;
    }

    /**
     * @return array<string> An array of class strings.
     */
    public function getMiddlewareStack(): array
    {
        return $this->middlewareStack;
    }

    public function getClassString(): string
    {
        return $this->classString;
    }

    public function getClassMethodCallback(): string
    {
        return $this->classMethodCallback;
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
