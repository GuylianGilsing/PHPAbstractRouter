<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\HTTP\Collecting\Extracting\Extractors;

use GuylianGilsing\PHPAbstractRouter\HTTP\AbstractHTTPRoutingAttribute;
use GuylianGilsing\PHPAbstractRouter\HTTP\Serialization\HTTPRoute;
use GuylianGilsing\PHPAbstractRouter\HTTP\Serialization\HTTPRouteInterface;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionMethod;

final class RoutesExtractor
{
    /**
     * @param ReflectionClass $class The reflected class that holds the attributes.
     * @param int $existingCount The count of the total added routes.
     *
     * @return array<HTTPRouteInterface>
     */
    public static function extract(ReflectionClass $class, int $existingCount = 0): array
    {
        $extractedRoutes = [];

        foreach ($class->getMethods() as $method)
        {
            $routes = self::getRoutesFromMethod($class, $method, $existingCount);
            $extractedRoutes = array_merge($extractedRoutes, $routes);

            $existingCount += count($routes);
        }

        return $extractedRoutes;
    }

    /**
     * @param ReflectionMethod $method The reflected method that holds the attributes.
     *
     * @return array<HTTPRouteInterface>
     */
    private static function getRoutesFromMethod(
        ReflectionClass $class,
        ReflectionMethod $method,
        int $existingCount = 0
    ): array {
        $routes = [];

        foreach (
            $method->getAttributes(AbstractHTTPRoutingAttribute::class, ReflectionAttribute::IS_INSTANCEOF)
            as $attribute
        ) {
            $attribute = AttributeInstantiator::instantiate($attribute);

            if ($attribute !== null)
            {
                $existingCount += 1;

                $routes[] = new HTTPRoute(
                    $attribute->getMethod(),
                    $attribute->getPath(),
                    $existingCount,
                    $class->getName(),
                    $method->getName(),
                    $attribute->getMiddlewareStack()
                );
            }
        }

        return $routes;
    }
}
