<?php
require_once dirname(__DIR__, 2)  . '/vendor/autoload.php';

use App\Application;
use function App\Renderer\render;

$app = new Application();


$app->get('/', function () {
    return 'Main pagdew';
});

$app->get('/about/:name/hello/:asd', function ($attributes) {
    return '';
});

$app->get('/private', function () {
    return 'Private page';
});


$app->run();
