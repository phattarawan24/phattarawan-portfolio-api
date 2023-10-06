<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: POST');

$part = str_replace("/api/auth", "", __DIR__);
require_once($part . "/controllers/auth/AuthContoller.php");

$authController = new AuthContoller();

$params = array();
$params["phone"] = isset($_POST["phone"]) && !empty($_POST["phone"]) ? $_POST["phone"] : "";

$data = json_encode($params);
$data = json_decode($data);

$authController->phone = $data->phone;

if ($data->phone == "") {
    http_response_code(401);
    echo json_encode(
        array(
            "code" => 401,
            "status" => "error",
            "title" => "Oops...",
            "message" => "You didn't enter your phone. Please try again."
        )
    );
} else {
    if (!empty($authController->auth()) && $authController->auth()) {
        http_response_code(200);
        echo json_encode(
            array(
                "response" => $authController->auth(),
                "code" => 200,
                "status" => "success",
                "title" => "Good job!",
                "message" => "You was authorization successfully."
            )
        );
    } else {
        http_response_code(401);
        echo json_encode(
            array(
                "code" => 401,
                "status" => "error",
                "title" => "Oops...",
                "message" => "You was not authorization successfully. Please try again."
            )
        );
    }
}
