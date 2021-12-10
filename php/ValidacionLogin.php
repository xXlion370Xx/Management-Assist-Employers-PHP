<?php

session_start();

$usuario="";
$clave="";

if ($_POST) {
    $usuario=(isset($_POST['usuario'])) ? $_POST['usuario'] : "";
    $clave=(isset($_POST['contraseña'])) ? $_POST['contraseña'] : "";
}

require  'FuncConectar.php';
$conexion = ConectarBD();

$sql = "SELECT * FROM Usuarios WHERE Usuario = '$usuario' and Contraseña = '$clave'";

$Resultado = mysqli_fetch_assoc(mysqli_query($conexion, $sql));

if ($Resultado) {
    $_SESSION['usuario'] = $Resultado['Usuario'];
    $_SESSION['id'] = $Resultado['id'];
    $_SESSION['tipoUsuario'] = $Resultado['Tipo'];

    // echo <<<EOT
    // <script> alert("{$Resultado['Tipo']}") </script>
    // EOT;

    if ($Resultado['Tipo'] == "Empleado") {
        header('location: ../Empleados/SeleccionAsistencia.html');
    } elseif ($Resultado['Tipo'] == "Jefe") {
        header('location: ../Jefe/viewUsers.html');
    }
} else {
    echo "<script>
 			alert('Usuario y/o contraseña no encontrados.');
 			window.location = '../index.php';
 		 </script>";
}

mysqli_close($conexion);
