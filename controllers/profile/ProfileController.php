<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

$part_include = str_replace("\controllers\profile", "", __DIR__);
require_once($part_include . "/controllers/Controller.php");
require_once($part_include . "/vendor/autoload.php");

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class ProfileController extends Controller
{
    private $db;
    private $key;
    private $result;

    public function __construct()
    {
        parent::__construct();

        $this->db = $this->connention();
        $this->key = $this->jwtKey();

        $part = str_replace("\controllers\profile", "", __DIR__);
        require_once($part . "/model/ProfileModel.php");
    }

    /**
     * @OA\Get(
     *     path="/api/v1/profile", tags={"Profile"}, description="Select Profile all",
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="400", description="Bad request"),
     *     security={{"bearerAuth":{}}}
     * )
     */

    public function getProfileAll()
    {
        $headers = apache_request_headers();

        $this->result = null;

        if (isset($headers["Authorization"])) {
            $token = str_replace('Bearer ', '', $headers['Authorization']);
            try {
                $token = JWT::decode($token, new Key($this->key, 'HS256'));
                $profileModel = new ProfileModel($this->db);
                $this->result = $profileModel->getAll();
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
     *     path="/api/v1/profile/{id}", tags={"Profile"}, description="Select profile by id",
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

     public function getProfileById()
     {
         $headers = apache_request_headers();
 
         $this->result = null;
 
         if (isset($headers["Authorization"])) {
             $token = str_replace('Bearer ', '', $headers['Authorization']);
             try {
                 $token = JWT::decode($token, new Key($this->key, 'HS256'));
                 $profileModel = new ProfileModel($this->db);
                 $profileModel->id = $this->id;
                 $this->result = $profileModel->getById();
             } catch (PDOException $e) {
                 $this->result = false;
             }
         } else {
             $this->result = false;
         }
 
         return $this->result;
     }

     /**
     * @OA\Post(path="/api/v1/profile/create", tags={"Profile"}, description="Create profile",
     * @OA\RequestBody(
     *  @OA\MediaType(
     *      mediaType="multipart/form-data",
     *      @OA\Schema(required={"first_name", "last_name", "phone", "email", "birthday", "file", "degree", "experience"},
     *          @OA\Property(property="first_name", type="string"),
     *          @OA\Property(property="last_name", type="string"),
     *          @OA\Property(property="phone", type="string"),
     *          @OA\Property(property="email", type="string"),
     *          @OA\Property(property="birthday", type="string"),
     *          @OA\Property(property="file", type="file"),
     *          @OA\Property(property="degree", type="string"),
     *          @OA\Property(property="experience", type="string")
     *      )
     *  )
     * ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="400", description="Bad request"),
     *     security={{"bearerAuth":{}}}
     * )
     */

    public function createProfile()
    {
        $headers = apache_request_headers();

        $this->result = null;

        if (isset($headers["Authorization"])) {
            $token = str_replace('Bearer ', '', $headers['Authorization']);
            try {
                $token = JWT::decode($token, new Key($this->key, 'HS256'));
                $profileModel = new ProfileModel($this->db);
                $profileModel->first_name = $this->first_name;
                $profileModel->last_name = $this->last_name;
                $profileModel->phone = $this->phone;
                $profileModel->email = $this->email;
                $profileModel->birthday = $this->birthday;
                $profileModel->img = $this->img;
                $profileModel->degree = $this->degree;
                $profileModel->experience = $this->experience;
                $result = $profileModel->insert();
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
     * @OA\Post(path="/api/v1/profile/{id}/update", tags={"Profile"}, description="Update profile",
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
     *      @OA\Schema(required={"first_name", "last_name", "phone", "email", "degree", "experience", "file"},
     *          @OA\Property(property="first_name", type="string"),
     *          @OA\Property(property="last_name", type="string"),
     *          @OA\Property(property="phone", type="string"),
     *          @OA\Property(property="email", type="string"),
     *          @OA\Property(property="degree", type="degree"),
     *          @OA\Property(property="experience", type="experience"),
     *          @OA\Property(property="file", type="file")
     *      )
     *  )
     * ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="400", description="Bad request"),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function updateProfile()
    {
        $headers = apache_request_headers();

        $this->result = null;

        if (isset($headers["Authorization"])) {
            $token = str_replace('Bearer ', '', $headers['Authorization']);
            try {
                $token = JWT::decode($token, new Key($this->key, 'HS256'));
                $profileModel = new ProfileModel($this->db);
                $profileModel->first_name = $this->first_name;
                $profileModel->last_name = $this->last_name;
                $profileModel->phone = $this->phone;
                $profileModel->email = $this->email;
                $profileModel->degree = $this->degree;
                $profileModel->experience = $this->experience;
                $profileModel->img = $this->img;
                $profileModel->id = $this->id;
                $result = $profileModel->update();
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
     * @OA\Post(path="/api/v1/profile/{id}/delete", tags={"Profile"}, description="Delete profile",
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

     public function deleteProfile()
     {
         $headers = apache_request_headers();
 
         $this->result = null;
 
         if (isset($headers["Authorization"])) {
             $token = str_replace('Bearer ', '', $headers['Authorization']);
             try {
                 $token = JWT::decode($token, new Key($this->key, 'HS256'));
                 $profileModel = new ProfileModel($this->db);
                 $profileModel->id = $this->id;
                 $this->result = $profileModel->delete();
             } catch (PDOException $e) {
                 $this->result = false;
             }
         } else {
             $this->result = false;
         }
 
         return $this->result;
     }

}
