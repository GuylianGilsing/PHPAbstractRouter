<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\HTTP\Collecting;

use ErrorException;
use GuylianGilsing\PHPAbstractRouter\Collections\HTTP\HTTPRouteCollectionInterface;
use GuylianGilsing\PHPAbstractRouter\HTTP\Collecting\Creators\RouteCollectionCreator;
use GuylianGilsing\PHPAbstractRouter\HTTP\Collecting\Extracting\RouteAttributeExtractor;
use ReflectionClass;

final class RouteAttributeCollector implements RouteAttributeCollectorInterface
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
    public function collectFromClassName(string $className): ?HTTPRouteCollectionInterface
    {
        if (strlen($className) === 0)
        {
            throw new ErrorException('No class name given. Please enter a class name.');
        }

        if (!class_exists($className))
        {
            throw new ErrorException('Given class name does not exist. Please enter a valid class name.');
        }

        $reflectionClass = new ReflectionClass($className);
        $routes = RouteAttributeExtractor::fromReflectionClass($reflectionClass);

        if (count($routes) === 0)
        {
            return null;
        }

        return RouteCollectionCreator::create($routes);
    }
}
