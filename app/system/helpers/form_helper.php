<?php
if(! function_exists('escapeString')){
    function escapeString($input) {
        $YROS =& Yros::get_instance();
        return $YROS->db->pdo->quote($input);
    }
}


if(! function_exists('post_data')){
    function post_data() {
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
            if(in_array($inputname, $post)){
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



?>