<?php
use Crimsoncircle\Controller\CommentController;
use Crimsoncircle\Controller\LeapYearController;
use Crimsoncircle\Controller\BlogController;
use Symfony\Component\Routing;

$routes = new Routing\RouteCollection();
$routes->add('leap_year', new Routing\Route('/is_leap_year/{year}', [
    'year' => null,
    '_controller' => LeapYearController::class .'::index',
]));


$routes->add('blog.store', new Routing\Route('/blog', [
    '_controller' => [BlogController::class, 'store'],
]));

$routes->add('blog.find', new Routing\Route('/blog/{slug}', [
    'slug' => null,
    '_controller' => [BlogController::class, 'find'],
    // '_method' => 'GET',
]/* , [], [], '', ['GET'] */));

$routes->add('blog.delete', new Routing\Route('/blog/{slug}/delete', [
    'slug' => null,
    '_controller' => [BlogController::class, 'delete'],
    '_method' => 'DELETE',
]/* , [], [], '', ['DELETE']  */));

/* Comments */

$routes->add('commets.store', new Routing\Route('/commet', [
    '_controller' => [CommentController::class, 'store'],
]));

$routes->add('commets.show', new Routing\Route('/commet/{comment_id}', [
    '_controller' => [CommentController::class, 'find'],
]));

$routes->add('commets.delete', new Routing\Route('/commet/{comment_id}/delete', [
    '_controller' => [CommentController::class, 'delete'],
]));

$routes->add('commets.list.post', new Routing\Route('/comment/post/{post_id}', [
    'post_id' => 0,
    '_controller' => [CommentController::class, 'listByPost'],
]));

return $routes;

