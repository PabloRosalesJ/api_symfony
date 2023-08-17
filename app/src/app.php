<?php
use Crimsoncircle\Controller\LeapYearController;
use Symfony\Component\Routing;

$routes = new Routing\RouteCollection();
$routes->add('leap_year', new Routing\Route('/is_leap_year/{year}', [
    'year' => null,
    '_controller' => LeapYearController::class .'::index',
]));

return $routes;

