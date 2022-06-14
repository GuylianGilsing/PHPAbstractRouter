<?php

declare(strict_types=1);

namespace PHPAbstractRouter\Tests\Fixtures\AttributeClasses;

use PHPAbstractRouter\HTTP\Attributes\GET;
use PHPAbstractRouter\HTTP\Attributes\Group;

#[Group('/test')]
final class SimpleTestClass
{
    #[GET('')]
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
