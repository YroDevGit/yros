<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(! function_exists("homepage")){
    function homepage(){
        $YROS = new Yros();
        return $YROS->yros_homepage();
    }
}

if(! function_exists("upload_file")){
    function upload_file(string $inputname, string $rename){
        $YROS = new Yros();
        return $YROS->filelib->upload($inputname, $rename);
    }
}

if(! defined("auto_rename")){
    $YROS = new Yros();
    define("auto_rename", $YROS->filelib->auto_rename_method());
}

if(! function_exists("delete_file")){
    function delete_file(string $filepath){
        $YROS = new Yros();
        return $YROS->filelib->delete($filepath);
    }
}

if(! function_exists("get_file_size")){
    function get_file_size($inputname){
        $YROS = new Yros();
        return $YROS->filelib->get_file_size($inputname);
    }
}

if(! function_exists("get_file")){
    function get_file($inputname){
        $YROS = new Yros();
        return $YROS->filelib->get_file($inputname);
    }
}

if(! function_exists("get_file_name")){
    function get_file_name($inputname){
        $YROS = new Yros();
        return $YROS->filelib->get_file_name($inputname);
    }
}

if(! function_exists("get_file_path")){
    function get_file_path($inputname){
        $YROS = new Yros();
        return $YROS->filelib->get_file_path($inputname);
    }
}


?>