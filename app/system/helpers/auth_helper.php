<?php

if(! function_exists("set_login")){
    function set_login(bool $status, array $data = []){
        $YROS = &Yros::get_instance();
        return $YROS->auth->set_login($status, $data);
    }
}

if(! function_exists("is_logged_in")){
    function is_logged_in():bool{
        $YROS = &Yros::get_instance();
        return $YROS->auth->is_logged_in();
    }
}

if(! function_exists("get_login_data")){
    function get_login_data(){
        $YROS = &Yros::get_instance();
        return $YROS->auth->get_login_data();
    }
}

if(! function_exists("get_login_value")){
    function get_login_value(string $key){
        $YROS = &Yros::get_instance();
        return $YROS->auth->get_login_value($key);
    }
}


?>