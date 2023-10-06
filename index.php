<?php
// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN']) && $_SERVER['ORIGIN'] == "https://phattarawan-portfolio.popzone.link") {
    // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
    // you want to allow, and if so:
    header("Access-Control-Allow-Origin: https://phattarawan-portfolio.popzone.link");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}
    
// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        // may also be using PUT, PATCH, HEAD etc
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    
    exit(0);
}

define("BASEPATH", true);

use AltoRouter as Router;

require_once realpath(__DIR__ . "/vendor/autoload.php");

$router = new Router();

$router->map('GET', '/', function () {
    require __DIR__ . '/view/landing.php';
});

$router->map('GET', '/api/documentation', function () {
    require __DIR__ . '/documentation/index.php';
});

$router->map('POST', '/api/v1/login', function () {
    require __DIR__ . '/api/auth/auth.php';
});

$router->map('POST', '/api/v1/register', function () {
    require __DIR__ . '/api/auth/register.php';
});

$router->map('GET', '/api/v1/profile', function () {
    require __DIR__ . '/api/profile/get_all.php';
});

$router->map('GET', '/api/v1/profile/[i:id]', function ($id) {
    require __DIR__ . '/api/profile/get_by_id.php';
});

$router->map('POST', '/api/v1/profile/create', function () {
    require __DIR__ . '/api/profile/create.php';
});

$router->map('POST', '/api/v1/profile/[i:id]/update', function ($id) {
    require __DIR__ . '/api/profile/update.php';
});

$router->map('POST', '/api/v1/profile/[i:id]/delete', function ($id) {
    require __DIR__ . '/api/profile/delete.php';
});

$router->map('GET', '/api/v1/skill', function () {
    require __DIR__ . '/api/skill/get_all.php';
});

$router->map('GET', '/api/v1/skill/[i:id]', function ($id) {
    require __DIR__ . '/api/skill/get_by_id.php';
});

$router->map('POST', '/api/v1/skill/create', function () {
    require __DIR__ . '/api/skill/create.php';
});

$router->map('POST', '/api/v1/skill/[i:id]/update', function ($id) {
    require __DIR__ . '/api/skill/update.php';
});

$router->map('POST', '/api/v1/skill/[i:id]/delete', function ($id) {
    require __DIR__ . '/api/skill/delete.php';
});

$router->map('GET', '/api/v1/way', function () {
    require __DIR__ . '/api/way/get_all.php';
});

$router->map('GET', '/api/v1/way/[i:id]', function ($id) {
    require __DIR__ . '/api/way/get_by_id.php';
});

$router->map('POST', '/api/v1/way/create', function () {
    require __DIR__ . '/api/way/create.php';
});

$router->map('POST', '/api/v1/way/[i:id]/update', function ($id) {
    require __DIR__ . '/api/way/update.php';
});

$router->map('POST', '/api/v1/way/[i:id]/delete', function ($id) {
    require __DIR__ . '/api/way/delete.php';
});

$router->map('GET', '/api/v1/user', function () {
    require __DIR__ . '/api/user/get_all.php';
});

$router->map('GET', '/api/v1/user/[i:id]', function ($id) {
    require __DIR__ . '/api/user/get_by_id.php';
});

$router->map('POST', '/api/v1/user/create', function () {
    require __DIR__ . '/api/user/create.php';
});

$router->map('POST', '/api/v1/user/[i:id]/update', function ($id) {
    require __DIR__ . '/api/user/update.php';
});

$router->map('POST', '/api/v1/user/[i:id]/delete', function ($id) {
    require __DIR__ . '/api/user/delete.php';
});

$router->map('GET', '/api/v1/me', function () {
    require __DIR__ . '/api/user/get_me.php';
});

$match = $router->match();

if (is_array($match) && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
} else {
    header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}
