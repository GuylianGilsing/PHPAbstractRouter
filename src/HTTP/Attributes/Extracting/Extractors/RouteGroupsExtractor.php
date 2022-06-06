<?php

declare(strict_types=1);

namespace PHPAbstractRouter\HTTP\Attributes\Extracting\Extractors;

use PHPAbstractRouter\HTTP\Abstractions\HTTPRouteGroup;
use PHPAbstractRouter\HTTP\Attributes\Group;
use ReflectionClass;

final class RouteGroupsExtractor
{
    /**
     * @param ReflectionClass $class The reflected class that hold the attributes.
     */
    public static function extract(ReflectionClass $class): ?HTTPRouteGroup
    {
        $groupAttributes = [];

        foreach ($class->getAttributes(Group::class) as $groupAttribute)
        {
            $attribute = AttributeInstantiator::instantiate($groupAttribute);

            if ($attribute !== null && $attribute instanceof Group)
            {
                $groupAttributes[] = new HTTPRouteGroup(
                    $attribute->getPath(),
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
