<?php

require_once './autoload.php';
require_once '../vendor/autoload.php';

use Twig\Environment;
use Twig\Extra\Html\HtmlExtension;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

$loader = new FilesystemLoader('../src/vistas');
$twig = new Environment($loader);
$twig->addExtension(new HtmlExtension());

$twig->addFunction(new TwigFunction("url", function(...$path) {
    $url = $_ENV['BASE_URL'];
    foreach ($path as $arg) {
        $url .= $arg;
    }
    return $url;
}));

$twig->addFunction(new TwigFunction("usuario", function() {
    if (isset($_REQUEST['user'])) {
        return $_REQUEST['user'];
    }
    return null;
}));

$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();

require_once "../src/lib.php";
require_once "../src/database.php";
require_once "../src/routes.php";