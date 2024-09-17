<?php

class Secure_lib{

    private $key;

    public function __construct()
	{
        include "app/config/settings.php";
        $this->key = $app_settings['encryption_key'];

	}


    public function encrypt($data) {
        $cipher = "AES-256-CBC";
        $iv_length = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($iv_length);  
    
        $encrypted_data = openssl_encrypt($data, $cipher, $this->key, 0, $iv);
        $encrypted_data = base64_encode($iv . $encrypted_data); 
        return $encrypted_data;
    }

    function decrypt($encrypted_data) {
        $cipher = "AES-256-CBC";
        $iv_length = openssl_cipher_iv_length($cipher);
        $decoded_data = base64_decode($encrypted_data);
        $iv = substr($decoded_data, 0, $iv_length);
        $encrypted_data = substr($decoded_data, $iv_length);
        $decrypted_data = openssl_decrypt($encrypted_data, $cipher, $this->key, 0, $iv);
        return $decrypted_data;
    }




}

?>