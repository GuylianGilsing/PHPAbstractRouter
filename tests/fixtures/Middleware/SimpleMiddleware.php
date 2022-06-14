<?php

declare(strict_types=1);

namespace PHPAbstractRouter\Tests\Fixtures\Middleware;

final class SimpleMiddleware
{
    public function __invoke(): string
    {
        return "Hello World";
    }
}
