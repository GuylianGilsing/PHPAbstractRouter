<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\HTTP\Serialization;

use GuylianGilsing\PHPAbstractRouter\Collections\Ordering\OrderInterface;

interface HTTPRouteInterface extends OrderInterface
{
    public function getMethod(): string;
    public function getPath(): string;

    /**
     * @return array<string> An array of class strings.
     */
    public function getMiddlewareStack(): array;

    public function getClassString(): string;
    public function getClassMethodCallback(): string;
}
