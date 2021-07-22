<?php

namespace Controllers\Admin;

class GestionVentaController {

    public static function mostrar() {
        $ventas = buscarVentas();
        renderizar("admin/gestion-venta", ['ventas'=>$ventas]);
    }

}