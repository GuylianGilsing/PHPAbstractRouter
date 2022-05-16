<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\Tests\Integration\Mocks\Dispatching\HTTP;

use ErrorException;
use GuylianGilsing\PHPAbstractRouter\Collections\HTTP\HTTPRouteCollectionInterface;
use GuylianGilsing\PHPAbstractRouter\Dispatching\HTTP\HTTPRouteDispatcherInterface;
use PHPUnit\Framework\TestCase;

final class OrderCheckDispatcherMock extends TestCase implements HTTPRouteDispatcherInterface
{
    public function dispatch(array $routeCollections): void
    {
        $order = 0;
        foreach ($routeCollections as $routeCollection)
        {
            $this->checkOrder($routeCollection, $order);
            $order += $routeCollection->getTotalRouteCount();
        }
    }

    private function checkOrder(HTTPRouteCollectionInterface $collection, int $order): void
    {
        $totalRoutes = $collection->getTotalRouteCount();
        $currentRouteCount = 0;

        $routes = $collection->getAllRoutes();
        $groups = $collection->getAllRouteGroups();

        $routeIndex = 0;
        $groupIndex = 0;

        $oldRouteCount = 0;
        while ($currentRouteCount < $totalRoutes)
        {
            $oldRouteCount = $currentRouteCount;
            $order += 1;

            if (isset($routes[$routeIndex]) && $routes[$routeIndex]->getOrder() === $order)
            {
                $this->assertEquals($order, $routes[$routeIndex]->getOrder()); // Removes risky test warning

                $routeIndex += 1;
                $currentRouteCount += 1;
            }
            else if (isset($groups[$groupIndex]))
            {
                $currentRouteCount += 1;

                $this->assertEquals($order, $groups[$groupIndex]->getOrder());
                foreach ($groups[$groupIndex]->getAllRoutes() as $route)
                {
                    $order += 1;
                    $this->assertEquals($order, $route->getOrder());
                    $currentRouteCount += 1;
                }

                $groupIndex += 1;
            }

            if ($oldRouteCount === $currentRouteCount)
            {
                $this->throwException(new ErrorException("Route collection order is not correct."));
            }
        }
    }
}
