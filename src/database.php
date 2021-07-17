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
        return mysqli_fetch_assoc($resultado);
    } else {
        // No se pudo encontrar el usuario.
        return null;
    }
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

function registrarDireccion($uid, $nombre, $direccion) {
    $conexion = conectar();
    $comando = "INSERT INTO direcciones(usuario_id, nombre, direccion) VALUES ($uid, '$nombre', '$direccion');";
    return mysqli_query($conexion, $comando);
}

function buscarProductos($busqueda = null): array {

    $conexion = conectar();

    if ($busqueda !== null) {
        $comando = "SELECT * FROM `productos` WHERE `nombre` LIKE '%".$busqueda."%'";
    } else {
        $comando = "SELECT * FROM productos";
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

function registrarProducto($nombre, $descripcion, $precio, $stock) {
    $precio = intval($precio);
    $stock = intval($stock);
    $conexion = conectar();
    $comando = "INSERT INTO productos(nombre, descripcion, precio, stock) VALUES ('$nombre', '$descripcion', $precio, $stock);";
    $resultado = mysqli_query($conexion, $comando);
    if ($resultado) {
        return mysqli_insert_id($conexion);
    }
    return null;
}

function actualizarProducto($productoId, $nombre, $descripcion, $precio, $stock) {
    $precio = intval($precio);
    $stock = intval($stock);
    $conexion = conectar();
    $comando = "UPDATE productos SET nombre='$nombre', descripcion='$descripcion', precio=$precio, stock=$stock WHERE `id`=$productoId";
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