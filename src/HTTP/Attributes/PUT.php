<?php

declare(strict_types=1);

namespace PHPAbstractRouter\HTTP\Attributes;

use Attribute;

/**
 * Declares a class method as an HTTP PUT route.
 */
#[Attribute(Attribute::TARGET_METHOD)]
final class PUT extends AbstractBaseHTTPRoutingAttribute
{
    public function getMethod(): string
    {
        return 'PUT';
    }
}
