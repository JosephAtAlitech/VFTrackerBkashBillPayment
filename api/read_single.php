<?php
//headers
header('Allow-Control-Allow-Origin: *'); 
header('Content-Type: application/json');

//initializing our api
include_once('../core/initialize.php');

//initializing post
$post = new Post($db);

$post->username = isset($_GET['username']) ? $_GET['username'] : die();
$post->password = isset($_GET['passsword']) ? $_GET['passsword'] : die();
$post->CustomerNo = isset($_GET['CustomerNo']) ? $_GET['CustomerNo'] : die();
$post->read_single();

if($post->msg == 'success'){
    $post->get_customer();
    $post_arr = array(
        'username' => $post->username,
        'password' => $post->password,
        'CustomerNo' => $post->CustomerNo,
        'ErrorCodse' => 200,
        'ErrorMsg' => $post->msg
    );
    print_r(json_encode($post_arr));
}else{
    $post_arr = array(
        'ErrorCodse' => 400,
        'errorMsg' => $post->msg
    );
    print_r(json_encode($post_arr));
}

//make a json

?>