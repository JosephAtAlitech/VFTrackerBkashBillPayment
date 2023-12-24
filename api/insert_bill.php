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
$post->TotalAmount = $data->TotalAmount;
$post->UserMobileNumber = $data->UserMobileNumber;
$post->PayTime = $data->PayTime;
$post->insert_bill();



//make a json

?>