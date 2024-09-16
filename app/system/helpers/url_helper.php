<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(! function_exists("redirect_to")){
    function redirect_to(string $controller, int $delay=0){
        $YROS = &Yros::get_instance();
        foreach($_SESSION as $key=>$val){
            if(string_contains($key, $YROS->old_input_value_mask_yros)){
                unset($_SESSION[$key]);
            }
        }
        $newpost = post_data();
        foreach($newpost as $key=>$value){
            $_SESSION[$YROS->old_input_value_mask_yros.$key] = $value; 
        }
        header("refresh:$delay;url=".rootpath.$controller);
        exit;
    }
}

if(! function_exists("redirect")){
    function redirect(string $controller, int $delay=0){
        redirect_to($controller, $delay);
    }
}

if(! function_exists("back_to_previous_page")){
    function back_to_previous_page(int $delay = 0){
        $YROS = &Yros::get_instance();
        $rootpage = get_root_page();
        $previous = $YROS->get_previous_page();
        $controller = string_remove($previous, $rootpage);
        redirect_to($controller,$delay);
    }
}

if(! function_exists("get_previous_page")){
    function get_previous_page(){
        $YROS = &Yros::get_instance();
        $previous = $YROS->get_previous_page();
        return $previous;
    }
}

if(! function_exists("my_api")){
    function my_api(string $url): string{
        $exp = explode("/", $url);
        if(count($exp)>=3){
            if($exp[0]=="api"||$exp[0]=="API"){
                return rootpath.$url;
            }
            else{
                return rootpath."api/".$exp[0]."/".$exp[1];
            }
        }
        else{
            return rootpath."api/".$url;
        } 
    }
}

if(! function_exists("global_redirect")){
    function global_redirect(string $path, int $delay=0){
        header("refresh:$delay;url=".$path);
        exit;
    }
}

if(! function_exists("get_root_page")){
    function get_root_page(){
        $newroot = rootpath;
        return $newroot;
    }
}

if(! function_exists("get_project_root_url")){
    function get_project_root_url(){
        return get_root_page();
    }
}

if(! function_exists("get_main_page_url")){
    function get_main_page_url(){
        return get_root_page();
    }
}

if(! function_exists("controller")){
    function controller(string $controller){
        return rootpath.$controller;
    }
}

if(! function_exists("public_path")){
    function public_path(string $path = ""){
        if($path==""||$path==null){
            return rootpath."public/";
        }
        else{
            return rootpath."public/".$path;
        }
    }
}

if(! function_exists("route")){
    function route(string $path){
        return controller($path);
    }
}

if(! function_exists("img")){
    function img(string $img=""){
        if($img=="" || $img==null){
            return img;
        }
        else{
            return img.$img;
        }
    }
}

if(! function_exists("src")){
    function src(string $src=""){
        if($src=="" || $src==null){
            return src;
        }
        else{
            return src.$src;
        }
    }
}

if(! function_exists("assets")){
    function assets(string $assets=""){
        if($assets=="" || $assets==null){
            return assets;
        }
        else{
            return assets.$assets;
        }
    }
}

if(! function_exists("uploads")){
    function uploads(string $uploads=""){
        if($uploads=="" || $uploads==null){
            return uploads;
        }
        else{
            return uploads.$uploads;
        }
    }
}

if(! function_exists("view")){
    function view(string $view, array $data=[]){
        $YROS = &Yros::get_instance();
        $YROS->view($view, $data);
    }
}

if(! function_exists("view_error")){
    function view_error(string $view, array $data=[]){
        $YROS = &Yros::get_instance();
        $YROS->view_error($view, $data);
    }
}

if(! function_exists("view_content_page")){
    function view_content_page(string $view, array $data=[]){
        $YROS = &Yros::get_instance();
        $YROS->view_content($view, $data);
    }
}

if(! function_exists("view_include_page")){
    function view_include_page(string $view, array $data=[]){
        $YROS = &Yros::get_instance();
        $YROS->view_include($view, $data);
    }
}

if(! function_exists("include_page")){
    function include_page(string $view, array $data=[]){
        view_include_page($view, $data);
    }
}

if(! function_exists("view_page")){
    function view_page(string $view, array $data=[]){
        $YROS = &Yros::get_instance();
        $YROS->view_page($view, $data);
    }
}



//add here
?>