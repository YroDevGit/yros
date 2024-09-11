<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(! function_exists('escapeString')){
    function escapeString($input) {
        $YROS = &Yros::get_instance();
        return $YROS->db->pdo->quote($input);
    }
}


if(! function_exists('post_data')){
    function post_data() :array{
        /**
         * Array
         * return the array data from from submission
         */
        if (isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] === 'application/json') {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
    
            if (json_last_error() === JSON_ERROR_NONE) {
                return $data; // Return the JSON data as an associative array
            } else {
                return ['error' => 'Invalid JSON format'];
            }
        } else {
            return $_POST;
        }
    }
}

if(! function_exists("post")){
    function post(string $inputname){
        /**
         * Any
         * get post data from your form submission
         */
        $post = post_data();
        
        if(empty($post)){
            return "";
        }
        else{
            if(value_in_array($inputname, $post)){
                return $post[$inputname];
            }
            else{
                return "";
            }
        }
    }
}

if(! function_exists("input")){
    function input(string $inputname){
        /**
         * Any
         * get post data from your form submission
         */
        return post($inputname);
    }
}

if(! function_exists("input_value")){
    function input_value(string $inputname){
        /**
         * Any
         * get post data from your form submission
         */
        return post($inputname);
    }
}

if(! function_exists("value_in_array")){
    function value_in_array($val, $arr){
        foreach($arr as $ar=>$b){
            if($ar==$val){
                return true;
            }
        }
        return false;
    }
}

if(! function_exists("file_input")){
    function file_input(string $inputname){
        if(empty($_FILES)){
            return null;
        }
        else{
            if(value_in_array($inputname, $_FILES)){
                return $_FILES[$inputname];
            }
            else{
                return null;
            }
        }
    }
}

if(! function_exists("validate_input")){
    function validate_input(string $inputname, string $label, string $validation){
        $YROS = &Yros::get_instance();
        $YROS->validationlib->validate_input($inputname, $label,$validation);
    }
}


if(! function_exists("set_validation")){
    function set_validation(string $inputname, string $label, string $validation){
        validate_input($inputname, $label, $validation);
    }
}

if(! function_exists("validation_failed")){
    function validation_failed(){
        $YROS = &Yros::get_instance();
        return $YROS->validationlib->validation_failed();
    }
}

if(! function_exists("set_input_error")){
    function set_input_error(string $input, string $error_message){
        $YROS = &Yros::get_instance();
        $YROS->validationlib->set_input_error($input, $error_message);
    }
}

if(! function_exists("get_input_error")){
    function get_input_error(string $input){
        $YROS = &Yros::get_instance();
        return $YROS->validationlib->get_input_error($input);
    }
}

if(! function_exists("get_all_input_error")){
    function get_all_input_error():array{
        $YROS = &Yros::get_instance();
        $ret = [];
        foreach($_SESSION as $value=>$key){
            if(string_contains($value, $YROS->validationlib->validation_session_error)){
                $column = string_remove($value, "flash_data_".$YROS->validationlib->validation_session_error);
                $ret[$column] = $key;
                unset($_SESSION[$value]);
            }
        }
        return $ret;
    }
}

if(! function_exists("old_value")){
    function old_value(string $input){
        $YROS = &Yros::get_instance();
        $mask = $YROS->old_input_value_mask_yros;
        if(isset($_SESSION[$mask.$input])){
            $var = $_SESSION[$mask.$input];
            unset($_SESSION[$mask.$input]);
            return $var;
        }
        else{
            return "";
        }
    }
}



?>