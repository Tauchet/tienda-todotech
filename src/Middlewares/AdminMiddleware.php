<?php

namespace Middlewares;

class AdminMiddleware {

    public static function validar() {

        if (!isset($_REQUEST['user'])) {
            redireccionar("login");
            return;
        }

        $usuario = $_REQUEST['user'];
        if (!($usuario['administrador'] === "1" || $usuario['administrador'] == 1)) {
            redireccionar();
        }

    }

}