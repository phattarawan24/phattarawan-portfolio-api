<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: POST');

$part = str_replace("\api\skill", "", __DIR__);
require_once($part . "/controllers/skill/SkillController.php");

$skillController = new SkillController();

$params = array();
$params["title"] = isset($_POST["title"]) && !empty($_POST["title"]) ? $_POST["title"] : "";
$params["level"] = isset($_POST["level"]) && !empty($_POST["level"]) ? $_POST["level"] : "";
$params["type"] = isset($_POST["type"]) && !empty($_POST["type"]) ? $_POST["type"] : "";

$data = json_encode($params);
$data = json_decode($data);

$skillController->title = $data->title;
$skillController->level = $data->level;
$skillController->type =$data->type;

if ($data->title == "") {
    http_response_code(401);
    echo json_encode(
        array(
            "code" => 401,
            "status" => "error",
            "title" => "Oops...",
            "message" => "You didn't enter your title. Please try again."
        )
    );
} elseif ($data->level == "") {
    http_response_code(401);
    echo json_encode(
        array(
            "code" => 401,
            "status" => "error",
            "title" => "Oops...",
            "message" => "You didn't enter your level. Please try again."
        )
    );
} elseif ($data->type == "") {
    http_response_code(401);
    echo json_encode(
        array(
            "code" => 401,
            "status" => "error",
            "title" => "Oops...",
            "message" => "You didn't enter your type. Please try again."
        )
    );
}else {
    if ($rs = $skillController->createSkill()) {
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
