<?php
class Session_lib{

    public $flash_mask = "flash_1005_data_yros1005_";
    public $input_mask = "yros_input_old_value_1005_yro_";

    public $input_storage = [];
    public $error_storage = [];
    public $fash_storage = [];
    
    public function __construct()
	{
		
	}

    public function set_session_data(string $key, $data){
        $_SESSION[$key] = $data;
    }

    public function get_session_data(string $key){
        if(isset($_SESSION[$key])){
            return $_SESSION[$key];
        }
        else{
            return null;
        }
    }

    public function remove_session_data(string $key){
        unset($_SESSION[$key]);
    }

    public function set_flash_data(string $key, string|float|int $data){
        $_SESSION[$this->flash_mask.$key] = $data;
    }

    public function get_flash_data($key){
        $YROS = &Yros::get_instance();
        $rarr = $YROS->yros_back_up_flash_data1005;
        return isset($rarr[$this->flash_mask.$key]) ? $rarr[$this->flash_mask.$key] : "";
    }

    public function remove_flash_data(string $key){
        unset($_SESSION[$this->flash_mask.$key]);
    }


    public function set_cookie_value(string $key, $value, $time){
        setcookie($key, $value,$time, "/");
    }

    public function get_cookie_value(string $key){
        if(isset($_COOKIE[$key])){
            return $_COOKIE[$key];
        }else{
            return null;
        }

    }

    public function set_cookie_data(string $key, array $data, $time){
        setcookie($key, json_encode($data), $time, "/");
    }

    public function get_cookie_data($key, $subkey=""){
        if(isset($_COOKIE[$key])){
            if($subkey==""||$subkey==null){
                return json_decode($_COOKIE[$key], true);
            }
            else{
                $decoded = json_decode($_COOKIE[$key], true);
                return $decoded[$subkey];
            }
        }
        else{
            return null;
        }
    }

    public function remove_cookie(string $key){
        setcookie($key, "", time() - 3600, "/");
    }


}

?>