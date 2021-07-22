<?php

namespace Controllers\Admin;

class ProductoEditorController {

    public static function mostrar() {
        renderizar("admin/producto-editor");
    }

    public static function editar($productoId) {
        $producto = buscarProducto($productoId);
        renderizar("admin/producto-editor", [
            'nombre' => $producto['nombre'],
            'descripcion' => $producto['descripcion'],
            'categoria' => $producto['categoria'],
            'precio' => $producto['precio'],
            'stock' => $producto['stock'],
            'producto_actual_codigo' => $productoId
        ]);
    }

    public static function ejecutarEditar($productoId) {

        $error = false;
        $resultado = [];

        if (estaVacio($_POST["nombre"])) {
            $resultado['error_nombre'] = true;
            $error = true;
        }

        if (estaVacio($_POST["descripcion"])) {
            $resultado['error_descripcion'] = true;
            $error = true;
        }

        if (estaVacio($_POST["categoria"])) {
            $resultado['error_categoria'] = true;
            $error = true;
        }

        if (estaVacio($_POST["precio"])) {
            $resultado['error_precio'] = true;
            $error = true;
        }

        if (estaVacio($_POST["stock"])) {
            $resultado['error_stock'] = true;
            $error = true;
        }

        $resultado['producto_actual_codigo'] = '1';
        $resultado['nombre'] = $_POST["nombre"];
        $resultado['descripcion'] = $_POST["descripcion"];
        $resultado['categoria'] = $_POST["categoria"];
        $resultado['precio'] =  $_POST["precio"];
        $resultado['stock'] = $_POST["stock"];

        if ($error) {
            $resultado['error'] = "¡Ha ocurrido un error con los datos ingresados!";
            renderizar("admin/producto-editor", $resultado);
            return;
        }

        $actualizado = actualizarProducto($productoId, $_POST["nombre"], $_POST["descripcion"], $_POST["categoria"], $_POST["precio"], $_POST["stock"]);
        if ($actualizado) {
            $resultado['completado'] = true;
            $resultado['alerta'] = "Se han guardado correctamente los cambios.";
            renderizar("admin/producto-editor", $resultado);
            return;
        }

        $resultado['error'] = "¡No se ha encontrado el producto buscado!";
        renderizar("admin/producto-editor", $resultado);

    }

    public static function ejecutar() {

        $error = false;
        $resultado = [];

        if (estaVacio($_POST["nombre"])) {
            $resultado['error_nombre'] = true;
            $error = true;
        }

        if (estaVacio($_POST["descripcion"])) {
            $resultado['error_descripcion'] = true;
            $error = true;
        }

        if (estaVacio($_POST["categoria"])) {
            $resultado['error_categoria'] = true;
            $error = true;
        }

        if (estaVacio($_POST["precio"])) {
            $resultado['error_precio'] = true;
            $error = true;
        }

        if (estaVacio($_POST["stock"])) {
            $resultado['error_stock'] = true;
            $error = true;
        }

        $resultado['nombre'] = $_POST["nombre"];
        $resultado['descripcion'] = $_POST["descripcion"];
        $resultado['categoria'] = $_POST["categoria"];
        $resultado['precio'] =  $_POST["precio"];
        $resultado['stock'] = $_POST["stock"];

        if ($error) {
            $resultado['error'] = "¡Ha ocurrido un error con los datos ingresados!";
            renderizar("admin/producto-editor", $resultado);
            return;
        }

        $productoCodigo = registrarProducto($_POST["nombre"], $_POST["descripcion"], $_POST["categoria"], $_POST["precio"], $_POST["stock"]);
        if ($productoCodigo != NULL) {
            renderizar("admin/producto-editor", [
                'completado' => true,
                'producto_codigo' => $productoCodigo
            ]);
            return;
        }

        $resultado['error'] = "¡Ha ocurrido un error inesperado! Vuelve a intentarlo más tarde.";
        renderizar("admin/producto-editor", $resultado);

    }

}