<?php

use Bramus\Router\Router;

$router = new Router();
$router->setBasePath("/tienda-todotech/");

$router->get("/carrito", "\\Controllers\\CarritoController@mostrar");
$router->post("/carrito", "\\Controllers\\CarritoController@formulario");
$router->post("/carrito-cantidad", "\\Controllers\\CarritoController@cantidad");
$router->before("GET|POST", "/carrito", "\\Middlewares\\UsuarioMiddleware@esUsuario");

$router->get("/login", "\\Controllers\\LoginController@mostrar");
$router->post("/login", "\\Controllers\\LoginController@ejecutar");

$router->get("/registro", "\\Controllers\\RegistroController@mostrar");
$router->post("/registro", "\\Controllers\\RegistroController@ejecutar");

$router->get("/logout", "\\Controllers\\LogoutController@ejecutar");

$router->before("GET|POST", "/login", "\\Middlewares\\UsuarioMiddleware@esInvitado");
$router->before("GET|POST", "/registro", "\\Middlewares\\UsuarioMiddleware@esInvitado");

$router->get("/", "\\Controllers\\InicioController@mostrar");
$router->get("/2", "\\Controllers\\InicioController@mostrar2");

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