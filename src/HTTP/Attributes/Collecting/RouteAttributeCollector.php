<?php

declare(strict_types=1);

namespace PHPAbstractRouter\HTTP\Attributes\Collecting;

use ErrorException;
use PHPAbstractRouter\HTTP\Abstractions\HTTPRoute;
use PHPAbstractRouter\HTTP\Abstractions\HTTPRouteGroup;
use PHPAbstractRouter\HTTP\Attributes\Extracting\RouteAttributeExtractorInterface;
use ReflectionClass;

final class RouteAttributeCollector implements RouteAttributeCollectorInterface
{
    private RouteAttributeExtractorInterface $routeAttributeExtractor;

    public function __construct(RouteAttributeExtractorInterface $routeAttributeExtractor)
    {
        $this->routeAttributeExtractor = $routeAttributeExtractor;
    }

    /**
     * @param string $className The `CLASS_NAME_HERE::class` string.
     *
     * @throws ErrorException When no class name is given.
     * @throws ErrorException When given class does not exist.
     *
     * @return array<HTTPRoute|HTTPRouteGroup>
     */
    public function fromClass(string $className): array
    {
        if (strlen($className) === 0)
        {
            throw new ErrorException('No class name given. Please enter a class name.');
        }

        if (!class_exists($className))
        {
            throw new ErrorException(
                'Given class name "'.$className.'" does not exist. Please enter a valid class name.'
            );
        }

        $reflectionClass = new ReflectionClass($className);
        return $this->routeAttributeExtractor->fromReflectionClass($reflectionClass);
    }
}
