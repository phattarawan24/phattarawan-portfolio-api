<?php
// print_r(__DIR__);
// exit();
if (!defined('BASEPATH')) exit('No direct script access allowed');
$part_include = str_replace("/controllers/auth", "", __DIR__);
require_once($part_include . "/controllers/Controller.php");
require_once($part_include . "/vendor/autoload.php");

use Firebase\JWT\JWT;

class AuthContoller extends Controller
{
    private $db;
    private $key;
    private $result;

    public function __construct()
    {
        parent::__construct();

        $this->db = $this->connention();
        $this->key = $this->jwtKey();

        $part = str_replace("/controllers/auth", "", __DIR__);
        require_once($part . "/model/UserModel.php");
    }

    /**
     * @OA\Post(path="/api/v1/login", tags={"Authorization"}, description="Get token",
     * @OA\RequestBody(
     *  @OA\MediaType(
     *      mediaType="multipart/form-data",
     *      @OA\Schema(required={"phone"},
     *          @OA\Property(property="phone", type="string")
     *      )
     *  )
     * ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="400", description="Bad request")
     * )
     */

    public function auth()
    {
        $this->result = null;

        try {
            $userModel = new UserModel($this->db);
            $userModel->phone = $this->phone;
            $stmt = $userModel->getByPhone();
            if ($stmt) {
                $countRow = $stmt->rowCount();
                $user_id = '';
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $user_id = $row['id'];
                }
                if ($countRow > 0) {
                    $iat = time();
                    $exp = $iat + 60 * 60;
                    $payload = [
                        'iss' => 'http://localhost:9600/',
                        'aud' => 'http://localhost:9600/',
                        'iat' => $iat,
                        'exp' => $exp,
                        'user_id' => $user_id
                    ];
                    $jwt = JWT::encode($payload, $this->key, 'HS256');
                    $this->result = array(
                        'token' => $jwt,
                        'expires' => $exp
                    );
                } else {
                    $this->result = false;
                }
            } else {
                $this->result = false;
            }
        } catch (PDOException $e) {
            $this->result = false;
        }

        return $this->result;
    }

    /**
     * @OA\Post(path="/api/v1/register", tags={"Authorization"}, description="Register user",
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
     *     @OA\Response(response="400", description="Bad request")
     * )
     */

    public function register()
    {
        $this->result = null;

        try {
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

        return $this->result;
    }
}
