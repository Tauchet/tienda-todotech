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

    public static function esInvitado() {
        if (self::sessionActiva()) {
            redireccionar();
        }
    }

    public static function esUsuario() {
        if (!self::sessionActiva()) {
            redireccionar("login");
        }
    }

}