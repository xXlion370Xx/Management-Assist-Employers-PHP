<?php

require './config/headers.php';

if ($_SERVER['REQUEST_METHOD'] ===  'GET') {
    $url = 'https://www.timeapi.io/api/TimeZone/zone?timeZone=America/Bogota';

    $options = array("ssl" => array("verify_peer" => false, "verify_peer_name" => false));

    $respuesta = file_get_contents($url, false, stream_context_create($options));

    $ResponseObj = json_decode($respuesta);

    if ($ResponseObj) {
        exit(json_encode($ResponseObj->currentLocalTime));
    } else {
        exit(json_encode(array('status' => false)));
    }
}
