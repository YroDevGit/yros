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
        if ($_SERVER['CONTENT_TYPE'] === 'application/json') {
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



?>