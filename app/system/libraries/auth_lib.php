<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_lib{

    public $auth_mask_code = "yros_authentication_code_199363_";
    public static $logintoken = "yros_user_login_token";

    public function __construct()
	{

	}

    public function set_login(bool $status, array $data=[]){
        if($status==true){
            set_cookie_value($this->auth_mask_code."status", $status);
            set_cookie_data($this->auth_mask_code."data", $data);
        }
        else{
            $this->remove_status();
        }
    }

    public function is_logged_in():bool{
        $data = get_cookie_value($this->auth_mask_code."status");
        $status = $data == null || $data == "" ? false : true;
        return $status;
    }

    public function get_login_data():array{
        $data = get_cookie_data($this->auth_mask_code."data");
        $status = empty($data) || $data == "" ? [] : $data;
        return $status;
    }

    public function get_login_value(string $key){
        $data = get_cookie_data($this->auth_mask_code."data", $key);
        $status = $data == null ? null : $data;
        return $status;
    }

    public function remove_status(){
        remove_cookie($this->auth_mask_code."status");
        remove_cookie($this->auth_mask_code."data");
    }

    public static function set_user_data(array $data = [], $expires = null){
        if(! empty($data)){
            if($expires == null){
                setcookie(self::$logintoken, encrypt(json_encode($data)));
            }else{
                setcookie(self::$logintoken, encrypt(json_encode($data)), $expires);
            }
        }
    }

    public static function get_user_data(string $key=""){
        $data =  $_COOKIE[self::$logintoken] ?? null;

        if($data){
          $data = decrypt($data);
          $data = json_decode($data, true); 
        }

        return $key == "" || $key == null ? $data ?? []: $data[$key] ?? null;
    
    }

    public static function has_user_data(){
        return isset($_COOKIE[self::$logintoken]);
    }

    public static function clear_user_data(){
        setcookie(self::$logintoken, "", time() - 3600, "/");
        unset($_COOKIE[self::$logintoken]);
    }

    
}
?>