<?php

header ('Access-Control-Allow-Origin:*');
header ('Content-Type: application/json');
header ('Access-Control-Allow-Methods: GET, OPTIONS');
header ('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

include ('../../function.php');

$requestMethod = $_SERVER["REQUEST_METHOD"];

if($requestMethod == 'OPTIONS'){
    http_response_code(200);
    exit();
}

if($requestMethod == 'GET'){

    if(isset($_GET['log_id'])){

        $phase3 = getPhase3($_GET);
        echo $phase3;

    } else {

        $data = [
            'status' => 404,
            'message' => $requestMethod. ' Method Not Allowed',
        ];
        header("HTTP/1.0 404 Method Not Allowed");
        echo json_encode($data);

    }

} else {
    $data = [
        'status' => 405,
        'message' => $requestMethod. ' Method Not Allowed',
    ];
    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode($data);
}
?>