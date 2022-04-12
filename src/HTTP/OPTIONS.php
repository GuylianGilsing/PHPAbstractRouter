<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\HTTP;

use Attribute;

/**
 * Declares a class method as an HTTP OPTIONS route.
 */
#[Attribute(Attribute::TARGET_METHOD)]
final class OPTIONS extends AbstractBaseHTTPRoutingAttribute
{
    public function getMethod(): string
    {
        return 'OPTIONS';
    }
}
