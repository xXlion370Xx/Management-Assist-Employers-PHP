<?php

if ($_SERVER['REQUEST_METHOD'] ===  'POST') {
    require_once './php/FuncConectar.php';
    $con = ConectarBD();

    session_start();

    $data = json_decode(file_get_contents('php://input'));

    $operacion = $data->type;


    switch ($operacion) {
        case 'auth':
            if ($_SESSION['tipoUsuario'] == 'Jefe') {
                exit(json_encode(array('status' => true)));
            } else {
                exit(json_encode(array('status' => false)));
            }

            break;

        case 'update':
            $id = $data->id;
            $usuario = $data->Usuario;
            $tipo = $data->Tipo;
            $password = $data->password;

            $sql = "UPDATE `Usuarios` SET `Usuario` = '$usuario', `Tipo` = '$tipo', `Contraseña` = '$password' WHERE `id` = $id";
            $result = mysqli_query($con, $sql);
            mysqli_close($con);

            if ($result) {
                exit(json_encode(array('status' => 'Usuario actualizado')));
            } else {
                exit(json_encode(array('status' => $sql)));
            }

            break;

        case 'one':
            $id = $data->id;
            $sql = "SELECT * FROM `Usuarios` WHERE id = $id";
            $result = mysqli_query($con, $sql);
            mysqli_close($con);
            if ($result) {
                exit(json_encode($result->fetch_array(MYSQLI_ASSOC)));
            }

            break;

        case 'delete':
            $id = $data->id;
            $sql = "DELETE FROM `Usuarios` WHERE `id` = $id";
            $result = mysqli_query($con, $sql);
            mysqli_close($con);

            if ($result) {
                exit(json_encode(array('status' => 'Usuario eliminado')));
            }

            break;

        case 'all':
            $query = "SELECT id, Usuario, Tipo FROM `Usuarios`";
            $result = mysqli_query($con, $query);
            mysqli_close($con);
            $return = [];

            while ($d = $result->fetch_array(MYSQLI_ASSOC)) {
                $return[] = $d;
            }

            exit(json_encode($return));

            break;
        default:
            exit(json_encode(array('typeOf' => null)));
    }
}
