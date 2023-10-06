<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

$part_include = str_replace("/controllers/user", "", __DIR__);
require_once($part_include . "/controllers/Controller.php");
require_once($part_include . "/vendor/autoload.php");

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class UserController extends Controller
{
    private $db;
    private $key;
    private $result;

    public function __construct()
    {
        parent::__construct();

        $this->db = $this->connention();
        $this->key = $this->jwtKey();

        $part = str_replace("/controllers/user", "", __DIR__);
        require_once($part . "/model/UserModel.php");
    }

    /**
     * @OA\Get(
     *     path="/api/v1/user", tags={"User"}, description="Select user all",
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="400", description="Bad request"),
     *     security={{"bearerAuth":{}}}
     * )
     */

    public function getUserAll()
    {
        $headers = apache_request_headers();

        $this->result = null;

        if (isset($headers["Authorization"])) {
            $token = str_replace('Bearer ', '', $headers['Authorization']);
            try {
                $token = JWT::decode($token, new Key($this->key, 'HS256'));
                $userModel = new UserModel($this->db);
                $this->result = $userModel->getAll();
            } catch (PDOException $e) {
                $this->result = false;
            }
        } else {
            $this->result = false;
        }

        return $this->result;
    }

    /**
     * @OA\Get(
     *     path="/api/v1/user/{id}", tags={"User"}, description="Select user by id",
     *     @OA\Parameter(
     *          name="id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="400", description="Bad request"),
     *     security={{"bearerAuth":{}}}
     * )
     */

    public function getUserById()
    {
        $headers = apache_request_headers();

        $this->result = null;

        if (isset($headers["Authorization"])) {
            $token = str_replace('Bearer ', '', $headers['Authorization']);
            try {
                $token = JWT::decode($token, new Key($this->key, 'HS256'));
                $userModel = new UserModel($this->db);
                $userModel->id = $this->id;
                $this->result = $userModel->getById();
            } catch (PDOException $e) {
                $this->result = false;
            }
        } else {
            $this->result = false;
        }

        return $this->result;
    }

    /**
     * @OA\Post(path="/api/v1/user/create", tags={"User"}, description="Create user",
     * @OA\RequestBody(
     *  @OA\MediaType(
     *      mediaType="multipart/form-data",
     *      @OA\Schema(required={"first_name", "last_name", "phone"},
     *          @OA\Property(property="first_name", type="string"),
     *          @OA\Property(property="last_name", type="string"),
     *          @OA\Property(property="phone", type="string")
     *      )
     *  )
     * ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="400", description="Bad request"),
     *     security={{"bearerAuth":{}}}
     * )
     */

    public function createUser()
    {
        $headers = apache_request_headers();

        $this->result = null;

        if (isset($headers["Authorization"])) {
            $token = str_replace('Bearer ', '', $headers['Authorization']);
            try {
                $token = JWT::decode($token, new Key($this->key, 'HS256'));
                $userModel = new UserModel($this->db);
                $userModel->first_name = $this->first_name;
                $userModel->last_name = $this->last_name;
                $userModel->phone = $this->phone;
                $stmt = $userModel->getByPhone();
                if ($stmt) {
                    $countRow = $stmt->rowCount();
                    if ($countRow == 0) {
                        $this->result = $userModel->insert();
                    } else {
                        $this->result = false;
                    }
                } else {
                    $this->result = false;
                }
            } catch (PDOException $e) {
                $this->result = false;
            }
        } else {
            $this->result = false;
        }

        return $this->result;
    }

    /**
     * @OA\Post(path="/api/v1/user/{id}/update", tags={"User"}, description="Update user",
     *  @OA\Parameter(
     *    name="id",
     *    required=true,
     *    in="path",
     *    @OA\Schema(
     *      type="integer"
     *    ),
     *  ),
     *  @OA\RequestBody(
     *   @OA\MediaType(
     *      mediaType="multipart/form-data",
     *      @OA\Schema(required={"first_name", "last_name", "phone"},
     *          @OA\Property(property="first_name", type="string"),
     *          @OA\Property(property="last_name", type="string"),
     *          @OA\Property(property="phone", type="string")
     *      )
     *  )
     * ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="400", description="Bad request"),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function updateUser()
    {
        $headers = apache_request_headers();

        $this->result = null;

        if (isset($headers["Authorization"])) {
            $token = str_replace('Bearer ', '', $headers['Authorization']);
            try {
                $token = JWT::decode($token, new Key($this->key, 'HS256'));
                $userModel = new UserModel($this->db);
                $userModel->first_name = $this->first_name;
                $userModel->last_name = $this->last_name;
                $userModel->phone = $this->phone;
                $userModel->id = $this->id;
                $stmt = $userModel->getByPhone();
                if ($stmt) {
                    $countRow = $stmt->rowCount();
                    if ($countRow == 0) {
                        $this->result = $userModel->update();
                    } else {
                        $tmpUser = array();
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $r = $row;
                            array_push($tmpUser, $r);
                        }
                        if ($this->id == $tmpUser[0]['id']) {
                            $this->result = $userModel->update();
                        } else {
                            $this->result = false;
                        }
                    }
                } else {
                    $this->result = false;
                }
            } catch (PDOException $e) {
                $this->result = false;
            }
        } else {
            $this->result = false;
        }

        return $this->result;
    }

    /**
     * @OA\Post(path="/api/v1/user/{id}/delete", tags={"User"}, description="Delete user",
     *  @OA\Parameter(
     *    name="id",
     *    required=true,
     *    in="path",
     *    @OA\Schema(
     *      type="integer"
     *    ),
     *  ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="400", description="Bad request"),
     *     security={{"bearerAuth":{}}}
     * )
     */

    public function deleteUser()
    {
        $headers = apache_request_headers();

        $this->result = null;

        if (isset($headers["Authorization"])) {
            $token = str_replace('Bearer ', '', $headers['Authorization']);
            try {
                $token = JWT::decode($token, new Key($this->key, 'HS256'));
                $userModel = new UserModel($this->db);
                $userModel->id = $this->id;
                $this->result = $userModel->delete();
            } catch (PDOException $e) {
                $this->result = false;
            }
        } else {
            $this->result = false;
        }

        return $this->result;
    }

    /**
     * @OA\Get(
     *     path="/api/v1/me", tags={"Me"}, description="Select me",
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="400", description="Bad request"),
     *     security={{"bearerAuth":{}}}
     * )
     */

    public function getMe()
    {
        $headers = apache_request_headers();

        $this->result = null;

        if (isset($headers["Authorization"])) {
            $token = str_replace('Bearer ', '', $headers['Authorization']);
            try {
                $token = JWT::decode($token, new Key($this->key, 'HS256'));
                $userModel = new UserModel($this->db);
                $userModel->id = $token->user_id;
                $this->result = $userModel->getById();
            } catch (PDOException $e) {
                $this->result = false;
            }
        } else {
            $this->result = false;
        }

        return $this->result;
    }
}
