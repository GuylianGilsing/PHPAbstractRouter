<?php

declare(strict_types=1);

namespace PHPAbstractRouter\HTTP\Attributes\Extracting\Extractors;

use PHPAbstractRouter\HTTP\Abstractions\HTTPRoute;
use PHPAbstractRouter\HTTP\Attributes\AbstractHTTPRoutingAttribute;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionMethod;

final class RoutesExtractor
{
    /**
     * @param ReflectionClass $class The reflected class that holds the attributes.
     *
     * @return array<HTTPRoute>
     */
    public static function extract(ReflectionClass $class): array
    {
        $extractedRoutes = [];

        foreach ($class->getMethods() as $method)
        {
            $routes = self::getRoutesFromMethod($class, $method);
            $extractedRoutes = array_merge($extractedRoutes, $routes);
        }

        return $extractedRoutes;
    }

    /**
     * @param ReflectionClass $class The reflected class that holds the attributes.
     * @param ReflectionMethod $method The reflected method that holds the attributes.
     *
     * @return array<HTTPRoute>
     */
    private static function getRoutesFromMethod(ReflectionClass $class, ReflectionMethod $method): array
    {
        $routes = [];

        foreach (
            $method->getAttributes(AbstractHTTPRoutingAttribute::class, ReflectionAttribute::IS_INSTANCEOF)
            as $attribute
        ) {
            $attribute = AttributeInstantiator::instantiate($attribute);

            if ($attribute !== null)
            {
                $routes[] = new HTTPRoute(
                    $attribute->getMethod(),
                    $attribute->getPath(),
                    $class->getName(),
                    $method->getName(),
                    $attribute->getMiddlewareStack()
                );
            }
        }

        return $routes;
    }
}
