<?php

namespace framework;

class Router
{
    private $routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
    ];

    public function __construct(array $routes)
    {
        foreach ($routes as $route) {
            $this->routes[$route[0]][] = [$route[1], $route[2], $route[3]];
        }
    }

    public function routeTo()
    {
        if (!array_key_exists($_SERVER['REQUEST_METHOD'], $this->routes)) {
            // route not found
            return [];
        }

        $routes = $this->routes[$_SERVER['REQUEST_METHOD']];

        // else assert where to route the request
        reset($routes);
        $found_route = false;

        // and start on the requested method
        do {
            $cur = current($routes);
            $aux_uri = str_replace('/', '\/', $cur[0]);
            $aux_uri = '/^' . $aux_uri . '$/i';

            if (preg_match($aux_uri, $_SERVER['REQUEST_URI']) === 1) {
                $found_route = true;
                end($routes);
            }
        } while (next($routes));

        return $found_route ? $cur : [];
    }
}