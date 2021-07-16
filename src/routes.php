<?php

use Bramus\Router\Router;

$router = new Router();
$router->setBasePath("/tienda-todotech/");


$router->get("/login", "\\Controllers\\LoginController@mostrar");
$router->post("/login", "\\Controllers\\LoginController@ejecutar");

$router->get("/registro", "\\Controllers\\RegistroController@mostrar");
$router->post("/registro", "\\Controllers\\RegistroController@ejecutar");

$router->get("/logout", "\\Controllers\\LogoutController@ejecutar");

$router->before("GET|POST", "/login", "\\Middlewares\\UsuarioMiddleware@necesitaAutentificar");
$router->before("GET|POST", "/registro", "\\Middlewares\\UsuarioMiddleware@necesitaAutentificar");

$router->get("/", "\\Controllers\\InicioController@mostrar");

$router->get("/admin/producto-nuevo", "\\Controllers\\Admin\\NuevoProductoController@mostrar");
$router->post("/admin/producto-nuevo", "\\Controllers\\Admin\\NuevoProductoController@ejecutar");

$router->before("GET|POST", ".*", "\\Middlewares\\UsuarioMiddleware@buscar");
$router->before("GET|POST", "/admin.*", "\\Middlewares\\AdminMiddleware@validar");

$router->run();