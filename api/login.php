<?php
ini_set("display_errors", 1);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require '../JwtHandler.php';
require_once("../config/connection.php");
require_once("../class/user.php");
require_once("../class/encryption.php");
$obj = new DATABSE;
$conn = $obj->connection();
$user_obj = new User($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"));
    if (!empty($data->username) && !empty($data->password)) {
        $user_obj->name = $data->username;
        $user_obj->password = $data->password;
        $user_data = $user_obj->Check_login();

        if (!empty($user_data)) {
            $dec = new ENCRIPTION;
            $name = $user_data['u_name'];
            $password = $user_data['pass_word'];
            if ($data->password = $dec->api_key_crypt($password, 'd')) {
                http_response_code((200));
            

                $jwt = new JwtHandler();
                $token = $jwt->jwtEncodeData(
                'http://localhost/visting-management-system/',
                $user_data
                 );
   
               $userdata = array(
                                         "sts" => 1,
                                         "message" => "login succuss",
                                         "token" => $token
                                            ); 
	echo json_encode($userdata);    
            // return $token;

            } else {
                http_response_code((404));
                echo json_encode(array(
                    "sts" => 0,
                    "message" => "Wrong Password"
                ));
            }
        } else {
            http_response_code((404));
            echo json_encode(array(
                "sts" => 0,
                "message" => "Invalid credentials"
            ));
        }
    } else {
        http_response_code((404));
        echo json_encode(array(
            "sts" => 0,
            "message" => "Data missing"
        ));
    }
} else {
    http_response_code(503);
    echo json_encode(array(
        "sts" => 0,
        "message" => "Access Deined"
    ));
}
