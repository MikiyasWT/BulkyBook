<?php

ini_set("display_errors", 1);
class ENCRIPTION
{
    private $secret_key = '07a565b377ff6ecf93167a3eb1647086';
    private $secret_iv = '4cd41f88ed43d2c035e67bfd9c383962';
    private $key;
    private $encrypt_method = "AES-256-CBC";
    private $iv;

    function __construct()
    {
        $this->key = hash('sha256', $this->secret_key);
        $this->iv = substr(hash('sha256', $this->secret_iv), 0, 16);
    }

    function api_key_crypt($string, $action)
    {
        $output = '';
        if ($action == 'e') {
            $output = base64_encode(openssl_encrypt($string, $this->encrypt_method, $this->key, 0, $this->iv));
        } else if ($action == 'd') {
            $output = openssl_decrypt(base64_decode($string), $this->encrypt_method, $this->key, 0, $this->iv);
        }
        return $output;
    }
}

$obj = new ENCRIPTION;

// echo $obj->api_key_crypt("1234",'e');/

echo $obj->api_key_crypt("1234", 'd');
