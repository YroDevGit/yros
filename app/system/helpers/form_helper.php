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

if(! function_exists("post_exist")){
    function post_exist(string $postname):bool{
        $pdata = post_data();
        if(array_key_exists($postname, $pdata)){
            return true;
        }
        else{
            return false;
        }
    }
}

if(! function_exists("has_post_data")){
    function has_post_data():bool{
        /** Bool: check if there is a form/post submitted */
        $data = post_data();
        if(empty($data)){
            return false;
        }
        else{
            return true;
        }
    }
}

if(! function_exists("form_input_exist")){
    function form_input_exist(string $inputname):bool{
        /** Bool: check if the form input exist */
        return post_exist($inputname);
    }
}

if(! function_exists("form_checkbox_checked")){
    function form_checkbox_checked(string $cboxName):bool{
        /** Bool: check if the form checkbox is checked/selected */
        return post_exist($cboxName);
    }
}

if(! function_exists("form_radioBTN_selected")){
    function form_radio_selected(string $radioName):bool{
        /** Bool: check if the form radio button is checked/selected */
        return post_exist($radioName);
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
            return null;
        }
        else{
            if(value_in_array($inputname, $post)){
                return $post[$inputname];
            }
            else{
                return null;
            }
        }
    }
}



if(! function_exists("display_error")){
    function display_error(string $message){
        $str = new Exception($message);
        $arr = explode("#", $str);
        $err = [];
        foreach($arr as $r){
            if (strpos($r, '\app\system\helpers') !== false) {
                
            }elseif(strpos($r, '\app\system') !== false){

            }
            else{
                $err[] = $r;
            }
        }
        $ff = implode("\n", $err);
        $final = "\n\n".date("Y-m-d H:i:s")." ERROR:: ".$message." ".$ff." ";
        return $final;
    }
}

if(! function_exists("show_error")){
    function show_error(string $error){
        trigger_error(display_error($error));
        exit;
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

if(! function_exists("get")){
    function get(string $url, bool $secure = false){
        $get = $_GET;
        if(empty($get)){
            return null;
        }
        else{
            if(array_key_exists($url, $get)){
                if($secure){
                    return decrypt($_GET[$url]);
                }else{
                    return $_GET[$url];
                }
            }
            else{
                return null;
            }
        }
    }
}

if(! function_exists("reset_value")){
    function reset_value(array|int|string|float &$data){
        if(is_array($data)){
            $data = [];
        }
        if(is_string($data)){
            $data = "";
        }
        if(is_integer($data)){
            $data = 0;
        }
        if(is_float($data)){
            $data = 0;
        }
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
    function file_input(string $inputname):array{
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
    function validate_input(string $inputname, string $label, string $validation, int $type = 1){
        $YROS = &Yros::get_instance();
        $YROS->validationlib->validate_input($inputname, $label,$validation, $type);
    }
}


if(! function_exists("set_validation")){
    function set_validation(string $inputname, string $label, string $validation, int $type = 1){
        validate_input($inputname, $label, $validation, $type);
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

if(! function_exists("input_error")){
    function input_error(string $input){
        return get_input_error($input);
    }
}

if(! function_exists("get_all_input_error")){
    function get_all_input_error():array{
        $YROS = &Yros::get_instance();
        return $YROS->validationlib->get_all_input_error();
    }
}

if(! function_exists("has_input_errors")){
    function has_input_errors():bool{
        $data = get_all_input_error();
        if(empty($data)){
            return false;
        }
        else{
            return true;
        }
    }
}

if(! function_exists("old_value")){
    function old_value(string $input){
        $YROS = &Yros::get_instance();
        $mask = $YROS->old_input_value_mask_yros;
        $inputstorage = $YROS->inputvaluesstorage;
        if(isset($inputstorage[$mask.$input])){
            $var = $inputstorage[$mask.$input];
            unset($inputstorage[$mask.$input]);
            return $var;
        }
        else{
            return "";
        }
    }
}


if(! function_exists("saved_value")){
    function saved_value(string $input){
        return old_value($input);
    }
}

if(! function_exists("input_value")){
    function input_value(string $input){
        // same with saved_value($input);
        return old_value($input);
    }
}





?>