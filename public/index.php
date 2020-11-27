<?php

use App\Service\PingService;

require_once "../vendor/autoload.php";



//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

function error_handler($errno, $errstr, $errfile, $errline)
{
    if (($errno & error_reporting()) > 0)
        throw new ErrorException($errstr, 500, $errno, $errfile, $errline);
    else
        return false;
}
set_error_handler('error_handler');

function dd($a)
{
    echo "<pre>";
    print_r($a);
    die();
}

if (strpos($_SERVER["REQUEST_URI"], '/api/v1/ping') === 0 && array_key_exists("host", $_GET)) {
    $bgpost = new \App\Service\PingService();

    $data = [];
    $data["host"] = trim($_GET['host']);
    $data["online"] = $bgpost->ping(trim($_GET['host']));

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);
} else {
    require "home.php";
}
