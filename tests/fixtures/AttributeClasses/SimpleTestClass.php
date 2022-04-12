<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\Tests\Fixtures\AttributeClasses;

use GuylianGilsing\PHPAbstractRouter\HTTP\GET;
use GuylianGilsing\PHPAbstractRouter\HTTP\Group;

#[Group('/test')]
final class SimpleTestClass
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
