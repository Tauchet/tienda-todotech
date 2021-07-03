<?php

namespace Controllers;

class InicioController {

    public static function mostrar() {
        render("inicio", [ 'nombre' => 'Antonio' ]);
    }

}