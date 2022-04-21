<?php

/** If you have cloned the JWT from Github,
 * include it in the following way, and remove the require autoload.php
 * require './php-jwt/src/JWT.php';
 */


require __DIR__ . '/vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;;

class JwtHandler
{
    protected $jwt_secrect = "this is our secret";
    protected $token;
    protected $issuedAt;
    protected $expire;
    protected $jwt;

    public function __construct()
    {
        // set your default time-zone
        date_default_timezone_set('Africa/Asmara');
        $this->issuedAt = time();

        // Token Validity (3600 second = 1hr)
        $this->expire = $this->issuedAt + 3600;

        // Set your secret or signature
        $this->jwt_secrect = "this_is_my_secrect";
    }

    public function jwtEncodeData($iss, $data)
    {

        $this->token = array(
            //Adding the identifier to the token (who issue the token)
            "iss" => $iss,
            "aud" => $iss,
            // Adding the current timestamp to the token, for identifying that when the token was issued.
            "iat" => $this->issuedAt,
            // Token expiration
            "exp" => $this->expire,
            // Payload
            "data" => $data
        );

        $this->jwt = JWT::encode($this->token, $this->jwt_secrect, 'HS256');
        return $this->jwt;
    }

    public function jwtDecodeData($jwt_token)
    {
        $key = "this_is_my_secrect";
        try {
            $decode = JWT::decode($jwt_token, $key, array('HS256'));
            //JWT::decode($jwt_token, $this->jwt_secrect, array('HS256'));
                    
            return $decode->data;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}