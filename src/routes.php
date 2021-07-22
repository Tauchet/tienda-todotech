<?php

use Bramus\Router\Router;

$router = new Router();
$router->setBasePath($_ENV['BASE_URL']);

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

$router->get("/admin/nuevo-producto", "\\Controllers\\Admin\\ProductoEditorController@mostrar");
$router->post("/admin/nuevo-producto", "\\Controllers\\Admin\\ProductoEditorController@ejecutar");
$router->get("/admin/editar-producto/{productoId}", "\\Controllers\\Admin\\ProductoEditorController@editar");
$router->post("/admin/editar-producto/{productoId}", "\\Controllers\\Admin\\ProductoEditorController@ejecutarEditar");

$router->get("/admin/gestion-ventas", "\\Controllers\\VentasController@adminMostrar");
$router->get("/admin/gestion-ventas/{ventaId}", "\\Controllers\\VentasController@adminMostrar");

$router->get("/venta/{id}", "\\Controllers\\VentaController@buscar");

$router->get("/cliente/mis-compras", "\\Controllers\\VentasController@clientMostrar");
$router->get("/cliente/mis-compras/{ventaId}", "\\Controllers\\VentasController@clientMostrar");

$router->get("/cliente/garantia-venta/{ventaId}", "\\Controllers\\Cliente\\SolicitarGarantiaController@mostrar");
$router->post("/cliente/garantia-venta/{ventaId}", "\\Controllers\\Cliente\\SolicitarGarantiaController@ejecutar");

$router->before("GET|POST", ".*", "\\Middlewares\\UsuarioMiddleware@buscar");
$router->before("GET|POST", "/admin.*", "\\Middlewares\\AdminMiddleware@validar");

$router->get("/producto/{id}", "\\Controllers\\ProductoController@mostrar");
$router->post("/producto/{id}", "\\Controllers\\ProductoController@resenia");

$router->run();