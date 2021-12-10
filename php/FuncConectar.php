<?php

function ConectarBD()
{
    $Servidor = "localhost";
    $Usuario = "root";
    $clave= "";
    $BaseDeDatos = "bu1lhvx9ay4kc5wgw2qq";

    $conexion = mysqli_connect($Servidor, $Usuario, $clave, $BaseDeDatos);

    return $conexion;
}
