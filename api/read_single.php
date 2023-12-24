<?php
//headers
header('Allow-Control-Allow-Origin: *'); 
header('Content-Type: application/json');

//initializing our api
include_once('../core/initialize.php');

//initializing post
$post = new Post($db);

$post->id = isset($_GET['id']) ? $_GET['id'] : die();
$post->read_single();

$post_arr = array(
    'id' => $post->id,
    'name' => $post->name
);

//make a json
print_r(json_encode($post_arr));
?>