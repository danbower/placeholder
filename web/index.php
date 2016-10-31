<?php

use Symfony\Component\HttpFoundation\Request;

require __DIR__ . '/../vendor/autoload.php';

$container = require __DIR__ . '/../config/container.php';

$httpCache = $container->get('http_cache');

$request = Request::createFromGlobals();
$response = $httpCache->handle($request);

$response->send();

$httpCache->terminate($request, $response);
