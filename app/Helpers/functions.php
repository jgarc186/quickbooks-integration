<?php

use Dotenv\Dotenv;

if (!function_exists('dd')) {
    function dd($variable)
    {
        var_dump($variable);
        die;
    }
}

if (!function_exists('env')) {
    function env($key)
    {
        (Dotenv::createImmutable("../"))->load();

        return $_ENV[$key];
    }
}