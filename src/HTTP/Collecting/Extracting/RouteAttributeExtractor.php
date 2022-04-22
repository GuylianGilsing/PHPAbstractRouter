<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\HTTP\Collecting\Extracting;

use GuylianGilsing\PHPAbstractRouter\HTTP\Collecting\Extracting\Extractors\RouteGroupsExtractor;
use GuylianGilsing\PHPAbstractRouter\HTTP\Collecting\Extracting\Extractors\RoutesExtractor;
use GuylianGilsing\PHPAbstractRouter\HTTP\Serialization\HTTPRouteGroupInterface;
use GuylianGilsing\PHPAbstractRouter\HTTP\Serialization\HTTPRouteInterface;
use ReflectionClass;

final class RouteAttributeExtractor implements RouteAttributeExtractorInterface
{
    /**
     * Extracts a given attribute from an instantiated reflection class.
     *
     * @param ReflectionClass $class The reflected class that hold the attributes.
     *
     * @return array<HTTPRouteInterface, HTTPRouteGroupInterface>
     */
    public function fromReflectionClass(ReflectionClass $class, int $existingCount = 0): array
    {
        $extractedRoutes = [];
        $group = RouteGroupsExtractor::extract($class, $existingCount);

        if ($group !== null)
        {
            $existingCount += 1;
            $routes = RoutesExtractor::extract($class, $existingCount);

            foreach ($routes as $route)
            {
                $existingCount += 1;
                $group->addRoute($route);
            }

            $extractedRoutes[] = $group;
        }
        else
        {
            $routes = RoutesExtractor::extract($class, $existingCount);
            $extractedRoutes = array_merge($extractedRoutes, $routes);
        }

        return $extractedRoutes;
    }
}
