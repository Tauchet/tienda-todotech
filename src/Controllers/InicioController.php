<?php

namespace Controllers;

class InicioController {

    public static function mostrar() {

        $resultado = [];
        $busqueda = $_REQUEST['busqueda'] ?? null;

        if ($busqueda !== null) {
            $resultado['busqueda'] = $_REQUEST['busqueda'];
        }

        $resultado['productos'] = buscarProductos($busqueda);

        renderizar("inicio", $resultado);

    }

    public static function mostrar2() {

        $resultado = [];
        $busqueda = $_REQUEST['busqueda'] ?? null;

        if ($busqueda !== null) {
            $resultado['busqueda'] = $_REQUEST['busqueda'];
        }

        $resultado['productos'] = buscarProductosCategoria($busqueda);

        renderizar("inicio", $resultado);

    }

}