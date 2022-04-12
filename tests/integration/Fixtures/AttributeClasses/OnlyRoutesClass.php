<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\Fixtures\AttributeClasses;

use GuylianGilsing\PHPAbstractRouter\HTTP\GET;

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
