<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

if(! function_exists("json_to_php_array")){
    function json_to_php_array($json_array){
        $YROS = new Yros();
        if($YROS->arraylib->isJsonArray($json_array)){
            return json_decode($json_array, true);
        }else{  
            return $json_array;
        }
    }
}

if(! function_exists("php_to_json_array")){
    function php_to_json_array(array $php_array){
        $YROS = new Yros();
        if($YROS->arraylib->isJsonArray($php_array)){
            return $php_array;
        }
        else{
            return json_encode($php_array);
        }
    }
}

?>