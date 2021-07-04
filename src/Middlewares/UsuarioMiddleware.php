<?php

namespace Middlewares;

class UsuarioMiddleware {

    public static function sessionActiva() {
        session_start();
        return isset($_SESSION) && isset($_SESSION['usuario_id']);
    }

    public static function buscar() {
        if (self::sessionActiva()) {
            $_REQUEST['user'] = buscarUsuarioInfo($_SESSION['usuario_id']);
        }
    }

    public static function necesitaAutentificar() {
        if (self::sessionActiva()) {
            redireccionar("/");
        }
    }

}