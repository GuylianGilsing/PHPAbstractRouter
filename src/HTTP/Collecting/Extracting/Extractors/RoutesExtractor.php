<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\HTTP\Collecting\Extracting\Extractors;

use GuylianGilsing\PHPAbstractRouter\HTTP\AbstractHTTPRoutingAttribute;
use GuylianGilsing\PHPAbstractRouter\HTTP\Serialization\HTTPRoute;
use GuylianGilsing\PHPAbstractRouter\HTTP\Serialization\HTTPRouteInterface;
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
        $routes = [];

        foreach ($class->getMethods() as $method)
        {
            $routes = array_merge($routes, self::getRoutesFromMethod($class, $method, $existingCount));
        }

        return $routes;
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

        foreach ($method->getAttributes(AbstractHTTPRoutingAttribute::class) as $attribute)
        {
            $attribute = AttributeInstantiator::instantiate($attribute);

            if ($attribute !== null && $attribute instanceof AbstractHTTPRoutingAttribute)
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
