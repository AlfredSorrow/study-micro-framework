<?php

namespace App\Renderer;

function render($filepath, $params = [])
{
    $templatepath = 'resources/views' . DIRECTORY_SEPARATOR . $filepath . '.phtml';
    return \App\Template\render($templatepath, $params);
}
