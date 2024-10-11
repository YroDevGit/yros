<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Route_lib{
    public function __construct()
	{
		
	}

    public function convArrayToStringPath(array $route){
        if(array_has_keys($route)){
            $fk = array_key_first($route);
            $fv = $route[$fk];
            $route = $fk."/".$fv;
        }else{
            $str = isset($route[0]) ? $route[0] : "";
            if($str == ""){
                $route = $str;
            }
            else{
                $xpl = explode("/", $str);
                $cc = isset($xpl[0]) ? $xpl[0] : "";
                $ff = isset($xpl[1]) ? $xpl[1] : "index";
                $route = $cc."/".$ff;
            }
        }
        return $route;
    }


    public function getRoute(string|array $route, array $param=[],bool $secure = false, bool $showController = false){
        include "app/system/functions/myroutes.php";
        if(is_array($route)){
            $route = isset($route[0]) ? $route[0] : "default";
        }
        $exp = explode("?", $route);
        $route = isset($exp[0]) ? $exp[0] : "";
        $parameters = "";
        if(! empty($param)){
            if(array_has_keys($param)){
                $dtt = [];
                if($secure){
                    foreach($param as $key=>$value){
                        $dtt[] = $key."=".encrypt($value);
                    }
                }else{
                    foreach($param as $key=>$value){
                        $dtt[] = $key."=".$value;
                    }
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


    public function getPathUrl(string|array $path, array $parameters = [], bool $secure = false){
        if(is_array($path)){
            $path = $this->convArrayToStringPath($path);
        }
        $par = "";
        if(! empty($parameters)){
            if(array_has_keys($parameters)){
                $dtt = [];
                if($secure){
                    foreach($parameters as $key=>$value){
                        $dtt[] = $key."=".encrypt($value);
                    }
                }else{
                    foreach($parameters as $key=>$value){
                        $dtt[] = $key."=".$value;
                    }
                }
                $parameters = $dtt;
            }
            $imp = implode("&", $parameters);
            $par = "?".$imp;
            return rootpath.$path.$par;
        }
        else{
            return rootpath.$path;
        }
    }

    public function getControllerURL(string|array $path, array $param=[], bool $secure = false){
        if(is_array($path)){
            $path = $this->convArrayToStringPath($path);
        }
        $arr = explode("/", $path);
        $className = isset($arr[0]) ? $arr[0] : "";
        $functionName = isset($arr[1]) ? $arr[1] : "index";
        $className = ucfirst($className);
        $file = "app/controller/".$className.".php";

        $parameters = "";
        if(!empty($param)){
            if(array_has_keys($param)){
                $dtt = [];
                if($secure){
                    foreach($param as $key=>$value){
                        $dtt[] = $key."=".encrypt($value);
                    }
                }else{
                    foreach($param as $key=>$value){
                        $dtt[] = $key."=".$value;
                    }
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