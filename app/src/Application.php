<?php

namespace App;

class Application
{
    private $handlers = [];

    public function get($route, $handler)
    {
        $this->append('GET', $route, $handler);
    }

    public function post($route, $handler)
    {
        $this->append('POST', $route, $handler);
    }

    private function append($method, $route, $handler)
    {
        $this->handlers[$method][$route] = $handler;
    }

    public function run()
    {
        $uri = $this->prepareUri($_SERVER['REQUEST_URI']);
        $method = $_SERVER['REQUEST_METHOD'];
        if ($this->hasHandler($method, $uri)) {
            echo $this->handlers[$method][$uri]();
            return;
        }

        echo 'Page not found';
        return;
    }

    protected function hasHandler($method, $uri): bool
    {
        return isset($this->handlers[$method][$uri]);
    }

    protected function prepareUri(string $uri): string
    {
        $parsedUri = strtolower(parse_url($uri, PHP_URL_PATH));
        $length = strlen($parsedUri);
        $lastSymbolPosition = $length - 1;
        
        if ($parsedUri[$lastSymbolPosition] === '/' && $length > 1) {
            return substr_replace($parsedUri, '', $lastSymbolPosition, 1);
        }

        return $parsedUri;
    }
}
