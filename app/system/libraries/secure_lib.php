<?php

class Secure_lib{

    private $key;

    public function __construct()
	{
        include "app/config/settings.php";
        $this->key = $app_settings['encryption_key'];

	}


    public function encrypt($data, string $key = null) {
        $cipher = "AES-256-CBC";
        $iv_length = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($iv_length);
        $encrypted_data = null;
        if($key==null||$key==""){
            $encrypted_data = openssl_encrypt($data, $cipher, $this->key, 0, $iv);
        }else{
            $encrypted_data = openssl_encrypt($data, $cipher, $key, 0, $iv);
        }
        

        $combined_data = $iv . $encrypted_data;
    

        $encrypted_data = base64_encode($combined_data);
    
        $encrypted_data = strtr($encrypted_data, [
            '+' => '-',  
            '/' => '_',  
            '=' => '',   
            '&' => '%26', 
            '#' => '%23',
        ]);
        return $encrypted_data;
    }
    
    public function decrypt($encrypted_data, string $key = null) {
        $cipher = "AES-256-CBC";
        $iv_length = openssl_cipher_iv_length($cipher);
        $encrypted_data = strtr($encrypted_data, [
            '-' => '+',  
            '_' => '/', 
            '%26' => '&', 
            '%23' => '#', 
        ]);
    
        $padding_needed = 4 - (strlen($encrypted_data) % 4);
        if ($padding_needed !== 4) {
            $encrypted_data .= str_repeat('=', $padding_needed);
        }
    
        $decoded_data = base64_decode($encrypted_data);
        $iv = substr($decoded_data, 0, $iv_length);
        $encrypted_data = substr($decoded_data, $iv_length);
        $decrypted_data = null;
        if($key==null||$key==""){
            $decrypted_data = openssl_decrypt($encrypted_data, $cipher, $this->key, 0, $iv);
        }else{
            $encrypted_data = openssl_decrypt($encrypted_data, $cipher, $key, 0, $iv);
        }
        return $decrypted_data;
    }
    




}

?>