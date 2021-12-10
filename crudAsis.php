<?php

if ($_SERVER['REQUEST_METHOD'] ===  'POST') {
    session_start();



    require_once './php/FuncConectar.php';
    $con = ConectarBD();

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
            $entrada = $data->entrada;
            $salida = $data->salida;

            $sql = "UPDATE `Asistencia` SET `entrada` = '$entrada', `salida` = '$salida' WHERE `id` = $id";
            $result = mysqli_query($con, $sql);
            mysqli_close($con);

            if ($result) {
                exit(json_encode(array('status' => 'Registro actualizado')));
            } else {
                exit(json_encode(array('status' => $sql)));
            }

            break;

        case 'id':
            exit(json_encode($_SESSION));
            break;

        case 'one':
            $id = $data->id;
            $sql = "SELECT * FROM `Asistencia` WHERE id = $id";
            $result = mysqli_query($con, $sql);
            mysqli_close($con);
            if ($result) {
                exit(json_encode($result->fetch_array(MYSQLI_ASSOC)));
            }

            break;

        case 'delete':
            $id = $data->id;
            $sql = "DELETE FROM `Asistencia` WHERE `id` = $id";
            $result = mysqli_query($con, $sql);
            mysqli_close($con);

            if ($result) {
                exit(json_encode(array('status' => 'Registro eliminado')));
            }

            break;

        case 'all':
            $id = $data->id;
            $query = "SELECT id, entrada, salida, fecha FROM `Asistencia` WHERE id_usuario = $id";
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
