<?php
ini_set("display_errors", 1);
header("Acces-Control-Allow-Origin:*");
header("Acces-Control-Allow-Methods:POST");
header("Content-Type:application/json; charst=UTF-8");

require_once('../class/user.php');
require_once('../config/connection.php');
require_once('../class/encryption.php');
$db_obj = new DATABSE;
$conn = $db_obj->connection();
$user_obj = new USER($conn);

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $data = json_decode(file_get_contents("php://input"));
    if (!empty($data)) {
        $aes = new ENCRIPTION;
        $user_obj->name = $data->username;
        $user_obj->password = $aes->api_key_crypt($data->password, 'e');
        $user_obj->stat = $data->status;
        $user_obj->role = $data->role;
        $user_obj->mod_by = $data->mod_by;
        if ($user_obj->create_user()) {
            http_response_code(200);
            echo json_encode(array(
                "sts" => 1,
                "message" => "User has been created"
            ));
        } else {
            http_response_code(500);
            echo json_encode(array(
                "sts" => 0,
                "message" => "Failed to save"
            ));
        }
    } else {
        http_response_code(500);
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
