<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\HTTP\Collecting\Extracting;

use ReflectionClass;

interface RouteAttributeExtractorInterface
{
    /**
     * Extracts a given attribute from an instantiated reflection class.
     *
     * @param ReflectionClass $class The reflected class that hold the attributes.
     *
     * @return array<HTTPRouteInterface, HTTPRouteGroupInterface>
     */
    public function fromReflectionClass(ReflectionClass $class, int $existingCount = 0): array;
}
