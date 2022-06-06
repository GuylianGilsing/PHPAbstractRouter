<?php

declare(strict_types=1);

namespace PHPAbstractRouter\HTTP\Attributes\Extracting;

use PHPAbstractRouter\HTTP\Abstractions\HTTPRoute;
use PHPAbstractRouter\HTTP\Abstractions\HTTPRouteGroup;
use PHPAbstractRouter\HTTP\Attributes\Extracting\Extractors\RouteGroupsExtractor;
use PHPAbstractRouter\HTTP\Attributes\Extracting\Extractors\RoutesExtractor;
use ReflectionClass;

final class RouteAttributeExtractor implements RouteAttributeExtractorInterface
{
    /**
     * Extracts a given attribute from an instantiated reflection class.
     *
     * @param ReflectionClass $class The reflected class that hold the attributes.
     *
     * @return array<HTTPRoute|HTTPRouteGroup>
     */
    public function fromReflectionClass(ReflectionClass $class): array
    {
        $extractedRoutes = [];
        $group = RouteGroupsExtractor::extract($class);

        if ($group !== null)
        {
            $routes = RoutesExtractor::extract($class);

            foreach ($routes as $route)
            {
                $group->addRoute($route);
            }

            $extractedRoutes[] = $group;
        }
        else
        {
            $routes = RoutesExtractor::extract($class);
            $extractedRoutes = array_merge($extractedRoutes, $routes);
        }

        return $extractedRoutes;
    }
}
