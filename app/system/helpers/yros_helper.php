<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(! function_exists("homepage")){
    function homepage(){
        $YROS = &Yros::get_instance();
        return $YROS->yros_homepage();
    }
}

if(! function_exists("upload_file")){
    function upload_file(string $inputname, string $rename, string $upload_folder = ""){
        $YROS = &Yros::get_instance();
        return $YROS->filelib->upload($inputname, $rename, $upload_folder);
    }
}

if(! function_exists("download_file")){
    function download_file(string $path, bool $uploads_folder=true){
        $YROS = &Yros::get_instance();
        $YROS->filelib->download($path, $uploads_folder);
    }
}


if(! defined("auto_rename")){
    $YROS = &Yros::get_instance();
    define("auto_rename", $YROS->filelib->auto_rename_method());
}

if(! function_exists("delete_file")){
    function delete_file(string $filepath){
        $YROS = &Yros::get_instance();
        return $YROS->filelib->delete($filepath);
    }
}

if(! function_exists("get_file_size")){
    function get_file_size($inputname){
        $YROS = &Yros::get_instance();
        return $YROS->filelib->get_file_size($inputname);
    }
}

if(! function_exists("get_file")){
    function get_file($inputname){
        $YROS = &Yros::get_instance();
        return $YROS->filelib->get_file($inputname);
    }
}

if(! function_exists("get_file_name")){
    function get_file_name($inputname){
        $YROS = &Yros::get_instance();
        return $YROS->filelib->get_file_name($inputname);
    }
}

if(! function_exists("get_file_path")){
    function get_file_path($inputname){
        $YROS = &Yros::get_instance();
        return $YROS->filelib->get_file_path($inputname);
    }
}


if(! function_exists("display")){
    function display($object){
        if(is_array($object)){
            print_r($object);
        }
        else{
            echo $object;
        }
    }
}

if(! function_exists("string_contains")){
    function string_contains(string $string, string $contains){
        if(strpos($string, $contains) !== false){
            return true;
        }
        else{
            return false;
        }
    }
}
if(! function_exists("string_remove")){
    function string_remove(string $string, string $remove){
        return str_replace($remove, '', $string);
    }
}

if(! function_exists("string_replace")){
    function string_replace(string $string, string $toreplace,string $replacer){
        return str_replace($toreplace,$replacer, $string);
    }
}


if(! function_exists("form_open")){
    function form_open(string $route){
        $controller = route($route);
       return '<form method="post" enctype="multipart/form-data" action="'.$controller.'">';
    }
}

if(! function_exists("form_close")){
    function form_close(){
        return "</form>";
    }
}

if(! function_exists("array_append")){
    function array_append(&$array, $element){
        if(! in_array($array, $element)){
            array_push($array, $element);
        }
    }
}

if(! function_exists("write_sql_log")){
    function write_sql_log($message){
            include "app/config/settings.php";
            $setting = $app_settings['save_db_logs'];
            if($setting==true){
                $filename = "sql_".date("Y-M-d")."_yros.log";
                $logfile =  "app/system/logs/sql_logs/". $filename;
                $formatted_message = "[" . date('Y-m-d H:i:s') . "] " . $message . PHP_EOL;
                file_put_contents($logfile, $formatted_message, FILE_APPEND);
            }  
    }
}

if(! function_exists("has_internet_connection")){
    function has_internet_connection($url = "http://www.google.com") {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); 
        curl_setopt($ch, CURLOPT_HEADER, true); 
        curl_setopt($ch, CURLOPT_NOBODY, true); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        $data = curl_exec($ch);
        if ($data) {
            curl_close($ch);
            return true;
        } else {
            curl_close($ch);
            return false;
        }
    }
}

if(! function_exists("encrypt")){
    function encrypt(string|float|int $data){
        $YROS = &Yros::get_instance();
        return $YROS->yrossecure->encrypt($data);
    }
}


if(! function_exists("decrypt")){
    function decrypt(string|float|int $data){
        $YROS = &Yros::get_instance();
        return $YROS->yrossecure->decrypt($data);
    }
}

if(! function_exists('function_is_called')){
    function function_is_called(string $functionName) {
        $backtrace = debug_backtrace();
        
        foreach ($backtrace as $trace) {
            if (isset($trace['function']) && $trace['function'] === $functionName) {
                return true;
            }
        }
        return false;
    }
}





?>