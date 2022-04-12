<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\HTTP\Collecting\Extracting\Extractors;

use Exception;
use ReflectionAttribute;

final class AttributeInstantiator
{
    /**
     * @param string $attributeName The class string of the attribute.
     *
     * @return ?object Either returns an instantiated attribute, or null.
     */
    public static function instantiate(ReflectionAttribute $attr): ?object
    {
        try
        {
            return $attr->newInstance();
        }
        catch (Exception $e)
        {
            return null;
        }
    }
}
