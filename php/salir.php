<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    $id = $_SESSION['id'];

    $request= json_decode(file_get_contents('php://input'));

    function contar($data)
    {
        function compare($a, $i)
        {
            return $a > $i ? $a : $i;
        };

        $ids = [];

        foreach ($data as $key) {
            $ids[] = $key['id'];
        }

        return array_reduce($ids, "compare");
    }

    function salida($request, $id, $contar)
    {
        $fecha = $request->date;
        $hora = $request->time;

        require_once 'FuncConectar.php';
        $con= ConectarBD();

        $sql = "SELECT id, salida FROM Asistencia WHERE fecha = '$fecha' AND id_usuario = $id";

        $r = mysqli_query($con, $sql);

        if (mysqli_num_rows($r) == 0) {
            mysqli_close($con);
            exit(json_encode(
                array('State' => false)
            ));
        }

        $data = [];
        while ($d = $r->fetch_array(MYSQLI_ASSOC)) {
            $data[] = $d;
        }

        $idSalida = $contar($data);

        $query = "UPDATE `Asistencia` SET `salida`='$hora' WHERE id = $idSalida";

        if (mysqli_query($con, $query)) {
            mysqli_close($con);
            $request->State = true;
            exit(json_encode($request));
        } else {
            mysqli_close($con);
            $request->State = false;
            exit(json_encode($request));
        }
    }

    salida($request, $id, 'contar');
}
