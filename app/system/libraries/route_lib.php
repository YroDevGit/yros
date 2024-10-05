<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Route_lib{
    public function __construct()
	{
		
	}


    public function getRoute(string $route, bool $showController = false){
        include "app/system/functions/myroutes.php";
        if(array_key_exists($route, $routes)){
            if($showController == true){
                $cont = $routes[$route];
                return rootpath.$cont;
            }
            else{
                return rootpath.$route;
            }
        }
        else{
            $YROS = &Yros::get_instance();
            $code = $YROS->get_random_codes();
            return rootpath."pageNotFound`$route`_`$code`_page_not_found_10052773522_mode/`$route`_pageNotFound_YrosPage10053_error_route_`$route`_not_found";
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