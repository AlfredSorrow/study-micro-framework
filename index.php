<?php

use App\Application;

require_once 'app/src/Application.php';

$app = new Application();

$app->get('/', function () {
    echo 'Main page';
});

$app->get('/about', function () {
    echo 'About page';
});


$app->run();
