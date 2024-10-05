<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Route_lib{
    public function __construct()
	{
		
	}


    public function getRoute(string $route){
        include "app/system/functions/myroutes.php";
        if(array_key_exists($route, $routes)){
            return controller($route);
        }
        else{
            trigger_error(display_error("Route name: '$route' not found.!"));
        }

    }

    public function getControllerURL(string $path){
        $arr = explode("/", $path);
        $className = isset($arr[0]) ? $arr[0] : "?";
        $functionName = isset($arr[1]) ? $arr[1] : "index";
        $className = ucfirst($className);
        $file = "app/controller/".$className.".php";

        if(file_exists($file)){
            if(method_exists($className, $functionName)){
                return rootpath.$path;
            }
            else{
                return rootpath.$className."/".$functionName;
            }
        }
        else{
            return rootpath.$className."/".$functionName;
        }
    }
}
    ?>