<?php

declare(strict_types=1);

use GuylianGilsing\PHPAbstractRouter\HTTP\Collecting\Extracting\RouteAttributeExtractor;
use GuylianGilsing\PHPAbstractRouter\Tests\Fixtures\AttributeClasses\SimpleTestClass;

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../tests/fixtures/AttributeClasses/SimpleTestClass.php';

$extractor = new RouteAttributeExtractor();
$reflectionClass = new ReflectionClass(SimpleTestClass::class);

$routes = $extractor->fromReflectionClass($reflectionClass);

$groupRoutes = $routes[0]->getAllRoutes();

echo 'GROUP path: '.$routes[0]->getPath().' order: '.$routes[0]->getOrder().'<br/>';


foreach($groupRoutes as $groupRoute)
{
    echo $groupRoute->getMethod().' path: '.$groupRoute->getPath().' order: '.$groupRoute->getOrder().'<br/>';
}
