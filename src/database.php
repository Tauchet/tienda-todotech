<?php


function conectar() {
    $servidor = $_ENV['MYSQL_SERVIDOR'];
    $usuario = $_ENV['MYSQL_USUARIO'];
    $contrasenia = $_ENV['MYSQL_CONTRASENIA'];
    $db = $_ENV['MYSQL_DATABASE'];
    return mysqli_connect($servidor, $usuario, $contrasenia, $db);
}

function buscarUsuario($correo, $contrasenia) {
    $conexion = conectar();

    $comando = "SELECT id FROM usuarios WHERE correo='$correo' AND (contrasenia='$contrasenia' OR contrasenia='".md5($contrasenia)."')";
    $resultado = mysqli_query($conexion, $comando);

    if (mysqli_num_rows($resultado) > 0) {
        return mysqli_fetch_assoc($resultado)['id'];
    } else {
        // No se pudo encontrar el usuario.
        return null;
    }

}

function buscarUsuarioInfo($uid) {
    $conexion = conectar();
    $comando = "SELECT nombre, correo, administrador FROM usuarios WHERE id='$uid'";
    $resultado = mysqli_query($conexion, $comando);
    if (mysqli_num_rows($resultado) > 0) {
        $usuario = convertirArray($resultado);
        $usuario['direccion'] = buscarDireccion($uid);
        return $usuario;
    } else {
        // No se pudo encontrar el usuario.
        return null;
    }
}

function convertirArray($consulta) {
    return json_decode(json_encode(mysqli_fetch_array($consulta)), true);
}


function registrarUsuario($nombre, $correo, $contrasenia, $direccion) {
    $conexion = conectar();
    $contrasenia = md5($contrasenia);
    $comando = "INSERT INTO usuarios(nombre, correo, contrasenia) VALUES ('$nombre', '$correo', '$contrasenia');";
    $resultado = mysqli_query($conexion, $comando);
    if ($resultado) {
        $usuarioId = mysqli_insert_id($conexion);
        if (registrarDireccion($usuarioId, 'Hogar', $direccion)) {
            return $usuarioId;
        }
    }
    return null;
}

function buscarDireccion($uid) {
    $conexion = conectar();
    $resultado = mysqli_query($conexion, "SELECT direccion FROM direcciones WHERE usuario_id='$uid'");
    if (mysqli_num_rows($resultado) > 0) {
        return convertirArray($resultado)['direccion'];
    }
    return null;
}

function registrarDireccion($uid, $nombre, $direccion) {
    $conexion = conectar();
    $comando = "INSERT INTO direcciones(usuario_id, nombre, direccion) VALUES ($uid, '$nombre', '$direccion');";
    return mysqli_query($conexion, $comando);
}


function buscarCategorias() {

    $conexion = conectar();

    $comando = "SELECT distinct categoria FROM `productos`";

    $resultado = array();
    array_push($resultado, "Todas");

    $peticion =  mysqli_query($conexion, $comando);
    if (mysqli_num_rows($peticion) > 0) {
        while($producto = mysqli_fetch_assoc($peticion)) {
            array_push($resultado, $producto['categoria']);
        }
    }

    return $resultado;

}


function buscarProductos($busqueda = null, $categoria = "Todas"): array {

    $conexion = conectar();

    $comando = "SELECT * FROM productos";
    $concatenado = false;

    if ($busqueda !== null) {
        if(!$concatenado){
            $concatenado=true;
            $comando .= " WHERE";
        }
        $comando .= " `nombre` LIKE '%".$busqueda."%'";

    }
    if ($categoria !== null && $categoria!="Todas") {
        if(!$concatenado){
            $concatenado=true;
            $comando .= " WHERE";
        }
        else{
            $comando .= " AND";
        }
        $comando .= " `categoria` = '".$categoria."'";

    }


    $resultado = array();

    $peticion =  mysqli_query($conexion, $comando);
    if (mysqli_num_rows($peticion) > 0) {
        while($producto = mysqli_fetch_assoc($peticion)) {
            array_push($resultado, $producto);
        }
    }

    return $resultado;

}


function buscarProducto($id) {

    $conexion = conectar();
    $comando = "SELECT * FROM productos WHERE `id`=$id";
    $peticion =  mysqli_query($conexion, $comando);
    if (mysqli_num_rows($peticion) > 0) {
        return mysqli_fetch_assoc($peticion);
    }

    return null;

}



function buscarListaProductos($ids): array
{
    $resultado = array();
    foreach ($ids as $productoId) {

        if (is_int($productoId)) {
            $producto = buscarProducto($productoId);
            if ($producto !== null) {
                $resultado[$productoId] = $producto;
            }
        }
    }
    return $resultado;
}

function registrarProducto($nombre, $imagen, $descripcion, $categoria,$precio, $stock) {
    $precio = intval($precio);
    $stock = intval($stock);
    $conexion = conectar();
    $comando = "INSERT INTO productos(nombre, imagen, descripcion, categoria, precio, stock) VALUES ('$nombre', '$imagen', '$descripcion', '$categoria', $precio, $stock);";
    $resultado = mysqli_query($conexion, $comando);
    if ($resultado) {
        return mysqli_insert_id($conexion);
    }
    return null;
}

