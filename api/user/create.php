<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

header('Access-Control-Allow-Origin: https://phattarawan-portfolio.popzone.link');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: POST');

$part = str_replace("/api/user", "", __DIR__);
require_once($part . "/controllers/user/UserController.php");

$userController = new UserController();

$params = array();
$params["first_name"] = isset($_POST["first_name"]) && !empty($_POST["first_name"]) ? $_POST["first_name"] : "";
$params["last_name"] = isset($_POST["last_name"]) && !empty($_POST["last_name"]) ? $_POST["last_name"] : "";
$params["phone"] = isset($_POST["phone"]) && !empty($_POST["phone"]) ? $_POST["phone"] : "";

$data = json_encode($params);
$data = json_decode($data);

$userController->first_name = $data->first_name;
$userController->last_name = $data->last_name;
$userController->phone = $data->phone;

if ($data->first_name == "") {
    http_response_code(401);
    echo json_encode(
        array(
            "code" => 401,
            "status" => "error",
            "title" => "Oops...",
            "message" => "You didn't enter your firstname. Please try again."
        )
    );
} elseif ($data->last_name == "") {
    http_response_code(401);
    echo json_encode(
        array(
            "code" => 401,
            "status" => "error",
            "title" => "Oops...",
            "message" => "You didn't enter your lastname. Please try again."
        )
    );
} elseif ($data->phone == "") {
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
    if ($rs = $userController->createUser()) {
        http_response_code(200);
        echo json_encode(
            array(
                "code" => 200,
                "respones" => array(
                    "id" => $rs
                ),
                "status" => "success",
                "title" => "Good job!",
                "message" => "You was create successfully."
            )
        );
    } else {
        http_response_code(401);
        echo json_encode(
            array(
                "code" => 401,
                "status" => "error",
                "title" => "Oops...",
                "message" => "You was not create successfully. Please try again."
            )
        );
    }
}
