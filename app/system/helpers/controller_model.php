<?php


if(! function_exists("model_fetch")){
    function model_fetch(string $model_function, array|string $send_data){
        $YROS = &Yros::get_instance();
        if(is_string($send_data)){
            return $YROS->modellib->model_get($model_function, $send_data);
        }
        else{
            return $YROS->modellib->model_post($model_function, $send_data);
        }
    }
}

?>