<?php

if(! function_exists("filter")){
    function filter(string $sent){
        $YROS = &Yros::get_instance();
        return $YROS->modellib->receivedData[$sent];
    }
}

if(! function_exists("receive")){
    function receive(string $sent){
        return filter($sent);
    }
}

if(! function_exists("all_filters")){
    function all_filters():array{
        $YROS = &Yros::get_instance();
        return $YROS->modellib->receivedData;
    }
}

if(! function_exists("all_recieved")){
    function all_recieved():array{
        return all_filters();
    }
}



?>