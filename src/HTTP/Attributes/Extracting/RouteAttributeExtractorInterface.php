<?php

declare(strict_types=1);

namespace PHPAbstractRouter\HTTP\Attributes\Extracting;

use PHPAbstractRouter\HTTP\Abstractions\HTTPRoute;
use PHPAbstractRouter\HTTP\Abstractions\HTTPRouteGroup;
use ReflectionClass;

interface RouteAttributeExtractorInterface
{
    /**
     * Extracts a given attribute from an instantiated reflection class.
     *
     * @param ReflectionClass $class The reflected class that hold the attributes.
     *
     * @return array<HTTPRoute|HTTPRouteGroup>
     */
    public function fromReflectionClass(ReflectionClass $class): array;
}
