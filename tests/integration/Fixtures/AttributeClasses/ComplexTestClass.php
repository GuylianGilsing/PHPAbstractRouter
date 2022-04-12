<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\Fixtures\AttributeClasses;

use GuylianGilsing\PHPAbstractRouter\HTTP\GET;
use GuylianGilsing\PHPAbstractRouter\HTTP\Group;
use GuylianGilsing\PHPAbstractRouter\HTTP\POST;

#[Group('/test')]
final class ComplexTestClass
{
    #[GET('/')]
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
