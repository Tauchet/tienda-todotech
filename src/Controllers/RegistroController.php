<?php

namespace Controllers;

class RegistroController {

    public static function mostrar() {
        renderizar("registro", [ ]);
    }

    public static function ejecutar() {

        $error = false;
        $resultado = [];

        if (estaVacio($_POST["nombre"])) {
            $resultado['error_nombre'] = true;
            $error = true;
        }

        if (estaVacio($_POST["correo"])) {
            $resultado['error_correo'] = true;
            $error = true;
        }

        if (estaVacio($_POST["contrasenia"])) {
            $resultado['error_contrasenia'] = true;
            $error = true;
        }

        if (estaVacio($_POST["confirmar_contrasenia"])) {
            $resultado['error_contrasenia_confirmacion'] = true;
            $error = true;
        }

        if (estaVacio($_POST["direccion"])) {
            $resultado['error_direccion'] = true;
            $error = true;
        }

        if ($error) {

            $resultado['error'] = "¡Ha ocurrido un error con los datos ingresados!";
            renderizar("registro", $resultado);
            return;
        }

        if ($_POST["contrasenia"] != $_POST["confirmar_contrasenia"]) {
            $resultado['error'] = "¡Las contraseñas no coinciden!";
            $resultado['error_contrasenia_confirmacion'] = true;
            $resultado['error_contrasenia'] = true;
            renderizar("registro", $resultado);
            return;
        }

        $usuarioId = registrarUsuario($_POST["nombre"], $_POST["correo"], $_POST["contrasenia"], $_POST["direccion"]);
        if ($usuarioId != NULL) {
            session_start();
            $_SESSION['usuario_id'] = $usuarioId;
            redireccionar('/');
            return;
        }

        $resultado['error'] = "¡El correo ya se encuentra usado!";
        $resultado['error_correo'] = true;
        renderizar("registro", $resultado);

    }

}