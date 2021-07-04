<?php

require_once './autoload.php';
require_once '../vendor/autoload.php';

use Extra\UsuarioExtension;
use Twig\Environment;
use Twig\Extra\Html\HtmlExtension;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader('../src/vistas');
$twig = new Environment($loader);
$twig->addExtension(new HtmlExtension());
$twig->addExtension(new UsuarioExtension());

require_once "../src/lib.php";
require_once "../src/database.php";
require_once "../src/routes.php";