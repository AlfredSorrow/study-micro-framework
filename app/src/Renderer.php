<?php

namespace App\Renderer;

function render($filepath, $params = [])
{
    $templatepath = dirname(__DIR__) . '/resources/view/' . $filepath . '.phtml';
    return \App\Template\render($templatepath, $params);
}