function registrarVenta($uid, $direccion, $productos) {
    $conexion = conectar();
    $precioTotal = 0;
    foreach ($productos as $producto) {
        $precioTotal += $producto['cantidad'] * $producto['producto']['precio'];
    }
    $comando = "INSERT INTO ventas(usuario_id, direccion, precio_total) VALUES ($uid, '$direccion', $precioTotal);";
    $resultado = mysqli_query($conexion, $comando);
    if ($resultado) {
        $ventaId = mysqli_insert_id($conexion);
        $productosComprados = 0;
        foreach ($productos as $producto) {
            $productoId = $producto['producto']['id'];
            $cantidad = $producto['cantidad'];
            $productoPrecio = $cantidad * $producto['producto']['precio'];
            if (mysqli_query($conexion, "UPDATE `productos` SET `stock`=(IF(`stock`-$cantidad<0, 0, `stock`-$cantidad)) WHERE id=$productoId AND `stock`>=$cantidad;")) {
                mysqli_query($conexion, "INSERT INTO ventas_producto(usuario_id, venta_id, producto_id, cantidad, precio_total) VALUES ($uid, $ventaId, $productoId, $cantidad, $productoPrecio);");
                $productosComprados++;
            }
        }
        if ($productosComprados == 0) {
            return -1;
        }
        return $ventaId;
    }
    return null;
    return null;
}

function actualizarProducto($productoId, $nombre, $imagen, $descripcion, $categoria, $precio, $stock) {
    $precio = intval($precio);
    $stock = intval($stock);
    $conexion = conectar();
    $comando = "UPDATE productos SET nombre='$nombre', imagen='$imagen', descripcion='$descripcion', categoria='$categoria', precio=$precio, stock=$stock WHERE `id`=$productoId";
    $resultado = mysqli_query($conexion, $comando);
    if ($resultado) {
        return true;
    }
    return false;
}

function registrarGarantia($ventaId, $problema, $descripcion) {
    $conexion = conectar();

    $comando = "UPDATE ventas SET garantia_problema='$problema', garantia_descripcion='$descripcion' WHERE `id`=$ventaId";
    $resultado = mysqli_query($conexion, $comando);
    if ($resultado) {
        return true;
    }
    return false;
}

function buscarVentas($uid = null): array
{

    $conexion = conectar();
    $comando = "SELECT venta.*, usuario.nombre AS usuario_nombre, usuario.correo AS usuario_correo FROM `ventas` AS venta INNER JOIN `usuarios` AS usuario ON venta.usuario_id = usuario.id";

    if ($uid !== null) {
        $comando .= " WHERE `usuario_id`=$uid";
    }

    $resultado = array();
    $peticion =  mysqli_query($conexion, $comando);
    if (mysqli_num_rows($peticion) > 0) {
        while($venta = mysqli_fetch_assoc($peticion)) {
            array_push($resultado, $venta);
        }
    }

    return $resultado;
}

function buscarVenta($id): array
{

    $conexion = conectar();

    $comando = "SELECT venta.*, usuario.nombre AS usuario_nombre, usuario.correo AS usuario_correo FROM `ventas` AS venta INNER JOIN `usuarios` AS usuario ON venta.usuario_id = usuario.id WHERE venta.id=$id";
    $resultado = [];
    $peticion = mysqli_query($conexion, $comando);
    if (mysqli_num_rows($peticion) > 0) {
        $resultado['info'] = mysqli_fetch_assoc($peticion);

        $comando = "SELECT lista_productos.cantidad, lista_productos.precio_total, productos.* FROM `ventas_producto` AS lista_productos INNER JOIN productos ON productos.id = lista_productos.producto_id WHERE lista_productos.venta_id=$id";
        $peticion = mysqli_query($conexion, $comando);
        $productos = [];
        if (mysqli_num_rows($peticion) > 0) {
            while($venta = mysqli_fetch_assoc($peticion)) {
                array_push($productos, $venta);
            }
        }
        $resultado['productos'] = $productos;

    }

    return $resultado;
}

function esProductoComprado($productoId, $uid): bool {
    $conexion = conectar();
    $comando = "SELECT * FROM ventas_producto WHERE `producto_id`=$productoId AND `usuario_id`=$uid";
    $peticion =  mysqli_query($conexion, $comando);
    return mysqli_num_rows($peticion) > 0;
}

function buscarResenias($productoId, $uid): array {
    $conexion = conectar();
    $comando = "SELECT resenia.*, usuarios.nombre AS usuario_nombre FROM resenias AS resenia INNER JOIN usuarios ON usuarios.id=resenia.usuario_id WHERE resenia.producto_id=$productoId ORDER BY resenia.fecha ASC";
    $resultado = array();
    $encontrado = false;
    $peticion = mysqli_query($conexion, $comando);
    if (mysqli_num_rows($peticion) > 0) {
        while($venta = mysqli_fetch_assoc($peticion)) {
            array_push($resultado, $venta);
            if ($venta['usuario_id'] === $uid) {
                $encontrado = true;
            }
        }
    }
    return [$resultado, $encontrado];
}

function registrarResenia($productoId, $uid, $resenia): bool {
    $conexion = conectar();
    $comando = "INSERT INTO resenias(producto_id, usuario_id, resenia) VALUE ('$productoId', '$uid', '$resenia');";
    $resultado = mysqli_query($conexion, $comando);
    if($resultado){
        return true;
    }
    return false;

}