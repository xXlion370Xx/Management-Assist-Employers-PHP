<?php

session_start();


require_once 'FuncConectar.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'));

    $con = ConectarBD();
    $date = $data->date;
    $time = $data->time;
    $id = $_SESSION['id'];

    $sql = "INSERT INTO Asistencia (`id_usuario`, `entrada`, `fecha`) VALUES ($id, '$time', '$date')";

    if (mysqli_query($con, $sql)) {
        mysqli_close($con);
        $data->State = true;
        exit(json_encode($data));
    } else {
        mysqli_close($con);
        $data->State = false;
        exit(json_encode($data));
    }
}
