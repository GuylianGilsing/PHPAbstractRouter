<?php

declare(strict_types=1);

namespace PHPAbstractRouter\Tests\Fixtures\AttributeClasses;

use PHPAbstractRouter\HTTP\Attributes\GET;

final class OnlyRoutesClass
{
    #[GET('/')]
    public function renderIndex() : string
    {
        return "index.php";
    }

    #[GET('/about')]
    public function renderAbout() : string
    {
        return "about.php";
    }
}
