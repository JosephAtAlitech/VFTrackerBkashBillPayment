<?php

$request = $_SERVER['REQUEST_URI'];
$viewDir = '/api/';

switch ($request) {
    case '':
    case '/api/queryBill':
        require __DIR__ . $viewDir . 'queryBill.php';
        break;

    case '/api/paybill':
        require __DIR__ . $viewDir . 'paybill.php';
        break;

    case '/api/searchTransaction':
        require __DIR__ . $viewDir . 'searchTransaction.php';
        break;

    default:
        http_response_code(404);
        require __DIR__ . $viewDir . '404.php';
}