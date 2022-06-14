<?php

declare(strict_types=1);

namespace PHPAbstractRouter\HTTP\Attributes\Collecting;

use PHPAbstractRouter\HTTP\Abstractions\HTTPRoute;
use PHPAbstractRouter\HTTP\Abstractions\HTTPRouteGroup;

interface RouteAttributeCollectorInterface
{
    /**
     * Collects route attributes from a given class.
     *
     * @param string $className The `CLASS_NAME_HERE::class` string.
     *
     * @throws ErrorException When no class name is given.
     * @throws ErrorException When given class does not exist.
     *
     * @return array<HTTPRoute|HTTPRouteGroup>
     */
    public function fromClass(string $className): array;
}
