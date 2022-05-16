<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\HTTP\Collecting\Ordering;

interface OrderCalculatorInterface
{
    /**
     * Calculates the total route count that can be used for ordering.
     *
     * @param array<HTTPRouteInterface, HTTPRouteGroupInterface> $routes
     */
    public function calculate(array $routes): int;
}
