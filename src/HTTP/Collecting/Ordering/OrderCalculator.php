<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\HTTP\Collecting\Ordering;

use GuylianGilsing\PHPAbstractRouter\HTTP\Serialization\HTTPRouteGroupInterface;
use GuylianGilsing\PHPAbstractRouter\HTTP\Serialization\HTTPRouteInterface;

final class OrderCalculator implements OrderCalculatorInterface
{
    /**
     * Calculates the total route count that can be used for ordering.
     *
     * @param array<HTTPRouteInterface, HTTPRouteGroupInterface> $routes
     */
    public function calculate(array $routes): int
    {
        $finalOrderCount = 0;

        foreach ($routes as $route)
        {
            if ($route instanceof HTTPRouteInterface)
            {
                $finalOrderCount += 1;
            }
            elseif ($route instanceof HTTPRouteGroupInterface)
            {
                $finalOrderCount += 1;
                $finalOrderCount += $this->getCountOfGroupRoutes($route);
            }
        }

        return $finalOrderCount;
    }

    private function getCountOfGroupRoutes(HTTPRouteGroupInterface $group): int
    {
        $finalCount = 0;

        foreach ($group->getAllRoutes() as $route)
        {
            $finalCount += 1;
        }

        return $finalCount;
    }
}
