<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\HTTP\Collecting\Extracting;

use GuylianGilsing\PHPAbstractRouter\HTTP\Collecting\Extracting\Extractors\RouteGroupsExtractor;
use GuylianGilsing\PHPAbstractRouter\HTTP\Collecting\Extracting\Extractors\RoutesExtractor;
use GuylianGilsing\PHPAbstractRouter\HTTP\Serialization\HTTPRouteGroupInterface;
use GuylianGilsing\PHPAbstractRouter\HTTP\Serialization\HTTPRouteInterface;
use ReflectionClass;

final class RouteAttributeExtractor
{
    private static int $totalRoutesExtracted = 0;

    /**
     * Extracts a given attribute from an instantiated reflection class.
     *
     * @param ReflectionClass $class The reflected class that hold the attributes.
     *
     * @return array<HTTPRouteInterface, HTTPRouteGroupInterface>
     */
    public static function fromReflectionClass(ReflectionClass $class): array
    {
        $extractedRoutes = [];

        $group = RouteGroupsExtractor::extract($class);
        $routes = RoutesExtractor::extract($class, self::$totalRoutesExtracted);

        if ($group !== null)
        {
            self::$totalRoutesExtracted += 1;

            foreach ($routes as $route)
            {
                self::$totalRoutesExtracted += 1;
                $group->addRoute($route);
            }

            $extractedRoutes[] = $group;
        }
        else
        {
            self::$totalRoutesExtracted += count($routes);
            $extractedRoutes = array_merge($extractedRoutes, $routes);
        }

        return $extractedRoutes;
    }
}
