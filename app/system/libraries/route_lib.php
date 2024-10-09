<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Route_lib{
    public function __construct()
	{
		
	}


    public function getRoute(string $route, array $param=[], bool $showController = false){
        include "app/system/functions/myroutes.php";
        $exp = explode("?", $route);
        $route = isset($exp[0]) ? $exp[0] : "";
        $parameters = "";
        if(! empty($param)){
            if(array_has_keys($param)){
                $dtt = [];
                foreach($param as $key=>$value){
                    $dtt[] = $key."=".$value;
                }
                $param = $dtt;
            }
            $implode = implode("&", $param);
            $parameters = "?".$implode;
        }
        if(array_key_exists($route, $routes)){
            if($showController == true){
                $cont = $routes[$route];
                return rootpath.$cont.$parameters;
            }
            else{
                return rootpath.$route.$parameters;
            }
        }
        else{
            $YROS = &Yros::get_instance();
            $code = $YROS->get_random_codes();
            return rootpath."pageNotFound`$route`_`$code`_page_not_found_10052773522_mode/`$route`_pageNotFound_YrosPage10053_error_route_`$route`_not_found";
        }

    }

    public function getControllerURL(string $path, array $param=[]){
        $arr = explode("/", $path);
        $className = isset($arr[0]) ? $arr[0] : "";
        $functionName = isset($arr[1]) ? $arr[1] : "index";
        $className = ucfirst($className);
        $file = "app/controller/".$className.".php";

        $parameters = "";
        if(!empty($param)){
            if(array_has_keys($param)){
                $dtt = [];
                foreach($param as $key=>$value){
                    $dtt[] = $key."=".$value;
                }
                $param = $dtt;
            }
            $imp = implode("&", $param);
            $parameters = "?".$imp;
        }

        if(file_exists($file)){
            if(method_exists($className, $functionName)){
                return rootpath.$path.$parameters;
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