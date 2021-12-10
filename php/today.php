<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once './FuncConectar.php';
    $con = ConectarBD();

    $data = json_decode(file_get_contents('php://input'));
    $date = $data->date;
    $id = $_SESSION['id'];
    #$id = 4;


    $sql = "SELECT MAX(id) AS ID FROM Asistencia WHERE fecha = '$date' AND id_usuario = $id AND salida IS NULL;";
    $r = mysqli_fetch_array(mysqli_query($con, $sql));

    if ($r['ID']) {
        exit(json_encode(array('exist'=> true)));
    } else {
        exit(json_encode(array('exist'=> false)));
    }
}
