<?php

use Bramus\Router\Router;

$router = new Router();

$router->before('GET', '*', 'Middlewares\UsuarioMiddleware@buscar');
$router->get('*', 'Controllers\InicioController@mostrar');

$router->run();