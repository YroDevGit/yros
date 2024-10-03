<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(! function_exists("set_session_data")){
    function set_session_data(string $key, $data){
        $YROS = &Yros::get_instance();
        $YROS->sessionlib->set_session_data($key, $data);
    }
}

if(! function_exists("get_session_data")){
    function get_session_data(string $key){
        $YROS = &Yros::get_instance();
        return $YROS->sessionlib->get_session_data($key);
    }
}

if(! function_exists("remove_session_data")){
    function remove_session_data(string $key){
        $YROS = &Yros::get_instance();
        return $YROS->sessionlib->remove_session_data($key);
    }
}

if(! function_exists("set_flash_data")){
    function set_flash_data(string $key, string|float|int $data){
        $YROS = &Yros::get_instance();
        $YROS->sessionlib->set_flash_data($key, $data);
    }
}

if(! function_exists("get_flash_data")){
    function get_flash_data(string $key){
        $YROS = &Yros::get_instance();
        return $YROS->sessionlib->get_flash_data($key);
    }
}

if(! function_exists("flash_data")){
    function flash_data(string $key){
        return get_flash_data($key);
    }
}


if(! function_exists("set_cookie_value")){
    function set_cookie_value(string $key, string|int|bool|float $value, $time = null){
        $YROS = &Yros::get_instance();
        if ($time === null) {
            $time = time() + (86400 * 30);
        }
        $YROS->sessionlib->set_cookie_value($key, $value, $time);
    }
}

if(! function_exists("get_cookie_value")){
    function get_cookie_value(string $key){
        $YROS = &Yros::get_instance();
        return $YROS->sessionlib->get_cookie_value($key);
    }
}

if(! function_exists("cookie_value")){
    function cookie_value(string $key){
        return cookie_value($key);
    }
}

if(! function_exists("remove_cookie")){
    function remove_cookie(string $key){
        $YROS = &Yros::get_instance();
        $YROS->sessionlib->remove_cookie($key);
    }
}

if(! function_exists("set_cookie_data")){
    function set_cookie_data(string $key, array $data, $time = null){
        $YROS = &Yros::get_instance();
        if ($time === null) {
            $time = time() + (86400 * 30);
        }
        $YROS->sessionlib->set_cookie_data($key, $data, $time);
    }
}

if(! function_exists("get_cookie_data")){
    function get_cookie_data(string $key, string $subkey=""){
        $YROS = &Yros::get_instance();
        return $YROS->sessionlib->get_cookie_data($key, $subkey);
    }
}

if(! function_exists("cookie_data")){
    function cookie_data(string $key, string $subkey=""){
        return get_cookie_data($key, $subkey);
    }
}

if(! function_exists("remove_all_cookies")){
    function remove_all_cookies(){
        foreach ($_COOKIE as $cookie_name => $cookie_value) {
            setcookie($cookie_name, '', time() - 3600, '/');
        }
    }
}

if(! function_exists("remove_all_sessions")){
    function remove_all_sessions(){
        session_destroy();
    }
}



?>