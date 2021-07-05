<?php

function endsWith( $haystack, $needle ) {
    $length = strlen( $needle );
    if( !$length ) {
        return true;
    }
    return substr( $haystack, -$length ) === $needle;
}

function renderizar($template, $params = []) {
    if (!endsWith($template, '.twig')) {
        $template .= '.twig';
    }
    echo $GLOBALS["twig"]->render($template, $params);
}

function redireccionar($path) {
    header('Location: ' .$path, true);
    exit();
}

function estaAutentificado() {
    return isset($_REQUEST['user']);
}

function obtenerUsuario() {
    if (isset($_REQUEST['user'])) {
        return $_REQUEST['user'];
    } else {
        return null;
    }
}

function estaVacio($value) {

    if (!isset($value)) {
        return true;
    }

    return empty($value);

}