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

$router->get("/admin/nuevo-producto", "\\Controllers\\Admin\\ProductoEditorController@mostrar");
$router->post("/admin/nuevo-producto", "\\Controllers\\Admin\\ProductoEditorController@ejecutar");
$router->get("/admin/editar-producto/{productoId}", "\\Controllers\\Admin\\ProductoEditorController@editar");
$router->post("/admin/editar-producto/{productoId}", "\\Controllers\\Admin\\ProductoEditorController@ejecutarEditar");

$router->get("/cliente/garantia-producto", "\\Controllers\\Cliente\\SolicitarGarantiaController@mostrar");
$router->post("/cliente/garantia-producto", "\\Controllers\\Cliente\\SolicitarGarantiaController@ejecutar");

$router->before("GET|POST", ".*", "\\Middlewares\\UsuarioMiddleware@buscar");
$router->before("GET|POST", "/admin.*", "\\Middlewares\\AdminMiddleware@validar");

$router->get("/producto/{id}", "\\Controllers\\ProductoController@mostrar");

$router->run();