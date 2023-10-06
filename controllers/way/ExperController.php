<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

$part_include = str_replace("/controllers/way", "", __DIR__);
require_once($part_include . "/controllers/Controller.php");
require_once($part_include . "/vendor/autoload.php");

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class ExperController extends Controller
{
    private $db;
    private $key;
    private $result;

    public function __construct()
    {
        parent::__construct();

        $this->db = $this->connention();
        $this->key = $this->jwtKey();

        $part = str_replace("/controllers/way", "", __DIR__);
        require_once($part . "/model/ExperModel.php");
    }

    /**
     * @OA\Get(
     *     path="/api/v1/way", tags={"Way"}, description="Select way all",
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="400", description="Bad request"),
     *     security={{"bearerAuth":{}}}
     * )
     */

    public function getExperAll()
    {
        $headers = apache_request_headers();

        $this->result = null;

        if (isset($headers["Authorization"])) {
            $token = str_replace('Bearer ', '', $headers['Authorization']);
            try {
                $token = JWT::decode($token, new Key($this->key, 'HS256'));
                $experModel = new ExperModel($this->db);
                $this->result = $experModel->getAll();
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
     *     path="/api/v1/way/{id}", tags={"Way"}, description="Select way by id",
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

     public function getExperById()
     {
         $headers = apache_request_headers();
 
         $this->result = null;
 
         if (isset($headers["Authorization"])) {
             $token = str_replace('Bearer ', '', $headers['Authorization']);
             try {
                 $token = JWT::decode($token, new Key($this->key, 'HS256'));
                 $experModel = new ExperModel($this->db);
                 $experModel->id = $this->id;
                 $this->result = $experModel->getById();
             } catch (PDOException $e) {
                 $this->result = false;
             }
         } else {
             $this->result = false;
         }
 
         return $this->result;
     }

     /**
     * @OA\Post(path="/api/v1/way/create", tags={"Way"}, description="Create way",
     * @OA\RequestBody(
     *  @OA\MediaType(
     *      mediaType="multipart/form-data",
     *      @OA\Schema(required={"date", "title", "detail"},
     *          @OA\Property(property="date", type="string"),
     *          @OA\Property(property="title", type="string"),
     *          @OA\Property(property="detail", type="string")
     *      )
     *  )
     * ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="400", description="Bad request"),
     *     security={{"bearerAuth":{}}}
     * )
     */

    public function createExper()
    {
        $headers = apache_request_headers();

        $this->result = null;

        if (isset($headers["Authorization"])) {
            $token = str_replace('Bearer ', '', $headers['Authorization']);
            try {
                $token = JWT::decode($token, new Key($this->key, 'HS256'));
                $experModel = new ExperModel($this->db);
                $experModel->date = $this->date;
                $experModel->title = $this->title;
                $experModel->detail = $this->detail;
                $result = $experModel->insert();
                if ($result) {
                        $this->result = $result;
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
     * @OA\Post(path="/api/v1/way/{id}/update", tags={"Way"}, description="Update way",
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
     *      @OA\Schema(required={"date", "title", "detail"},
     *          @OA\Property(property="date", type="string"),
     *          @OA\Property(property="title", type="string"),
     *          @OA\Property(property="detail", type="string")
     *      )
     *  )
     * ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="400", description="Bad request"),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function updateExper()
    {
        $headers = apache_request_headers();

        $this->result = null;

        if (isset($headers["Authorization"])) {
            $token = str_replace('Bearer ', '', $headers['Authorization']);
            try {
                $token = JWT::decode($token, new Key($this->key, 'HS256'));
                $experModel = new ExperModel($this->db);
                $experModel->date = $this->date;
                $experModel->title = $this->title;
                $experModel->detail = $this->detail;
                $experModel->id = $this->id;
                $result = $experModel->update();
                if ($result) {
                        $this->result = $result ;
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
     * @OA\Post(path="/api/v1/way/{id}/delete", tags={"Way"}, description="Delete way",
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

     public function deleteExper()
     {
         $headers = apache_request_headers();
 
         $this->result = null;
 
         if (isset($headers["Authorization"])) {
             $token = str_replace('Bearer ', '', $headers['Authorization']);
             try {
                 $token = JWT::decode($token, new Key($this->key, 'HS256'));
                 $experModel = new ExperModel($this->db);
                 $experModel->id = $this->id;
                 $this->result = $experModel->delete();
             } catch (PDOException $e) {
                 $this->result = false;
             }
         } else {
             $this->result = false;
         }
 
         return $this->result;
     }
}
