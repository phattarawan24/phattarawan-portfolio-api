<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: POST');

$part = str_replace("\api\skill", "", __DIR__);
require_once($part . "/controllers/skill/SkillController.php");

$skillController = new SkillController();

$params = array();
$params["id"] = isset($id) && !empty($id) ? $id : "";

$data = json_encode($params);
$data = json_decode($data);

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
} else {
    if ($skillController->deleteSkill()) {
        http_response_code(200);
        echo json_encode(
            array(
                "code" => 200,
                "status" => "success",
                "title" => "Good job!",
                "message" => "You was delete successfully."
            )
        );
    } else {
        http_response_code(401);
        echo json_encode(
            array(
                "code" => 401,
                "status" => "error",
                "title" => "Oops...",
                "message" => "You was not delete successfully. Please try again."
            )
        );
    }
}
