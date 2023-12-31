<?php
//headers
header('Allow-Control-Allow-Origin: *');
header('Content-Type: application/json');
// header('Allow-Control-Allow-Method: GET, POST, PUT, DELETE');
// header('Allow-Control-Allow-Headers: Access-Controll-Allow-Headers,Content-Type,Allow-Control-Allow-Method, Authorization,X-Requested-With');


//initializing our api
include_once('../core/initialize.php');

//initializing post
$post = new Post($db);
$errorMessage = new ErrorMessage();
//ini_set("allow_url_fopen", true);
//$data = json_decode(file_get_contents("php://input"));


if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400); // Bad Request
    echo json_encode(array('error' => 'Invalid JSON data'));
    exit;
}

$post->username           = (isset($_POST['UserName']) && $_POST['UserName'] != '') ? $_POST['UserName'] : $errorMessage->mandatoryFieldError();
$post->password           = (isset($_POST['Password']) && $_POST['Password'] != '') ? $_POST['Password'] : $errorMessage->mandatoryFieldError();
$post->customerNo         = (isset($_POST['CustomerNo']) && $_POST['CustomerNo'] != '') ? $_POST['CustomerNo'] : $errorMessage->mandatoryFieldError();
$post->Amount             = (isset($_POST['Amount']) && $_POST['Amount'] != '') ? $_POST['Amount'] : $errorMessage->mandatoryFieldError();
$post->UserMobileNumber   = isset($_POST['UserMobileNumber']) ? $_POST['UserMobileNumber'] : '';
$post->paymentDate        = (isset($_POST['PayTime']) && $_POST['PayTime'] != '') ? $_POST['PayTime'] : $errorMessage->mandatoryFieldError();
$post->TrxId              = (isset($_POST['TrxId']) && $_POST['TrxId'] != '') ? $_POST['TrxId'] : $errorMessage->mandatoryFieldError();

$post->authentication();

if ($post->msg == 'Successful') {
    $get_cust = $post->get_customer();
    // echo $post->id;
    // return;
    if($get_cust == "success_getCustomer"){
        if ($post->payBill()) {

            $errorMessage->successResponse();
    
        } else {
            $response = array(
                "ErrorCode" => '400',
                "ErrorMsg" => 'Error'
            );
            echo json_encode($response);
        }
    }else{
        $errorMessage->notFoundError();
    }
   
} else {
    $validation->checkAuthentication();
}



//make a json
