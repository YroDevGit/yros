<?php
/**
 * Welcome to Yros PHP framework
 * Created by Tyrone Limen Malocon
 * Enjoy Coding.
 * @author YRO <tyronemalocon@gmail.com>
 * 
 */
require_once "app/config/settings.php";
function customErrorHandler($errno, $errstr, $errfile, $errline) {
    $logMessage = "[" . date("Y-m-d H:i:s") . "] Error: [$errno] $errstr - $errfile:$errline\n";
    $filename = date("Y-M-d")."_yros.log";
    error_log($logMessage, 3,__DIR__."/app/system/logs/".$filename); // Log errors to a specific file
}
if($app_settings['error_log']){
set_error_handler("customErrorHandler");
}

require_once "app/system/Yros.php";
require_once "app/system/Api.php";
require_once "app/system/extras/database.php";
require_once "app/config/routes.php";


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
       
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
 
        $host = $_SERVER['HTTP_HOST'];

        $path = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

        $root = $protocol . $host ;
        $rt =  $root."/";
        return $rt;
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
    define("assets", getProjectRoot()."ui/public/assets/");
}

if(! defined("src")){
    define("src", getProjectRoot()."ui/public/src/");
}
if(! defined("uploads")){
    define("uploads", getProjectRoot()."ui/public/uploads/");
}

if(! defined("img")){
    define("img", getProjectRoot()."public/img/");
}
if(! defined("img")){
    define("img", getProjectRoot()."public/img/");
}
if(! defined("home")){
    define("home", getProjectRoot()."public/home/");
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

require_once "app/config/routes.php";

if(empty($routes)){
    die("Route data not found.!");
    exit;
}

if(! isset($routes['default'])){
    die("No default route");
    exit;
}

function routing_controller($urls){
    include "app/config/routes.php";
    $url = isset($urls) ? $urls :$routes['default'];
    $url = rtrim($url, '/');
    $url = explode('/', $url);
    if($url[0]=="API"||$url[0]=="api"||$url[0]=="Api"){
        if(! isset($url[1])){
            die("No api file found.!");
            exit;
        }
        $className = ucfirst($url[1]);
        $methodName = isset($url[2]) ? $url[2] : 'index';

        $classFile = 'app/api/' . $className . '.php';

        if (file_exists($classFile)) {
            include $classFile;

            if (class_exists($className)) {
                $classInstance = new $className();

                if (method_exists($classInstance, $methodName)) {
                    $classInstance->$methodName();
                } else {
                    echo "Method $methodName not found.";
                }
            } else {
                echo "Class $className not found.";
            }
        } else {
            echo "File $className.php not found.";
        }
    }
    else{
        $className = ucfirst($url[0]);
        $methodName = isset($url[1]) ? $url[1] : 'index';

        $classFile = 'app/controller/' . $className . '.php';

        if (file_exists($classFile)) {
            include $classFile;

            if (class_exists($className)) {
                $classInstance = new $className();

                if (method_exists($classInstance, $methodName)) {
                    $classInstance->$methodName();
                } else {
                    header("refresh:0;url=".$routes["page_not_found"]."?err=method&class=$className&method=$methodName");
                }
            } else {
                header("refresh:0; url=".$routes["page_not_found"]."?err=class&class=$className&method=$methodName");
            }
        } else {
            header("refresh:0;url=".$routes["page_not_found"]."?err=class&class=$className&method=$methodName");
        }
    }
}
    
    $_url = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    
    $_all = null;
    if($_SERVER['HTTP_HOST'] === "localhost"){
        $str = explode("/", $_url);
        $col1= isset($str[1]) ? $str[1]: "";
        $col1 = strtoupper($col1);
        if($col1=="API"){
            $class = isset($str[2]) ? $str[2]: "";
            $method = isset($str[3]) ? $str[3] : "";
            if($class=="" && $method==""){
                $_all = "";
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
                $_all = $class."/".$method;
            }
        }
    }
    else{
        $_all = $_url;
    }
    $_urls = empty($_all) ? $routes['default'] : $_all;
    if(array_key_exists($_urls, $routes)){
        $val = $routes[$_urls];
        routing_controller($val);
    }
    else{
        routing_controller($_urls);
    }

?>

