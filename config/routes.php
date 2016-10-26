<?php

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$collection = new RouteCollection();

$collection->add('home', new Route('/', [
    '_controller' => 'App\\Controller\\HomeController::index',
]));

$collection->add('square_image', new Route(
    '{length}.{format}',
    [
        '_controller' => 'App\\Controller\\Image\\SquareController::render',
        'format' => 'png',
    ],
    [
        'length' => '^\d+$',
        'format' => '^[a-z]{3}$',
    ]
));

return $collection;
