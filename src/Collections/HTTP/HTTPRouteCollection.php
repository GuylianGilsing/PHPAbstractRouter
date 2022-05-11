<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\Collections\HTTP;

use ErrorException;
use GuylianGilsing\PHPAbstractRouter\HTTP\Deserialization\RouteGroupsDeserializer;
use GuylianGilsing\PHPAbstractRouter\HTTP\Deserialization\RoutesDeserializer;
use GuylianGilsing\PHPAbstractRouter\HTTP\Serialization\HTTPRouteGroupInterface;
use GuylianGilsing\PHPAbstractRouter\HTTP\Serialization\HTTPRouteInterface;

final class HTTPRouteCollection implements HTTPRouteCollectionInterface
{
    /**
     * @var array<HTTPRouteInterface> $routes
     */
    private array $routes = [];

    /**
     * @var array<HTTPRouteGroupInterface> $routes
     */
    private array $routeGroups = [];

    /**
     * @param HTTPRouteInterface $route The route you want to check.
     */
    public function hasRoute(HTTPRouteInterface $route): bool
    {
        return isset($this->routes[$route->getPath()]) &&
               isset($this->routes[$route->getPath()][$route->getMethod()]);
    }

    /**
     * @param HTTPRouteInterface $route The route you want to add.
     */
    public function addRoute(HTTPRouteInterface $route): void
    {
        if ($this->hasRoute($route))
        {
            throw new ErrorException('Given route already exists within collection.');
        }

        $this->registerKeyWithEmptyArrayIfNotExists($this->routes, $route->getPath());
        $this->routes[$route->getPath()][$route->getMethod()] = $route;
    }

    /**
     * @return array<HTTPRouteInterface>
     */
    public function getAllRoutes(): array
    {
        return RoutesDeserializer::deserialize($this->routes);
    }

    /**
     * @param HTTPRouteGroupInterface $group The route group you want to add.
     */
    public function addRouteGroup(HTTPRouteGroupInterface $group): void
    {
        $this->registerKeyWithEmptyArrayIfNotExists($this->routeGroups, $group->getPath());
        $this->routeGroups[$group->getPath()][] = $group;
    }

    /**
     * @return array<HTTPRouteGroupInterface>
     */
    public function getAllRouteGroups(): array
    {
        return RouteGroupsDeserializer::deserialize($this->routeGroups);
    }

    public function getTotalRouteCount(): int
    {
        $routeCount = count($this->routes);
        $groupCount = $this->getRouteGroupCount();

        return $routeCount + $groupCount;
    }

    /**
     * Registers a key => value pair inside an array if the key is not set. The value will always be an empty array.
     *
     * @param array<string> $array The array that needs to register the key.
     * @param string $key The key you want to register.
     */
    private function registerKeyWithEmptyArrayIfNotExists(array &$array, string $key): void
    {
        if (!isset($array[$key]))
        {
            $array[$key] = [];
        }
    }

    private function getRouteGroupCount(): int
    {
        $count = 0;

        foreach ($this->routeGroups as $group)
        {
            $count += $group->getTotalRouteCount();
        }

        return $count;
    }
}
