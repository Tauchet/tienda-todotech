<?php

namespace Controllers;

class InicioController {

    public static function mostrar() {

        $resultado = [];
        $busqueda = $_REQUEST['busqueda'] ?? null;
        $categoria = $_GET['categoria'] ?? "Todas";

        if ($busqueda !== null) {
            $resultado['busqueda'] = $_REQUEST['busqueda'];
        }

        $resultado['categoria_actual'] = $categoria;
        $resultado['categorias'] = buscarCategorias();
        $resultado['productos'] = buscarProductos($busqueda, $categoria);

        renderizar("inicio", $resultado);

    }


}