<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: POST');

$part = str_replace("\api\profile", "", __DIR__);
require_once($part . "/controllers/profile/ProfileController.php");

$profileController = new ProfileController();

$params = array();
$params["first_name"] = isset($_POST["first_name"]) && !empty($_POST["first_name"]) ? $_POST["first_name"] : "";
$params["last_name"] = isset($_POST["last_name"]) && !empty($_POST["last_name"]) ? $_POST["last_name"] : "";
$params["phone"] = isset($_POST["phone"]) && !empty($_POST["phone"]) ? $_POST["phone"] : "";
$params["email"] = isset($_POST["email"]) && !empty($_POST["email"]) ? $_POST["email"] : "";
$params["birthday"] = isset($_POST["birthday"]) && !empty($_POST["birthday"]) ? $_POST["birthday"] : "";
$file_ext = isset($_FILES['file']['name']) && !empty($_FILES['file']['name']) ? $_FILES['file']['name'] : "";
$file_tmp = isset($_FILES['file']['tmp_name']) && !empty($_FILES['file']['tmp_name']) ? $_FILES['file']['tmp_name'] : "" ;
$params["degree"] = isset($_POST["degree"]) && !empty($_POST["degree"]) ? $_POST["degree"] : "";
$params["experience"] = isset($_POST["experience"]) && !empty($_POST["experience"]) ? $_POST["experience"] : "";

$data = json_encode($params);
$data = json_decode($data);

$profileController->first_name = $data->first_name;
$profileController->last_name = $data->last_name;
$profileController->phone = $data->phone;
$profileController->email = $data->email;
$profileController->birthday = $data->birthday;
$profileController->degree = $data->degree;
$profileController->experience = $data->experience;

if (!empty($file_ext) && !empty($file_tmp)) {
    $type = pathinfo($file_ext, PATHINFO_EXTENSION);
    $file_from_upload = file_get_contents($file_tmp);
    $file_base64 = 'data:image/' . $type . ';base64,' . base64_encode($file_from_upload);
    $profileController->img = $file_base64;
} else {
    $profileController->img = null;
}

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
} elseif ($data->email == "") {
    http_response_code(401);
    echo json_encode(
        array(
            "code" => 401,
            "status" => "error",
            "title" => "Oops...",
            "message" => "You didn't enter your email. Please try again."
        )
    );
} elseif ($data->birthday == "") {
    http_response_code(401);
    echo json_encode(
        array(
            "code" => 401,
            "status" => "error",
            "title" => "Oops...",
            "message" => "You didn't enter your birthday. Please try again."
        )
    );
} elseif ($data->degree == "") {
    http_response_code(401);
    echo json_encode(
        array(
            "code" => 401,
            "status" => "error",
            "title" => "Oops...",
            "message" => "You didn't enter your degree. Please try again"
        )
    );
} elseif ($data->experience == "") {
    http_response_code(401);
    echo json_encode(
        array(
            "code" => 401,
            "status" => "error",
            "title" => "Oops...",
            "message" => "You didn't enter your experience. Please try again"
        )
    );
}
else {
    if ($rs = $profileController->createProfile()) {
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
