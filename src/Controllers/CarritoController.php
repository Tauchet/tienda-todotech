<?php

namespace Controllers;

class CarritoController {

    public static function buscarCarrito(): array
    {
        $resultado = array();
        $valor = 0;
        if (isset($_SESSION['carrito'])) {
            $productoIds = array_keys($_SESSION['carrito']);
            $productos = buscarListaProductos($productoIds);
            if (count($productos) > 0) {
                foreach ($productoIds as $productoId) {
                    if (isset($productos[$productoId])) {
                        $valor += $productos[$productoId]['precio'] * $_SESSION['carrito'][$productoId];
                        $resultado[$productoId] = [
                            'cantidad' => $_SESSION['carrito'][$productoId],
                            'producto' => $productos[$productoId]
                        ];
                    }
                }
            }
        }
        return ['valor' => $valor, 'arreglo' => $resultado];
    }

    public static function formulario() {

        $resultado = [];
        $uid = $_SESSION['usuario_id'];
        $productos = self::buscarCarrito()['arreglo'];
        $ventaId = registrarVenta($uid, buscarDireccion($uid), $productos);

        if ($ventaId === -1 || count($productos) == 0) {
            $resultado['no_encontrados'] = $ventaId;
            renderizar("carrito", $resultado);
        } else if ($ventaId !== null) {
            $_SESSION['carrito'] = array();
            $resultado['completado'] = $ventaId;
            renderizar("carrito", $resultado);
        } else {
            $resultado['error'] = true;
            renderizar("carrito", $resultado);
        }

    }

    public static function mostrar() {
        $resultado = [];
        $peticion = self::buscarCarrito();
        $productos = $peticion['arreglo'];
        if (count($productos) > 0) {
            $resultado['carrito'] = $productos;
            $resultado['carrito_precio'] = $peticion['valor'];
        } else {
            $resultado['vacio'] = true;
        }
        renderizar("carrito", $resultado);
    }

    public static function cantidad() {

        header('Content-Type: application/json');

        if (!isset($_POST)) {
            $jsonArray = array();
            header('HTTP/1.1 404 Not Found');
            $jsonArray['status'] = "404";
            $jsonArray['status_text'] = "route not defined";
            echo json_encode($jsonArray);
            return;
        }

        $productoId = $_POST['producto'];
        $cantidad = intval($_POST['cantidad']);
        $stock = intval($_POST['stock']);

        if (!isset($productoId)) {
            $jsonArray = array();
            header('HTTP/1.1 404 Not Found');
            $jsonArray['status'] = "404";
            $jsonArray['status_text'] = "route not defined";
            echo json_encode($jsonArray);
            return;
        }

        if (!isset($cantidad)) {
            $jsonArray = array();
            header('HTTP/1.1 404 Not Found');
            $jsonArray['status'] = "404";
            $jsonArray['status_text'] = "route not defined";
            echo json_encode($jsonArray);
            return;
        }

        if(!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = array();
        }

        $carrito = $_SESSION['carrito'];

        $actual = 0;
        if (isset($carrito[$productoId])) {
            $actual = $carrito[$productoId];
        }

        $actual = max(0, min($stock, $actual + $cantidad));
        if ($actual <= 0) {
            unset($carrito[$productoId]);
        } else {
            $carrito[$productoId] = $actual;
        }
        $_SESSION['carrito'] = $carrito;

        $jsonArray = array();
        $jsonArray['cantidad'] = $actual;
        echo json_encode($jsonArray);

    }

}