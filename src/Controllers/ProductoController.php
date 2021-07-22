<?php

namespace Controllers;

class ProductoController {

    public static function mostrar($productoId, $resultado = []) {
        $resultado['producto'] = buscarProducto($productoId);
        if (isset($_SESSION) && isset($_SESSION['usuario_id'])) {
            $resultado['comprado_alguna_vez'] = esProductoComprado($productoId, $_SESSION['usuario_id']);
        }
        $resenias = buscarResenias($productoId, $_SESSION['usuario_id'] ?? null);
        $resultado['resenias'] = $resenias[0];
        $resultado['resenia_registrada'] = $resenias[1];
        renderizar("producto", $resultado);
    }

    public static function resenia($productoId) {

        $resultado = [];

        if (estaVacio($_POST["resenia"])) {
            $resultado['resenia_error'] = true;
            self::mostrar($productoId, $resultado);
            return;
        }

        if (!(isset($_SESSION) && isset($_SESSION['usuario_id']))) {
            $resultado['resenia_error'] = true;
            self::mostrar($productoId, $resultado);
            return;
        }


        if (registrarResenia($productoId, $_SESSION['usuario_id'], $_POST["resenia"])) {
            $resultado['resenia_completado'] = true;
        } else {
            $resultado['resenia_error'] = true;
        }

        self::mostrar($productoId, $resultado);

    }

}