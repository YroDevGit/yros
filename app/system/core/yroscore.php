<?php

function customErrorHandler($errno, $errstr, $errfile, $errline) {
    $logMessage = "[" . date("Y-m-d H:i:s") . "] Error: [$errno] $errstr - $errfile:$errline\n";
    $filename = date("Y-M-d")."_yros.log";
    error_log($logMessage, 3,"public/logs/error_logs/".$filename); // Log errors to a specific file
}
if($app_settings['error_log']){
    set_error_handler("customErrorHandler");
}

require_once "app/system/Yros.php";

require_once "app/system/Model.php";
require_once "app/system/extras/database.php";
require_once "app/system/functions/myroutes.php";


if(! function_exists("define_value")){
    function define_value($title, $value){
        if(! defined($title)){
            define($title, $value);
        }
    }
}

require_once "app/config/definitions.php";

if(! function_exists("getProjectRoot")){
    function getProjectRoot() {
        include "app/config/settings.php";
        $given_root = strtolower($app_settings['project_root_url']);
        if($given_root=="" ||$given_root==null){
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    
            $host = $_SERVER['HTTP_HOST'];

            $path = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            $rt = null;
            if($host === "localhost"){
                $_url = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
                $str = explode("/", $_url);
                $root = $protocol . $host."/".$str[0] ;
                $rt =  $root."/";
            }
            else{
                $root = $protocol . $host ;
                $rt =  $root."/";
            }
            
            return $rt;
        }
        else{
            $lastChar = substr($given_root, -1);
            if($lastChar=="/"){
                return $given_root;
            }
            else{
                return $given_root."/";
            }     
        }
    }
}

if(! defined("BASEPATH")){
    define("BASEPATH", getProjectRoot());
}

if(! defined("HOMEPAGE")){
    define("HOMEPAGE", getProjectRoot());
}

if(! defined("rootpath")){
    define("rootpath", getProjectRoot());
}

if(! defined("assets")){
    define("assets", getProjectRoot()."public/assets");
}

if(! defined("src")){
    define("src", getProjectRoot()."public/src");
}
if(! defined("uploads")){
    define("uploads", getProjectRoot()."public/uploads");
}

if(! defined("img")){
    define("img", getProjectRoot()."public/img");
}

if(! defined("home")){
    define("home", getProjectRoot()."public/home");
}



function getRoute(string $router, callable $func){
    include_once "app/system/core/frnevt.php";
    if(isset($_GET['url'])){
        if($router==$_GET['url']){
            $func();
            exit;
        }
    }
}

require_once "app/system/functions/myroutes.php";

if(empty($routes)){
    die("Route data not found.!");
}

if(! isset($routes['default'])){
    die("No default route");
}

    require_once "app/system/functions/routing.php";
    
    $_url = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    
    $_all = null;
    if($_SERVER['HTTP_HOST'] === "localhost"){
        $str = explode("/", $_url);
        $col1= isset($str[1]) ? $str[1]: "";
        $col1 = strtoupper($col1);
        if($col1=="API"){
            $class = isset($str[2]) ? $str[2]: "";
            $method = isset($str[3]) ? $str[3] : "";
            if($class=="" || $method==""){
                echo  json_encode(["code"=>404, "status"=>"Page Not Found", "message"=>"API:: API url is not valid.!"]);exit;
            }
            else{
                $_all = "api/".$class."/".$method;
            }
        }
        else{
            $class = isset($str[1]) ? $str[1]: "";
            $method = isset($str[2]) ? $str[2] : "";
            if($class=="" && $method==""){
                $_all = "";
            }
            else{
                if($method==""){
                    $_all = $class;
                }
                else{
                    $_all = $class."/".$method;
                }
            }
        }
    }
    else{
        $_all = $_url;
    }
 


    $_urls = empty($_all) ? $routes['default'] : $_all;
   
    if(array_key_exists($_urls, $routes)){
        $val = $routes[$_urls];
        routing_controller($val, true);
    }
    else{
        routing_controller($_urls, false);
    }


?>