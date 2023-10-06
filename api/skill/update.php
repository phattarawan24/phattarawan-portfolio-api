<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

header('Access-Control-Allow-Origin: https://phattarawan-portfolio.popzone.link');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: POST');

$part = str_replace("/api/skill", "", __DIR__);
require_once($part . "/controllers/skill/SkillController.php");

$skillController = new SkillController();

$params = array();
$params["id"] = isset($id) && !empty($id) ? $id : "";
$params["title"] = isset($_POST["title"]) && !empty($_POST["title"]) ? $_POST["title"] : "";
$params["level"] = isset($_POST["level"]) && !empty($_POST["level"]) ? $_POST["level"] : "";

$data = json_encode($params);
$data = json_decode($data);

$skillController->title = $data->title;
$skillController->level = $data->level;
$skillController->id = $data->id;

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
}  else {
    if ($skillController->updateSkill()) {
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
