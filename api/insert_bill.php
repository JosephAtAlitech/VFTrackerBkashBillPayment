<?php
//headers
header('Allow-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Allow-Control-Allow-Method: POST');
header('Allow-Control-Allow-Headers: Access-Controll-Allow-Headers,Content-Type,Allow-Control-Allow-Method, Authorization,X-Requested-With');

//initializing our api
include_once('../core/initialize.php');

//initializing post
$post = new Post($db);

$data = json_decode(file_get_contents("php://input"));

$post->id = $data->id;
$post->CustomerNo = $data->CustomerNo;
$post->Amount = $data->Amount;
$post->UserMobileNumber = $data->UserMobileNumber;
$post->paymentDate = $data->PayTime;
if ($post->insert_bill()) {
    $response = [
        "ErrorCode" => '200',
        "ErrorMsg" => 'Successful'
    ];
    echo json_decode($response);
} else {
    $response = [
        "ErrorCode" => '400',
        "ErrorMsg" => 'Error'
    ];
    echo json_decode($response);
}



//make a json
