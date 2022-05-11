<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\Collections\HTTP;

use GuylianGilsing\PHPAbstractRouter\HTTP\Serialization\HTTPRouteGroupInterface;
use GuylianGilsing\PHPAbstractRouter\HTTP\Serialization\HTTPRouteInterface;

interface HTTPRouteCollectionInterface
{
    /**
     * @param HTTPRouteInterface $route The route you want to check.
     */
    public function hasRoute(HTTPRouteInterface $route): bool;

    /**
     * @param HTTPRouteInterface $route The route you want to add.
     */
    public function addRoute(HTTPRouteInterface $route): void;

    /**
     * @return array<HTTPRouteInterface>
     */
    public function getAllRoutes(): array;

    /**
     * @param HTTPRouteGroupInterface $group The route group you want to add.
     */
    public function addRouteGroup(HTTPRouteGroupInterface $group): void;

    /**
     * @return array<HTTPRouteGroupInterface>
     */
    public function getAllRouteGroups(): array;

    /**
     * Returns the count of the total amount of routes inside this collection.
     */
    public function getTotalRouteCount(): int;
}
