<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\HTTP;

use Attribute;

/**
 * Declares a class method as an HTTP DELETE route.
 */
#[Attribute(Attribute::TARGET_METHOD)]
final class DELETE extends AbstractBaseHTTPRoutingAttribute
{
    public function getMethod(): string
    {
        return 'DELETE';
    }
}
