<?php

namespace Controllers;

class LogoutController {

    public static function ejecutar() {
        session_destroy();
        redireccionar("/");
    }

}