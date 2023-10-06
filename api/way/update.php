<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: POST');

$part = str_replace("/api/way", "", __DIR__);
require_once($part . "/controllers/way/ExperController.php");

$experController = new ExperController();

$params = array();
$params["id"] = isset($id) && !empty($id) ? $id : "";
$params["date"] = isset($_POST["date"]) && !empty($_POST["date"]) ? $_POST["date"] : "";
$params["title"] = isset($_POST["title"]) && !empty($_POST["title"]) ? $_POST["title"] : "";
$params["detail"] = isset($_POST["detail"]) && !empty($_POST["detail"]) ? $_POST["detail"] : "";

$data = json_encode($params);
$data = json_decode($data);

$experController->date = $data->date;
$experController->title = $data->title;
$experController->detail = $data->detail;
$experController->id = $data->id;

if ($data->id == "") {
    http_response_code(401);
    echo json_encode(
        array(
            "code" => 401,
            "status" => "error",
            "title" => "Oops...",
            "message" => "You didn't enter your id. Please try again."
        )
    );
} elseif ($data->date == "") {
    http_response_code(401);
    echo json_encode(
        array(
            "code" => 401,
            "status" => "error",
            "title" => "Oops...",
            "message" => "You didn't enter your date. Please try again."
        )
    );
} elseif ($data->title == "") {
    http_response_code(401);
    echo json_encode(
        array(
            "code" => 401,
            "status" => "error",
            "title" => "Oops...",
            "message" => "You didn't enter your title. Please try again."
        )
    );
} elseif ($data->detail == "") {
    http_response_code(401);
    echo json_encode(
        array(
            "code" => 401,
            "status" => "error",
            "title" => "Oops...",
            "message" => "You didn't enter your detail. Please try again."
        )
    );
} else {
    if ($experController->updateExper()) {
        http_response_code(200);
        echo json_encode(
            array(
                "code" => 200,
                "status" => "success",
                "title" => "Good job!",
                "message" => "You was update successfully."
            )
        );
    } else {
        http_response_code(401);
        echo json_encode(
            array(
                "code" => 401,
                "status" => "error",
                "title" => "Oops...",
                "message" => "You was not update successfully. Please try again."
            )
        );
    }
}
