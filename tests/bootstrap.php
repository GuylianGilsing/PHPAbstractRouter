<?php
// Include package code
require_once __DIR__.'/../vendor/autoload.php';

// Include test fixtures
require_once __DIR__.'/fixtures/AttributeClasses/SimpleTestClass.php';
require_once __DIR__.'/fixtures/AttributeClasses/OnlyGroupClass.php';
require_once __DIR__.'/fixtures/AttributeClasses/OnlyRoutesClass.php';
require_once __DIR__.'/fixtures/AttributeClasses/ComplexTestClass.php';
 
// Include test mocks
require_once __DIR__.'/integration/Mocks/Dispatching/HTTP/OnlyRoutesRouteDispatcherMock.php';
require_once __DIR__.'/integration/Mocks/Dispatching/HTTP/GroupRouteDispatcherMock.php';
require_once __DIR__.'/integration/Mocks/Dispatching/HTTP/ManualAndClassRoutesDispatcherMock.php';
require_once __DIR__.'/integration/Mocks/Dispatching/HTTP/OrderCheckDispatcherMock.php';
