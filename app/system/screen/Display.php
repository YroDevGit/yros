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
        include "app/system/functions/myroutes.php";
        $uri = $this->getRequestURI();
        $arr = explode("/", $uri);
        $sliced = array_slice($arr,-2);
        if(($sliced[0]==null||$sliced[0]=="") && ($sliced[1]==null||$sliced[1]=="")){
            $rootController = isset($routes['default']) ? $routes['default'] : "?";
            $classfunction = explode("/", $rootController);
            $cl = isset($classfunction[0])? $classfunction[0] : "";
            $func = isset($classfunction[1]) && $classfunction[1] !="" ? $classfunction[1] : "index";
            $ucfirst = ucfirst($cl);
            return "Route: [<span style='color:#009d80;'>default</span>], [Controller: <span style='color:#d204d2;'>$ucfirst.php</span>] [Class: <span style='color:#e64d0a;'>$ucfirst</span>] [Function: <span style='color:#339a00'>$func</span>]";
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
                    return "Route: [<span style='color:#009d80;'>$onevalue</span>], [Controller: <span style='color:#d204d2;'>$ucfirst.php</span>] [Class: <span style='color:#e64d0a;'>$ucfirst</span>] [Function: <span style='color:#339a00'>$func</span>]";
                }
                else{
                    $exp = explode("/", $sliced[1]);
                    $class = isset($exp[0]) ? $exp[0] : "";
                    $ucfirst = ucfirst($class);
                    $hasRoute = "";
                    foreach($routes as $rts=>$rtv){
                        $getr = $routes[$rts];
                        if(strtolower($getr)==strtolower($class) || strtolower($getr)==strtolower($class)."/" || strtolower($getr)==strtolower($class)."/index"){
                            $hasRoute = $rts;
                        }
                    }
                    if($rts==""){
                        return "Route: Not set, [Controller: <span style='color:#d204d2;'>$ucfirst.php</span>] [Class: <span style='color:#e64d0a;'>$ucfirst</span>] [Function: <span style='color:#339a00'>index</span>]";
                    }
                    else{
                        return "Route: Not called [<span style='color:#009d80;'>$rts</span>], [Controller: <span style='color:#d204d2;'>$ucfirst.php</span>] [Class: <span style='color:#e64d0a;'>$ucfirst</span>] [Function: <span style='color:#339a00'>index</span>]";
                    }
                    
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
                    return "Route: [<span style='color:#009d80;'>$onevalue</span>], [Controller: <span style='color:#d204d2;'>$ucfirst.php</span>] [Class: <span style='color:#e64d0a;'>$ucfirst</span>] [Function: <span style='color:#339a00'>$func</span>]";
                }
                else{
                    $exp = explode("/", $sliced[0]);
                    $class = isset($exp[0]) ? $exp[0] : "";
                    $ucfirst = ucfirst($class);
                    $hasRoute = "";
                    foreach($routes as $rts=>$rtv){
                        $getr = $routes[$rts];
                        if(strtolower($getr)==strtolower($class) || strtolower($getr)==strtolower($class)."/" || strtolower($getr)==strtolower($class)."/index"){
                            $hasRoute = $rts;
                        }
                    }
                    if($rts==""){
                        return "Route: Not set, [Controller: <span style='color:#d204d2;'>$ucfirst.php</span>] [Class: <span style='color:#e64d0a;'>$ucfirst</span>] [Function: <span style='color:#339a00'>index</span>]";
                    }
                    else{
                        return "Route: Not called [<span style='color:#009d80;'>$rts</span>], [Controller: <span style='color:#d204d2;'>$ucfirst.php</span>] [Class: <span style='color:#e64d0a;'>$ucfirst</span>] [Function: <span style='color:#339a00'>index</span>]";
                    }
                }
            }
           else if(($sliced[0]!=null||$sliced[0]!="") && ($sliced[1]!=null||$sliced[1]!="")){
                $class = $sliced[0];
                $func = $sliced[1];
                $funcplain = explode("?", $func)[0];
                $ucfirst = ucfirst($class);
                $hasRoute = "";
                if(strtolower($funcplain)== "index"){
                    foreach($routes as $rts=>$r){
                        $getr =  $routes[$rts];
                        if($getr == $class."/".$funcplain || $getr == $class."/".$funcplain."/" || $getr == $class || $getr == $class."/"){
                            $hasRoute =  $rts;
                        }
                    }
                }
                else{
                    foreach($routes as $rts=>$r){
                        $getr =  $routes[$rts];
                        if($getr == $class."/".$funcplain || $getr == $class."/".$funcplain."/"){
                            $hasRoute =  $rts;
                        }
                    }
                }
                
                if($hasRoute==""){
                    return "Route: Not set, [Controller: <span style='color:#d204d2;'>$ucfirst.php</span>] [Class: <span style='color:#e64d0a;'>$ucfirst</span>] [Function: <span style='color:#339a00'>$funcplain</span>]";
                }
                else{
                    return "Route: Not called [<span style='color:#009d80;'>$hasRoute</span>], [Controller: <span style='color:#d204d2;'>$ucfirst.php</span>] [Class: <span style='color:#e64d0a;'>$ucfirst</span>] [Function: <span style='color:#339a00'>$funcplain</span>]";
                }
                
           }
           else{
            return "Error: Can't tract routes";
           }
        }
       
        //print_r($sliced);
        //return $sliced;
    }

    public function getAllPost(){
        if(!empty($_POST)){
            $postdata = [];
            foreach($_POST as $post=>$value){
                $postdata[] = "[".$post."]";
            }
            $imp = implode(" ", $postdata);
            return "POST/INPUT: ".$imp;
        }
        else{
            return "POST/INPUT: No post data";
        }
    }

    public function display_route(){
        include "app/config/settings.php";
        if($app_settings['page_guide']){
        ?>
        <div class="yros-screen-routes-display" align="center">
            <div class="yros-screen-text-wrapped" style="color:black;">
                <?=$this->getRouteURL()?>
            </div>
            <?php if(! empty($_POST)): ?>
                <div class="yros-screen-text-wrapped">
                    <span style="color:blue;cursor:pointer;" onclick="yros_screen_see_more_dd(this)">see more</span>
                </div>
                <div class="yros-screen-text-wrapped" style="display: none;" id="yros_screen_see_more">
                    <div style="color:#fc3154;">
                        <?=$this->getAllPost()?>
                    </div>
                </div>
                <script>
                    function yros_screen_see_more_dd($myself){
                        if(document.getElementById('yros_screen_see_more').style.display == 'none'){
                            document.getElementById('yros_screen_see_more').style.display = '';
                            $myself.innerHTML = "hide post";
                        }
                        else{
                            document.getElementById('yros_screen_see_more').style.display = 'none';
                            $myself.innerHTML = "see more";
                        }
                    }
                </script>
            <?php endif; ?>
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
                background-color: white;
                left: 50%;
                right: 50%;
                font-family: monospace;
                font-size: 12px;
            }

            .yros-screen-text-wrapped{
                width: 100%;
                padding: 2px 3px 2px 3px;
                text-wrap: wordwrap;
            }
            

        </style>
        <?php
        }
    }

}

?>