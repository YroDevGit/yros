<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(! function_exists("json_response")){
    function json_response($arr, bool $direct=true){
        $YROS = &Yros::get_instance();
        if($direct==true){
            if($YROS->arraylib->isJsonArray($arr)){
                echo $arr;
            }
            else{
                echo json_encode($arr);
            }
            
        }
        else{
            if($YROS->arraylib->isJsonArray($arr)){
                return $arr;
            }
            else{
                return json_encode($arr);
            }
        }
    }
}

if(! function_exists("json_response_data")){
    function json_response_data(int $code, string $status, string $message, array $data){
        json_response(["code"=>$code, "status"=>$status, "message"=>$message, "data"=>$data], true);
    }
}

if(! function_exists("post_api")){
    function post_api(string $url, array $headers=[], array $data=[], string $type="php"){
        $YROS = &Yros::get_instance();
        return $YROS->apilib->post_api($url, $headers, $data, $type);
    }
}

if(! function_exists("fetch_api")){
    function fetch_api(string $url){
        $YROS = &Yros::get_instance();
        return $YROS->apilib->fetch_api($url);
    }
}

if(! function_exists("my_post_api")){
    function my_post_api(string $apiurl,$data=[], $type="php"){
        include "app/config/api_config.php";
        $headers = ["api_key:".$api_config['api_key'][0], "yros_key:".$api_config['yros_key'][0]];
        $apilink = isset($api_config['local_api_link']) ? $api_config['local_api_link'] : "";
        if($apilink=="" || $apilink==null){
            return post_api(get_root_page()."api/".$apiurl, $headers, $data, $type);
        }
        else{
            return post_api($api_config['local_api_link'].$apiurl, $headers, $data, $type);
        }
        
        //return post_api($api_config['local_api_link'].$apiurl, $headers, $data, $type);
    }
}

if(! function_exists("my_fetch_api")){
    function my_fetch_api(string $url){
        return fetch_api(my_api($url));
    }
}



?>