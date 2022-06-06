<?php

declare(strict_types=1);

namespace PHPAbstractRouter\Tests\Fixtures\AttributeClasses;

use PHPAbstractRouter\HTTP\Attributes\GET;
use PHPAbstractRouter\HTTP\Attributes\Group;
use PHPAbstractRouter\HTTP\Attributes\POST;
use PHPAbstractRouter\Tests\Fixtures\Middleware\SimpleMiddleware;

#[Group('/test', [SimpleMiddleware::class])]
final class ComplexTestClass
{
    #[GET('/', [SimpleMiddleware::class])]
    public function renderIndex() : string
    {
        return "index.php";
    }

    #[POST('/')]
    public function indexPOST() : string
    {
        return "POST index.php";
    }

    #[GET('/about')]
    public function renderAbout() : string
    {
        return "about.php";
    }

    #[POST('/about')]
    public function aboutPOST() : string
    {
        return "POST about.php";
    }
}
