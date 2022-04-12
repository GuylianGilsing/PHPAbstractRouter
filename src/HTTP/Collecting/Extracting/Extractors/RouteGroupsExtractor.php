<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\HTTP\Collecting\Extracting\Extractors;

use GuylianGilsing\PHPAbstractRouter\HTTP\Group;
use GuylianGilsing\PHPAbstractRouter\HTTP\Serialization\HTTPRouteGroup;
use GuylianGilsing\PHPAbstractRouter\HTTP\Serialization\HTTPRouteGroupInterface;
use ReflectionClass;

final class RouteGroupsExtractor
{
    /**
     * @param ReflectionClass $class The reflected class that hold the attributes.
     * @param int $existingCount The count of the total added routes.
     */
    public static function extract(ReflectionClass $class, int $existingCount = 0): ?HTTPRouteGroupInterface
    {
        $groupAttributes = [];

        foreach ($class->getAttributes(Group::class) as $groupAttribute)
        {
            $attribute = AttributeInstantiator::instantiate($groupAttribute);

            if ($attribute !== null && $attribute instanceof Group)
            {
                $existingCount += 1;

                $groupAttributes[] = new HTTPRouteGroup(
                    $attribute->getPath(),
                    $existingCount,
                    $attribute->getMiddlewareStack()
                );
            }
        }

        $groupAttributesAmount = count($groupAttributes);

        if ($groupAttributesAmount === 0)
        {
            return null;
        }

        return $groupAttributes[$groupAttributesAmount - 1];
    }
}
