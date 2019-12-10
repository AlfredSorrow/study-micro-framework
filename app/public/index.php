<?php
require_once dirname(__DIR__, 2)  . '/vendor/autoload.php';

use App\Application;
use function App\Renderer\render;
use function App\response;

$app = new Application();

$app->get('/', function () {
    return response(render('index'));
});


$app->get('/about/:name/hello/:hello', function ($attributes) {
    return response(render('about', $attributes));
});

$app->get('/private', function () {
    return 'Private page';
});


$app->run();
