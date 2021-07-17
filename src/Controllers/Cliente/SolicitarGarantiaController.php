<?php

namespace Controllers\Cliente;

class SolicitarGarantiaController {

    public static function mostrar() {
        renderizar("cliente/producto-garantia");
    }

    public static function ejecutar() {

        $error = false;
        $resultado = [];

        if (estaVacio($_POST["codigo"])) {
            $resultado['error_codigo'] = true;
            $error = true;
        }

        if (estaVacio($_POST["problema"])) {
            $resultado['error_problema'] = true;
            $error = true;
        }

        if (estaVacio($_POST["descripcion"])) {
            $resultado['error_descripcion'] = true;
            $error = true;
        }

        if ($error) {
            $resultado['error'] = "¡Ha ocurrido un error con los datos ingresados!";
            renderizar("cliente/producto-garantia", $resultado);
            return;
        }

        $garantiaId = registrarGarantia($_POST["codigo"], $_POST["problema"], $_POST["descripcion"]);
        if ($garantiaId != NULL) {
            renderizar("cliente/producto-garantia", ['completado' => true, 'garantia_id' => $garantiaId]);
            return;
        }

        $resultado['error'] = "¡Ha ocurrido un error inesperado! Vuelve a intentarlo más tarde.";
        renderizar("cliente/producto-garantia", $resultado);

    }

}