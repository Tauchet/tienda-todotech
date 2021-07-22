<?php

namespace Controllers;

class VentaController
{

    public static function buscar($ventaProductoId)
    {
        $ventaProducto = buscarProductoVenta($ventaProductoId);
        renderizar("venta", ['ventas_producto' => $ventaProducto]);
    }
}
