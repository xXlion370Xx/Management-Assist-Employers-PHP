<?php

function ConectarBD()
{
    $Servidor = "bawmdwmmony7jv7atnpm-mysql.services.clever-cloud.com";
    $Usuario = "us1zgtvwot2dh04y";
    $clave= "AQ4zjkUcPcsOufCjQhsU";
    $BaseDeDatos = "bawmdwmmony7jv7atnpm";

    $conexion = mysqli_connect($Servidor, $Usuario, $clave, $BaseDeDatos);

    return $conexion;
}
