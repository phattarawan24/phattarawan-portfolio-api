<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: GET');

$part = str_replace("/api/user", "", __DIR__);
require_once($part . "/controllers/user/UserController.php");

$userController = new UserController();

$stmt = $userController->getUserAll();

if ($stmt) {
    $resultCount = $stmt->rowCount();
    if ($resultCount > 0) {
        http_response_code(200);
        $arr = array();
        $arr["response"] = array();
        $arr["count"] = $resultCount;
        $arr["code"] = 200;
        $arr["status"] = "success";
        $arr["title"] = "Good jod!";
        $arr["message"] = $resultCount . " records";

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $r = $row;
            array_push($arr["response"], $r);
        }
        echo json_encode($arr);
    } else {
        http_response_code(200);
        echo json_encode(
            array(
                "response" => array(),
                "count" => 0,
                "code" => 200,
                "status" => "success",
                "title" => "Good jod!",
                "message" => "No records found."
            )
        );
    }
} else {
    http_response_code(200);
    echo json_encode(
        array(
            "response" => array(),
            "count" => 0,
            "code" => 400,
            "status" => "error",
            "title" => "Oops...",
            "message" => "Please try again."
        )
    );
}
