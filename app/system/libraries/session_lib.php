<?php
class Session_lib{
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
        $_SESSION["flash_data_".$key] = $data;
    }

    public function get_flash_data($key){
        $flsh ="flash_data_";
        if(isset($_SESSION[$flsh.$key])){
            $val = $_SESSION[$flsh.$key];
            unset($_SESSION[$flsh.$key]);
            return $val;
        }
        else{
            return null;
        }
    }

    public function remove_flash_data(string $key){
        unset($_SESSION["flash_data_".$key]);
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