<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @OA\Info(title="My First API", version="1.0")
 *  @OA\SecurityScheme(
 *      type="http",
 *      description="Enter token",
 *      name="Authorization",
 *      in="header",
 *      scheme="bearer",
 *      bearerFormat="JWT",
 *      securityScheme="bearerAuth",
 * )
 */

class Controller
{
    private $db;
    private $key;

    public function __construct()
    {
        $part = str_replace("controllers", "", __DIR__);
        require_once($part . "/vendor/autoload.php");

        $dotenv = Dotenv\Dotenv::createImmutable($part);
        $dotenv->load();

        require_once($part . "/config/Database.php");

        $database = new Database($_ENV["HOST"], $_ENV["DATABASENAME"], $_ENV["USERNAME"], $_ENV["PASSWORD"], $_ENV["PORT"]);

        $this->db = $database->connection();
        $this->key = $_ENV["JWTKEY"];
    }

    public function connention()
    {
        return $this->db;
    }

    public function jwtKey()
    {
        return $this->key;
    }
}
