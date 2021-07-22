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

function registrarProducto($nombre, $descripcion, $categoria,$precio, $stock) {
    $precio = intval($precio);
    $stock = intval($stock);
    $conexion = conectar();
    $comando = "INSERT INTO productos(nombre, descripcion, categoria, precio, stock) VALUES ('$nombre', '$descripcion', '$categoria',$precio, $stock);";
    $resultado = mysqli_query($conexion, $comando);
    if ($resultado) {
        return mysqli_insert_id($conexion);
    }
    return null;
}

function registrarVenta($uid, $direccion, $productos) {
    $conexion = conectar();
    $comando = "INSERT INTO ventas(usuario_id, direccion) VALUES ($uid, '$direccion');";
    $resultado = mysqli_query($conexion, $comando);
    if ($resultado) {
        $ventaId = mysqli_insert_id($conexion);
        $productosComprados = 0;
        foreach ($productos as $producto) {
            $productoId = $producto['producto']['id'];
            $cantidad = $producto['cantidad'];
            if (mysqli_query($conexion, "UPDATE `productos` SET `stock`=(IF(`stock`-$cantidad<0, 0, `stock`-$cantidad)) WHERE id=$productoId AND `stock`>=$cantidad;")) {
                mysqli_query($conexion, "INSERT INTO ventas_producto(venta_id, producto_id, cantidad) VALUES ($ventaId, $productoId, $cantidad);");
                $productosComprados++;
            }
        }
        if ($productosComprados == 0) {
            return -1;
        }
        return $ventaId;
    }
    return null;
}

function actualizarProducto($productoId, $nombre, $descripcion, $categoria, $precio, $stock) {
    $precio = intval($precio);
    $stock = intval($stock);
    $conexion = conectar();
    $comando = "UPDATE productos SET nombre='$nombre', descripcion='$descripcion', categoria='$categoria', precio=$precio, stock=$stock WHERE `id`=$productoId";
    $resultado = mysqli_query($conexion, $comando);
    if ($resultado) {
        return true;
    }
    return false;
}

function registrarGarantia($codigo, $problema, $descripcion){
    $conexion = conectar();

    $comando = "INSERT INTO garantias(codigo, problema, descripcion) VALUES ('$codigo', '$problema', $descripcion);";
    $resultado = mysqli_query($conexion, $comando);
    if ($resultado) {
        return mysqli_insert_id($conexion);
    }
    return null;
}

function buscarVentas(){

    $conexion = conectar();

    $comando = "SELECT * FROM `ventas`";

    $resultado = array();

    $peticion =  mysqli_query($conexion, $comando);
    if (mysqli_num_rows($peticion) > 0) {
        while($venta = mysqli_fetch_assoc($peticion)) {
            array_push($resultado, $venta);
        }
    }

    return $resultado;
}

function buscarProductoVenta($id){

    $conexion = conectar();

    $comando = "SELECT * FROM ventas_producto INNER JOIN ventas ON ventas_producto.venta_id = ventas.id INNER JOIN usuarios ON ventas.usuario_id = usuarios.id 
                INNER JOIN productos ON ventas_producto.producto_id = productos.id WHERE `venta_id`=$id";

    $resultado = array();

    $peticion =  mysqli_query($conexion, $comando);
    if (mysqli_num_rows($peticion) > 0) {
        while($ventaProducto = mysqli_fetch_assoc($peticion)) {
            array_push($resultado, $ventaProducto);
        }
    }

    return $resultado;
}

