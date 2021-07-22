<?php

namespace Controllers;

class VentasController {

    public static function mostrar($ventaId = null, $general = false) {

        if ($ventaId !== null) {
            $venta = buscarVenta($ventaId);

            renderizar("ventas", [
                'general' => $general,
                'venta' => $venta,
                'titulo' => "#$ventaId Venta"
            ]);
            return;
        }

        $ventas = $general ? buscarVentas() : buscarVentas($_SESSION['usuario_id']);
        renderizar("ventas", [
            'titulo' => ($general ? "Ventas Generales" : "Mis Ventas"),
            'ventas' => $ventas,
            'general' => $general
        ]);
    }

    public static function clientMostrar($ventaId = null) {
        self::mostrar($ventaId);
    }

    public static function adminMostrar($ventaId = null) {
        self::mostrar($ventaId, true);
    }

}