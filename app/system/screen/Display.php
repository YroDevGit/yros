<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Display{
    public function __construct()
	{
		
	}


    public function getProtocol(){
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        return $protocol;
    }

    public function getHost(){
        $host = $_SERVER['HTTP_HOST']; 
        return $host;
    }

    public function getRequestURI(){
        $requestUri = $_SERVER['REQUEST_URI']; 
        return $requestUri;
    }

    public function getRouteURL(){
        include "app/config/routes.php";
        $uri = $this->getRequestURI();
        $arr = explode("/", $uri);
        $sliced = array_slice($arr,-2);
        if(($sliced[0]==null||$sliced[0]=="") && ($sliced[1]==null||$sliced[1]=="")){
            $rootController = isset($routes['default']) ? $routes['default'] : "?";
            $classfunction = explode("/", $rootController);
            $cl = isset($classfunction[0])? $classfunction[0] : "";
            $func = isset($classfunction[1]) && $classfunction[1] !="" ? $classfunction[1] : "index";
            $ucfirst = ucfirst($cl);
            return "Route: \$route['default'], [Controller: $ucfirst.php] [class: ".$ucfirst."] [function: ".$func."]";
        }
        else{
            //echo ($sliced[1]!=null||$sliced[1]!="") ? "good" : "bad";
           if(($sliced[0]==null||$sliced[0]=="") && ($sliced[1]!=null||$sliced[1]!="")){
                $onevalue = $sliced[1];
                if(array_key_exists($onevalue, $routes)){
                    $val = $routes[$onevalue];
                    $exp = explode("/", $val);
                    $cl = isset($exp[0])? $exp[0] : "";
                    $func = isset($exp[1]) && $exp[1] !="" ? $exp[1] : "index";
                    $ucfirst = ucfirst($cl);
                    return "Route: \$route['$onevalue'], [Controller: $ucfirst.php] [class: ".$ucfirst."] [function: ".$func."]";
                }
                else{
                    $exp = explode("/", $sliced[1]);
                    $class = isset($exp[0]) ? $exp[0] : "";
                    $ucfirst = ucfirst($class);
                    return "Route: Not set, [Controller: $ucfirst.php] [class: ".$ucfirst."] [function: index]";
                }
           }
           else if(($sliced[1]==null||$sliced[1]=="") && ($sliced[0]!=null||$sliced[0]!="")){
                $onevalue = $sliced[0];
                if(array_key_exists($onevalue, $routes)){
                    $val = $routes[$onevalue];
                    $exp = explode("/", $val);
                    $cl = isset($exp[0])? $exp[0] : "";
                    $func = isset($exp[1]) && $exp[1] !="" ? $exp[1] : "index";
                    $ucfirst = ucfirst($cl);
                    return "Route: \$route['$onevalue'], [Controller: $ucfirst.php] [class: ".$ucfirst."] [function: ".$func."]";
                }
                else{
                    $exp = explode("/", $sliced[0]);
                    $class = isset($exp[0]) ? $exp[0] : "";
                    $ucfirst = ucfirst($class);
                    return "Route: Not set, [Controller: $ucfirst.php] [class: ".$ucfirst."] [function: index]";
                }
            }
           else if(($sliced[0]!=null||$sliced[0]!="") && ($sliced[1]!=null||$sliced[1]!="")){
                $class = $sliced[0];
                $func = $sliced[1];
                $ucfirst = ucfirst($class);
                $hasRoute = "";
                foreach($routes as $rts=>$r){
                    $getr =  $routes[$rts];
                    if($getr == $class."/".$func || $getr == $class."/".$func."/"){
                        $hasRoute =  $rts;
                    }
                    
                }
                if($hasRoute==""){
                    return "Route: Not set, [Controller: $ucfirst.php] [class: ".$ucfirst."] [function: ".$func."]";
                }
                else{
                    return "Route: Not called \$route['$hasRoute'], [Controller: $ucfirst.php] [class: ".$ucfirst."] [function: ".$func."]";
                }
                
           }
           else{
            return "Error: Can't tract routes";
           }
        }
       
        //print_r($sliced);
        //return $sliced;
    }

    public function display_route(){
        include "app/config/settings.php";
        if($app_settings['page_guide']){
        ?>
        <div class="yros-screen-routes-display" align="center">
            <div>
                <?=$this->getRouteURL()?>
            </div>
        </div>
        
        <style>
            .yros-screen-routes-display{
                display: block;
                position: fixed;
                padding: 5px;
                width: 97%;
                bottom: 10;
                z-index: 1000000;
                border-radius: 2px;
                box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 1px 3px 1px;
                text-align: center;
                justify-content: center;
                justify-self: center;
                cursor: pointer;
                background-color: white;
                left: 50%;
                right: 50%;
                font-family: monospace;
                font-size: 12px;
            }
            

        </style>
        <?php
        }
    }

}

?>