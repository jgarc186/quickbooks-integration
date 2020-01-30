<?php

namespace App\Core;

class Router
{
    protected $url;
    protected $link;

    public function __construct(string $request, array $routes)
    {
        $this->url = $request;
        $this->link = array_filter($routes, function($route) {
            return $route == $this->url;
            }, ARRAY_FILTER_USE_KEY);
    }

    public function run()
    {
        header("location:{$this->link[$this->url]}");
        die;
    }
}
