<?php

declare(strict_types=1);

namespace PHPAbstractRouter\HTTP\Attributes;

use Attribute;

/**
 * Declares a class method as an HTTP GET route.
 */
#[Attribute(Attribute::TARGET_METHOD)]
final class GET extends AbstractBaseHTTPRoutingAttribute
{
    public function getMethod(): string
    {
        return 'GET';
    }
}
