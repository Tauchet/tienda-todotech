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

function registrarProducto($nombre, $descripcion, $precio) {
    $precio = intval($precio);
    $conexion = conectar();
    $comando = "INSERT INTO productos(nombre, descripcion, precio) VALUES ('$nombre', '$descripcion', $precio);";
    $resultado = mysqli_query($conexion, $comando);
    if ($resultado) {
        return mysqli_insert_id($conexion);
    }
    return null;
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