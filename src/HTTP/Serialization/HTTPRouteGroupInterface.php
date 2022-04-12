<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\HTTP\Serialization;

interface HTTPRouteGroupInterface
{
    public function getPath(): string;

    /**
     * @return array<string> An array of class strings.
     */
    public function getMiddlewareStack(): array;

    /**
     * @param HTTPRouteInterface $route The route that you want to check.
     */
    public function routeExists(HTTPRouteInterface $route): bool;

    /**
     * @param HTTPRouteInterface $route The route that you want to add.
     */
    public function addRoute(HTTPRouteInterface $route): void;

    /**
     * @return array<HTTPRouteInterface>
     */
    public function getAllRoutes(): array;
}
