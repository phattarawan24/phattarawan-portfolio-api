<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

$part_include = str_replace("/controllers//skill", "", __DIR__);
require_once($part_include . "/controllers/Controller.php");
require_once($part_include . "/vendor/autoload.php");

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class SkillController extends Controller
{
    private $db;
    private $key;
    private $result;

    public function __construct()
    {
        parent::__construct();

        $this->db = $this->connention();
        $this->key = $this->jwtKey();

        $part = str_replace("/controllers/skill", "", __DIR__);
        require_once($part . "/model/SkillModel.php");
    }

    /**
     * @OA\Get(
     *     path="/api/v1/skill", tags={"Skill"}, description="Select skill all",
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="400", description="Bad request"),
     *     security={{"bearerAuth":{}}}
     * )
     */

    public function getSkillAll()
    {
        $headers = apache_request_headers();

        $this->result = null;

        if (isset($headers["Authorization"])) {
            $token = str_replace('Bearer ', '', $headers['Authorization']);
            try {
                $token = JWT::decode($token, new Key($this->key, 'HS256'));
                $skillModel = new SkillModel($this->db);
                $this->result = $skillModel->getAll();
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
     *     path="/api/v1/skill/{id}", tags={"Skill"}, description="Select skill by id",
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

     public function getSkillById()
     {
         $headers = apache_request_headers();
 
         $this->result = null;
 
         if (isset($headers["Authorization"])) {
             $token = str_replace('Bearer ', '', $headers['Authorization']);
             try {
                 $token = JWT::decode($token, new Key($this->key, 'HS256'));
                 $skillModel = new SkillModel($this->db);
                 $skillModel->id = $this->id;
                 $this->result = $skillModel->getById();
             } catch (PDOException $e) {
                 $this->result = false;
             }
         } else {
             $this->result = false;
         }
 
         return $this->result;
     }

     /**
     * @OA\Post(path="/api/v1/skill/create", tags={"Skill"}, description="Create skill",
     * @OA\RequestBody(
     *  @OA\MediaType(
     *      mediaType="multipart/form-data",
     *      @OA\Schema(required={"title", "level"},
     *          @OA\Property(property="title", type="string"),
     *          @OA\Property(property="level", type="string")
     *      )
     *  )
     * ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="400", description="Bad request"),
     *     security={{"bearerAuth":{}}}
     * )
     */

    public function createSkill()
    {
        $headers = apache_request_headers();

        $this->result = null;

        if (isset($headers["Authorization"])) {
            $token = str_replace('Bearer ', '', $headers['Authorization']);
            try {
                $token = JWT::decode($token, new Key($this->key, 'HS256'));
                $skillModel = new SkillModel($this->db);
                $skillModel->title = $this->title;
                $skillModel->level = $this->level;
                $result = $skillModel->insert();
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
     * @OA\Post(path="/api/v1/skill/{id}/update", tags={"Skill"}, description="Update skill",
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
     *      @OA\Schema(required={"title", "level"},
     *          @OA\Property(property="title", type="string"),
     *          @OA\Property(property="level", type="string")
     *      )
     *  )
     * ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="400", description="Bad request"),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function updateSkill()
    {
        $headers = apache_request_headers();

        $this->result = null;

        if (isset($headers["Authorization"])) {
            $token = str_replace('Bearer ', '', $headers['Authorization']);
            try {
                $token = JWT::decode($token, new Key($this->key, 'HS256'));
                $skillModel = new SkillModel($this->db);
                $skillModel->title = $this->title;
                $skillModel->level = $this->level;
                $skillModel->id = $this->id;
                $result = $skillModel->update();
                if ($result) {
                        $this->result = $result;
                    }  else {
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
     * @OA\Post(path="/api/v1/skill/{id}/delete", tags={"Skill"}, description="Delete skill",
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

     public function deleteSkill()
     {
         $headers = apache_request_headers();
 
         $this->result = null;
 
         if (isset($headers["Authorization"])) {
             $token = str_replace('Bearer ', '', $headers['Authorization']);
             try {
                 $token = JWT::decode($token, new Key($this->key, 'HS256'));
                 $skillModel = new SkillModel($this->db);
                 $skillModel->id = $this->id;
                 $this->result = $skillModel->delete();
             } catch (PDOException $e) {
                 $this->result = false;
             }
         } else {
             $this->result = false;
         }
 
         return $this->result;
     }
}
