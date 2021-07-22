<?php

namespace Controllers;

class LoginController {

    public static function mostrar() {
        renderizar("login", [ ]);
    }

    public static function ejecutar() {

        $error = false;
        $resultado = [];

        if (estaVacio($_POST["correo"])) {
            $resultado['error_correo'] = true;
            $error = true;
        }

        if (estaVacio($_POST["contrasenia"])) {
            $resultado['error_contrasenia'] = true;
            $error = true;
        }

        $usuarioId = buscarUsuario($_POST["correo"], $_POST["contrasenia"]);
        if ($usuarioId !== NULL) {
            session_start();
            $_SESSION['usuario_id'] = $usuarioId;
            redireccionar();
            return;
        }

        $resultado['error'] = "¡Verifica tu contraseña o correo! No existe este registro.";
        $resultado['error_correo'] = true;
        renderizar("login", $resultado);

    }

}