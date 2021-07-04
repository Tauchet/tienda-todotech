<?php

use Bramus\Router\Router;

$router = new Router();
$router->setBasePath("");

$router->before("GET|POST", "/login", "\\Middlewares\\UsuarioMiddleware@necesitaAutentificar");
$router->get("/login", "\\Controllers\\LoginController@mostrar");
$router->post("/login", "\\Controllers\\LoginController@ejecutar");

$router->before("GET|POST", "/registro", "\\Middlewares\\UsuarioMiddleware@necesitaAutentificar");
$router->get("/registro", "\\Controllers\\RegistroController@mostrar");
$router->post("/registro", "\\Controllers\\RegistroController@ejecutar");

$router->before("GET|POST", "*", "\\Middlewares\\UsuarioMiddleware@buscar");
$router->get("/", "\\Controllers\\InicioController@mostrar");

$router->run();