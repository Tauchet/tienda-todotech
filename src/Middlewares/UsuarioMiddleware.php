<?php

namespace Middlewares;

class UsuarioMiddleware {

    public static function sessionActiva() {
        if(!isset($_SESSION)) {
            session_start();
        }
        return isset($_SESSION) && isset($_SESSION['usuario_id']);
    }

    public static function buscar(): void {
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