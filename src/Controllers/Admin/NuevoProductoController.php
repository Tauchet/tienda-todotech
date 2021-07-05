<?php

namespace Controllers\Admin;

class NuevoProductoController {

    public static function mostrar() {
        renderizar("admin/producto-editor");
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

        if (estaVacio($_POST["precio"])) {
            $resultado['error_precio'] = true;
            $error = true;
        }

        if ($error) {
            $resultado['error'] = "¡Ha ocurrido un error con los datos ingresados!";
            renderizar("admin/producto-editor", $resultado);
            return;
        }

        $productoCodigo = registrarProducto($_POST["nombre"], $_POST["descripcion"], $_POST["precio"]);
        if ($productoCodigo != NULL) {
            renderizar("admin/producto-editor", ['completado' => true, 'producto_codigo' => $productoCodigo]);
            return;
        }

        $resultado['error'] = "¡Ha ocurrido un error inesperado! Vuelve a intentarlo más tarde.";
        renderizar("admin/producto-editor", $resultado);

    }

}