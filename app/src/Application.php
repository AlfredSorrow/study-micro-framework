<?php

namespace App;

use function App\Renderer\render;

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

    protected function append($method, $route, $handler)
    {
        $updatedRoute = $route;
        if (preg_match_all('/:([^\/]+)/', $route, $matches)) {
            $updatedRoute = array_reduce($matches[1], function ($acc, $value) {
                $group = "(?P<$value>[\w-]+)";
                return str_replace(":{$value}", $group, $acc);
            }, $route);
        }

        $this->handlers[$method][$updatedRoute] = $handler;
    }

    public function run()
    {
        $uri = $this->prepareUri($_SERVER['REQUEST_URI']);
        $method = $_SERVER['REQUEST_METHOD'];
        [$handler, $attributes] = $this->getRouteData($method, $uri);
        $meta = [
            'method' => $method,
            'uri' => $uri,
            'headers' => getallheaders()
        ];
        if (!empty($handler)) {
            $response = $handler($meta, array_merge($_GET, $_POST), $attributes);
            http_response_code($response->getStatusCode());
            foreach ($response->getHeaderLines() as $header) {
                header($header);
            }
            echo $response->getBody();
            return;
        }
        
        $response = response(render('404'))->withStatus(404);
        echo $response->getBody();
        return;
    }
    
    protected function getRouteData($method, $uri)
    {
        foreach ($this->handlers[$method] as $route => $handler) {
            $preparedRoute = str_replace('/', '\/', $route);
            $matches = [];
            if (preg_match("/^$preparedRoute$/i", $uri, $matches)) {
                $attributes = array_filter($matches, function ($key) {
                    return !is_numeric($key);
                }, ARRAY_FILTER_USE_KEY);
                return [$handler, $attributes];
            }
        }

        return [false, false];
    }

    protected function prepareUri(string $uri): string
    {
        return strtolower(parse_url($uri, PHP_URL_PATH));
    }
}
