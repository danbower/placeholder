<?php

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$defaultFormat = 'png';
$rules = [
    'length' => '^\d+$',
    'width' => '^\d+$',
    'height' => '^\d+$',
    'format' => '^[a-z]{3}$',
];

$collection = new RouteCollection();

$collection->add('home', new Route('/', [
    '_controller' => 'App\\Controller\\HomeController::index',
]));

$collection->add('square_image', new Route(
    '{length}.{format}',
    [
        '_controller' => 'App\\Controller\\ImageController::renderSquare',
        'format' => $defaultFormat,
    ],
    $rules
));

$collection->add('rectangle_image', new Route(
    '{width}/{height}.{format}',
    [
        '_controller' => 'App\\Controller\\ImageController::renderRectangle',
        'format' => $defaultFormat,
    ],
    $rules
));

$collection->add('random_image', new Route(
    'random.{format}',
    [
        '_controller' => 'App\\Controller\\ImageController::renderRandom',
        'format' => $defaultFormat,
    ],
    $rules
));

return $collection;
