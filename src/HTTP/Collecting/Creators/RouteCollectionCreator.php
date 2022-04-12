<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\HTTP\Collecting\Creators;

use GuylianGilsing\PHPAbstractRouter\Collections\HTTP\HTTPRouteCollection;
use GuylianGilsing\PHPAbstractRouter\Collections\HTTP\HTTPRouteCollectionInterface;
use GuylianGilsing\PHPAbstractRouter\HTTP\Serialization\HTTPRouteGroupInterface;
use GuylianGilsing\PHPAbstractRouter\HTTP\Serialization\HTTPRouteInterface;

final class RouteCollectionCreator
{
    /**
     * @param array<HTTPRouteInterface|HTTPRouteGroupInterface> $routes
     */
    public static function create(array $routes): HTTPRouteCollectionInterface
    {
        $collection = new HTTPRouteCollection();

        foreach ($routes as $route)
        {
            if ($route instanceof HTTPRouteInterface)
            {
                $collection->addRoute($route);
            }
            elseif ($route instanceof HTTPRouteGroupInterface)
            {
                $collection->addRouteGroup($route);
            }
        }

        return $collection;
    }
}
