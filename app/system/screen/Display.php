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
        $def = isset($routes['default']) ? $routes['default'] : "";
        $curr = $_SESSION['yros_p4ge_contr0ll3r_1005055_v13w5'];
        if(strtolower($def) == strtolower($curr)){
            $xpl = explode("/", $curr);
            $ucfirst = isset($xpl[0]) ? $xpl[0] : "";
            $ucfirst = ucfirst($ucfirst);
            $func = isset($xpl[1]) ? $xpl[1] : "index";
            $func = ucfirst($func);
            return "Route: [<span style='color:#009d80;'>default</span>], [Controller: <span style='color:#d204d2;'>$ucfirst.php</span>] [Class: <span style='color:#e64d0a;'>$ucfirst</span>] [Function: <span style='color:#339a00'>$func</span>]";
        }
        else{
            $xpl = explode("/", $curr);
            $cc = isset($xpl[0]) ? $xpl[0] : "";
            $ff = isset($xpl[1]) ? $xpl[1] : "index";
            $has_route = false;
            $the_key = "";
            foreach($routes as $key=>$value){
                $plode = explode("/", $value);
                $r_cc = isset($plode[0]) ? $plode[0] : "";
                $r_ff = isset($plode[1]) ? $plode[1] : "index";
                if(strtolower($cc) == strtolower($r_cc) && strtolower($ff) == strtolower($r_ff)){
                    $has_route = true;
                    $the_key = $key;
                }
            }
            $cc = ucfirst($cc);

            if($has_route){
                return "Route: [<span style='color:#009d80;'>$the_key</span>], [Controller: <span style='color:#d204d2;'>$cc.php</span>] [Class: <span style='color:#e64d0a;'>$cc</span>] [Function: <span style='color:#339a00'>$ff</span>]";
            }
            else{
                return "Route: Not set, [Controller: <span style='color:#d204d2;'>$cc.php</span>] [Class: <span style='color:#e64d0a;'>$cc</span>] [Function: <span style='color:#339a00'>$ff</span>]";
            }
        }
        $sliced = array_slice($arr,-2);
        if(($sliced[0]==null||$sliced[0]=="") && ($sliced[1]==null||$sliced[1]=="")){
            $rootController = isset($routes['default']) ? $routes['default'] : "?";
            $classfunction = explode("/", $rootController);
            $cl = isset($classfunction[0])? $classfunction[0] : "";
            $func = isset($classfunction[1]) && $classfunction[1] !="" ? $classfunction[1] : "index";
            $ucfirst = ucfirst($cl);
            $ucfirst = $this->noParam($ucfirst);
            $func = $this->noParam($func);
            return "Route: [<span style='color:#009d80;'>default</span>], [Controller: <span style='color:#d204d2;'>$ucfirst.php</span>] [Class: <span style='color:#e64d0a;'>$ucfirst</span>] [Function: <span style='color:#339a00'>$func</span>]";
        }
       
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

    public function getAllGet(){
        if(!empty($_GET)){
            $postdata = [];
            foreach($_GET as $post=>$value){
                $postdata[] = "[".$post."]";
            }
            $imp = implode(" ", $postdata);
            return "GET/parameters: ".$imp;
        }
        else{
            return "GET/parameters: No get data";
        }
    }

    public function display_route(){
        ?>
        <div class="yros-screen-routes-display" align="center">
            <div class="yros-screen-text-wrapped" style="color:black;">
                <?=$this->getRouteURL()?>
            </div>
            <?php if(! empty($_POST) || ! empty($_GET)): ?>
                <div class="yros-screen-text-wrapped">
                    <span style="color:blue;cursor:pointer;" onclick="yros_screen_see_more_dd(this)"><<== see more ==>></span>
                </div>
                <div class="yros-screen-text-wrapped" style="display: none;" id="yros_screen_see_more">
                    <?php if(! empty($_POST)): ?>
                        <div style="color:#fc3154;">
                            <?=$this->getAllPost()?>
                        </div>
                    <?php endif; ?>
                    <?php if(! empty($_GET)): ?>
                        <div style="color:orange;">
                            <?=$this->getAllGet()?>
                        </div>
                    <?php endif; ?>
                </div>
                <script>
                    function yros_screen_see_more_dd($myself){
                        if(document.getElementById('yros_screen_see_more').style.display == 'none'){
                            document.getElementById('yros_screen_see_more').style.display = '';
                            $myself.innerHTML = "<<== hide post/get data ==>>";
                        }
                        else{
                            document.getElementById('yros_screen_see_more').style.display = 'none';
                            $myself.innerHTML = "<<== see more ==>>";
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
                bottom: 10px;
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

    public function noParam($text, $str = "?"){
        $expl = explode($str, $text);
        $data = isset($expl[0]) ? $expl[0] : "";
        return $data;
    }

}

?>