<?php

declare(strict_types=1);

use GuylianGilsing\PHPAbstractRouter\HTTP\Collecting\Extracting\Extractors\RoutesExtractor;
use GuylianGilsing\PHPAbstractRouter\Tests\Fixtures\AttributeClasses\ComplexTestClass;
use GuylianGilsing\PHPAbstractRouter\Tests\Fixtures\AttributeClasses\OnlyRoutesClass;

require_once __DIR__.'/../vendor/autoload.php';

require_once __DIR__.'/../tests/fixtures/AttributeClasses/ComplexTestClass.php';

$reflectionClass = new ReflectionClass(ComplexTestClass::class);

$routes = RoutesExtractor::extract($reflectionClass);

foreach($routes as $route)
{
    echo $route->getMethod().' path: '.$route->getPath().' order: '.$route->getOrder().'<br/>';
}
