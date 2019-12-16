<?php
require_once dirname(__DIR__, 2)  . '/vendor/autoload.php';

use App\Application;
use function App\Renderer\render;
use function App\response;

$app = new Application();

$app->get('/', function () {
    return response(render('index'));
});

$app->get('/hello/:name', function ($meta, $parameters, $attributes) {
    return response(render('hello', $attributes));
});

$app->run();
