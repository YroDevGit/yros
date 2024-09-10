<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(! function_exists("redirect_to")){
    function redirect_to(string $controller, int $delay=0){
        header("refresh:$delay;url=".rootpath.$controller);
    }
}

if(! function_exists("redirect")){
    function redirect(string $controller, int $delay=0){
        redirect_to($controller, $delay);
    }
}

if(! function_exists("my_api")){
    function my_api(string $url){
        return rootpath."api/".$url;
    }
}


if(! function_exists("global_redirect")){
    function global_redirect(string $path, int $delay=0){
        header("refresh:$delay;url=".$path);
    }
}

if(! function_exists("controller")){
    function controller(string $controller){
        return rootpath.$controller;
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
        $YROS = new Yros();
        $YROS->view($view, $data);
    }
}

if(! function_exists("view_error")){
    function view_error(string $view, array $data=[]){
        $YROS = new Yros();
        $YROS->view_error($view, $data);
    }
}

if(! function_exists("view_content")){
    function view_content(string $view, array $data=[]){
        $YROS = new Yros();
        $YROS->view_content($view, $data);
    }
}

if(! function_exists("view_include")){
    function view_include(string $view, array $data=[]){
        $YROS = new Yros();
        $YROS->view_include($view, $data);
    }
}

if(! function_exists("view_page")){
    function view_page(string $view, array $data=[]){
        $YROS = new Yros();
        $YROS->view_page($view, $data);
    }
}

if(! function_exists("view_partial")){
    function view_partial(string $view, array $data=[]){
        $YROS = new Yros();
        $YROS->view_partial($view, $data);
    }
}


?>