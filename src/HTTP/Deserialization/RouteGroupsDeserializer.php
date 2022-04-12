<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\HTTP\Deserialization;

final class RouteGroupsDeserializer
{
    /**
     * @param array<string> $serializedRouteGroups
     *
     * @return array<HTTPRouteGroupInterface>
     */
    public static function deserialize(array $serializedRouteGroups): array
    {
        $deserializedRouteGroups = [];

        foreach ($serializedRouteGroups as $routeGroups)
        {
            if (is_array($routeGroups) && count($routeGroups) > 0)
            {
                $deserializedRouteGroups = array_merge($deserializedRouteGroups, $routeGroups);
            }
        }

        return $deserializedRouteGroups;
    }
}
