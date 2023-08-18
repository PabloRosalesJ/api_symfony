<?php
require_once __DIR__.'/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Crimsoncircle\Simplex\StringResponseListener;
use Symfony\Component\DependencyInjection\Reference;

use Illuminate\Database\Capsule\Manager as Capsule;
// use Illuminate\Events\Dispatcher;
// use Illuminate\Container\Container;
/* Eloquent */

$capsule = new Capsule;

$capsule->addConnection([
    'driver' => 'mysql',
    'host' => 'db',
    'database' => 'app',
    'username' => 'root',
    'password' => 'crimsoncircle',
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
]);

// Set the event dispatcher used by Eloquent models... (optional)
// $capsule->setEventDispatcher(new Dispatcher(new Container));

// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();

/* Create table with blueprint */

// $table = Capsule::schema()->create('posts', function ($table) {
//     $table->id();
//     $table->string('title');
//     $table->string('content');
//     $table->string('author');
//     $table->string('slug')->unique();
//     $table->timestamps();
// });

// $table = Capsule::schema()->create('comments', function ($table) {
//     $table->id();
//     $table->unsignedBigInteger('post_id');
//     $table->string('content');
//     $table->string('author');
//     $table->timestamps();

//     $table->foreign('post_id')->references('id')->on('posts');
// });

/* END Create table with blueprint */

/*  */

/* Eloquent */

$request = Request::createFromGlobals();
$routes = include __DIR__.'/src/app.php';

$container = include __DIR__.'/src/container.php';
$container->register('listener.string_response', StringResponseListener::class);
$container->getDefinition('dispatcher')
    ->addMethodCall('addSubscriber', [new Reference('listener.string_response')])
;
$response = $container->get('framework')->handle($request);
$response->send();