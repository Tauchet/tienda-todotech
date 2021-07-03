<?php

require_once './autoload.php';
require_once '../vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader('../src/templates');
$twig = new Environment($loader);

function endsWith( $haystack, $needle ) {
    $length = strlen( $needle );
    if( !$length ) {
        return true;
    }
    return substr( $haystack, -$length ) === $needle;
}

function render($template, $params) {
    if (!endsWith($template, '.twig')) {
        $template .= '.twig';
    }
    echo $GLOBALS["twig"]->render($template, $params);
}

require_once "../src/database.php";
require_once "../src/routes.php";