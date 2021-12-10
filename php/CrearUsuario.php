<?php

require_once 'FuncConectar.php';
$conexion = ConectarBD();

$nombre = $_POST['nombre'];
$tipoU = $_POST['UserType'];

$sql = "INSERT INTO Usuarios(Usuario, Contraseña, Tipo) VALUES('$nombre', 123, '$tipoU')";
$consulta = mysqli_query($conexion, $sql);

if ($consulta) {
    header('location: ../Jefe/viewUsers.html');
} else {
    echo "<scritp>
    alert('algo salio mal');
    window.location('../viewUsers.html');
    </scritp>";
}
mysqli_close($conexion);
