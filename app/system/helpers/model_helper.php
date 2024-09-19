<?php

if(! function_exists("model_receive")){
    function model_receive(string $sent){
        return $_GET[$sent];
    }
}

if(! function_exists("model_get")){
    function model_get(string $sent){
        return model_receive($sent);
    }
}

?>