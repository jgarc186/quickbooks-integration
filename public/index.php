<?php

require  "../vendor/autoload.php";

use App\Core\Router;

$routes = require "./routes.php";

$request = empty($_GET) ? "home" : $_GET['url'];

$app = new Router($request, $routes);

$app->run();
