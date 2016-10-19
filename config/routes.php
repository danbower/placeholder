<?php

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$collection = new RouteCollection();

$collection->add('home', new Route('/', [
    '_controller' => 'App\\Controller\\HomeController::index',
]));

return $collection;
