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


if(! function_exists("auto_rename")){
    function auto_rename(){
        $YROS = &Yros::get_instance();
        return $YROS->filelib->auto_rename_method();
    }
}

if(! defined("auto_rename")){
    define("auto_rename", auto_rename());
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

if(! function_exists("file_size")){
    function file_size(string $inputname){
        return get_file_size($inputname);
    }
}

if(! function_exists("get_file")){
    function get_file(string $inputname){
        $YROS = &Yros::get_instance();
        return $YROS->filelib->get_file($inputname);
    }
}

if(! function_exists("get_file_name")){
    function get_file_name( string $inputname){
        $YROS = &Yros::get_instance();
        return $YROS->filelib->get_file_name($inputname);
    }
}

if(! function_exists("file_name")){
    function file_name(string $inputname){
        return get_file_name($inputname);
    }
}

if(! function_exists("get_file_path")){
    function get_file_path(string $inputname){
        $YROS = &Yros::get_instance();
        return $YROS->filelib->get_file_path($inputname);
    }
}

if(! function_exists("file_path")){
    function file_path(string $inputname){
        return get_file_path($inputname);
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

if(! function_exists("set_favicon")){
    function set_favicon(string $path){
        return '<link rel="shortcut icon" href="'.$path.'" type="image/x-icon">';
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
                $logfile =  "public/logs/sql_logs/". $filename;
                $formatted_message = "[" . date('Y-m-d H:i:s') . "] " . $message . PHP_EOL;
                file_put_contents($logfile, $formatted_message, FILE_APPEND);
            }  
    }
}

if(! function_exists("write_view_logs")){
    function write_view_logs(string $path, string $view){
        $filename = "sql_".date("Y-M-d")."_y.log";
        $logfile = "public/logs/view_logs/".$filename;
        $message = "".date('Y-m-d H:i:s').": View: [".$view."] called @ Controller: [".$path."] ". PHP_EOL;
        file_put_contents($logfile, $message, FILE_APPEND);
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
    function encrypt(string|float|int $data, string $key = null){
        $YROS = &Yros::get_instance();
        return $YROS->yrossecure->encrypt($data, $key);
    }
}


if(! function_exists("decrypt")){
    function decrypt(string|float|int $data, string $key = null){
        $YROS = &Yros::get_instance();
        return $YROS->yrossecure->decrypt($data, $key);
    }
}

if(! function_exists("views_tracked_logs")){
    function views_tracked_logs(string $contains=""):array{
        $YROS = &Yros::get_instance();
        return $YROS->get_view_logs_inside_json($contains);
    }
}

if(! function_exists("display_views_tracked_logs")){
    function display_views_tracked_logs(string $contains="", string $seperator = "<br>"):void{
        $arr = views_tracked_logs($contains);
        if(empty($arr)){
            echo "<b style='color:red;'>No views tracked.!</b>";
        }
        else{
            foreach($arr as $key => $value){
                $vw = $value['view'];
                $cnt = $value['controller'];
                $pth = $value['path'];
                echo  "view:[$vw], controller:[$cnt], path:[$pth]".$seperator;
            }
        }
    }
}

if(! function_exists("string_has_symbols")){
    function string_has_symbols(string $string){
        /**Check if string has symbols */
        if(! preg_match('/^[a-zA-Z0-9\s]*$/', $string)){
            return true;
        }
        else{
            return false;
        }
    }
}

if(! function_exists("string_has_no_symbols")){
    function string_has_no_symbols(string $string){
        /**Check if string has no symbols */
        if(preg_match('/^[a-zA-Z0-9\s]*$/', $string)){
            return true;
        }
        else{
            return false;
        }
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

if(! function_exists("string_value")){
    function string_value(&$string, string $default=""):string{
        return isset($string) ? $string : $default;
    }
}

if(! function_exists("int_value")){
    function int_value(&$int, int $default = 0):int{
        return isset($int) ? $int : $default;
    }
}

if(! function_exists("float_value")){
    function float_value(&$float, float $default = 0):float{
        return isset($float) ? $float : $default;
    }
}

if(! function_exists("array_value")){
    function array_value(&$array, array $default):array{
        return isset($array) ? $array : $default;
    }
}

if(! function_exists("object_value")){
    function object_value(&$object, $default=null){
        return isset($object) ? $object : $default;
    }
}

if(! function_exists("get_previous_path")){
    function get_previous_path(){
        return isset($_SESSION['previous_yros_page_1005_yrosframework']) ? $_SESSION['previous_yros_page_1005_yrosframework'] : "";
    }
}

if(! function_exists("get_current_path")){
    function get_current_path(){
        return isset($_SESSION['current_yros_page_1005_yrosframework']) ? $_SESSION['current_yros_page_1005_yrosframework'] : "";
    }
}

if(! function_exists("encrypt_password")){
    function encrypt_password($password){
        return password_hash($password, PASSWORD_DEFAULT);
    }
}






?>