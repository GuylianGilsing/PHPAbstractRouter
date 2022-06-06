<?php

declare(strict_types=1);

namespace PHPAbstractRouter\HTTP\Abstractions\Deserialization;

use PHPAbstractRouter\HTTP\Abstractions\HTTPRoute;

final class RoutesDeserializer
{
    /**
     * @param array<string> $serializedRoutes
     *
     * @return array<HTTPRoute>
     */
    public static function deserialize(array $serializedRoutes): array
    {
        $deserializedRoutes = [];

        foreach ($serializedRoutes as $methodCollection)
        {
            if (is_array($methodCollection) && count($methodCollection) > 0)
            {
                $routes = array_values($methodCollection);
                $deserializedRoutes = array_merge($deserializedRoutes, $routes);
            }
        }

        return $deserializedRoutes;
    }
}
