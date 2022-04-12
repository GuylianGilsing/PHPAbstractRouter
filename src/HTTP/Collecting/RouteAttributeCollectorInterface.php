<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\HTTP\Collecting;

use GuylianGilsing\PHPAbstractRouter\Collections\HTTP\HTTPRouteCollectionInterface;

interface RouteAttributeCollectorInterface
{
    /**
     * Attempts to create a HTTP route collection from a class.
     *
     * @param string $className The name to the class. This is the name of `YOUR_CLASS_NAME::class`.
     *
     * @throws ErrorException This exception is thrown if no class name is given.
     * @throws ErrorException This exception is thrown if the class does not exist.
     *
     * @return ?GuylianGilsing\PHPAbstractRouter\Collections\HTTP\HTTPRouteCollectionInterface
     * Returns a HTTP route collection if route attributes can be collected, null otherwise.
     */
    public function collectFromClassName(string $className): ?HTTPRouteCollectionInterface;
}
