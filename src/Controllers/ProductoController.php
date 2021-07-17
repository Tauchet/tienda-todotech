<?php

namespace Controllers;

class ProductoController {

    public static function mostrar($productoId) {
        $producto = buscarProducto($productoId);
        renderizar("producto", ['producto' => $producto]);
    }

}