<?php

use App\Core\Router;

$routes = require "../resources/routes.php";

$request = empty($_GET) ? "home" : $_GET['url'];

return new Router($request, $routes);
