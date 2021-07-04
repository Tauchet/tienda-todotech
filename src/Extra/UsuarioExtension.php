<?php

namespace Extra;

use Symfony\Component\Mime\MimeTypes;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class UsuarioExtension extends AbstractExtension {

    public function getFunctions(): array {
        return [
            new TwigFunction('usuario', 'obtenerUsuario'),
        ];
    }

    public function obtenerUsuario(): array {
        if (isset($_REQUEST['user'])) {
            return $_REQUEST['user'];
        }
        return NAN;
    }

}