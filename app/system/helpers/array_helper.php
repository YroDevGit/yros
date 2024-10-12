<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

if(! function_exists("json_to_php_array")){
    function json_to_php_array($json_array){
        $YROS = &Yros::get_instance();
        if($YROS->arraylib->isJsonArray($json_array)){
            return json_decode($json_array, true);
        }else{  
            return $json_array;
        }
    }
}

if(! function_exists("php_to_json_array")){
    function php_to_json_array(array $php_array){
        $YROS = &Yros::get_instance();
        if($YROS->arraylib->isJsonArray($php_array)){
            return $php_array;
        }
        else{
            return json_encode($php_array);
        }
    }
}

if(! function_exists("array_is_multidimensional")){
    function array_is_multidimensional(array $arr){
        foreach ($arr as $element) {
            if (is_array($element)) {
                return true; 
            }
        }
        return false;
    }
}

if(! function_exists("array_has_rows")){
    function array_has_rows(array $array){
        return isset($array[0]) && is_array($array[0]);
    }
}

if(! function_exists("array_has_keys")){
    function array_has_keys($array){
        return array_keys($array) !== range(0, count($array) - 1);
    }
}

if(! function_exists("array_contains")){
    function array_contains(array $array, $contains){
        if(array_is_multidimensional($array)){
            return array_key_exists($contains, $array);
        }
        else{
            return in_array($contains, $array);
        }
    }
}

if(! function_exists("fetch_array")){
    function fetch_array(array &$array){
        $YROS = &Yros::get_instance();
        return $YROS->arraylib->fetch_array($array) ;
    }
}

?>