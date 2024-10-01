<?php

function routing_controller($urls){
    include "app/system/functions/myroutes.php";
    $url = isset($urls) ? $urls :$routes['default'];
    $url = rtrim($url, '/');
    $url = explode('/', $url);
    if($url[0]=="API"||$url[0]=="api"||$url[0]=="Api"){
        include "app/system/Api.php";
        if(! isset($url[1])){
            echo  json_encode(["code"=>404, "status"=>"API Not specified", "message"=>"API:: API not specified.!"]);exit;
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
                    echo  json_encode(["code"=>404, "status"=>"Page Not Found", "message"=>"API:: Method $methodName not found.!"]);exit;
                    //please dont do anything here:: YROS :: No method found
                }
            } else {
                echo  json_encode(["code"=>404, "status"=>"Page Not Found", "message"=>"API:: Class $className not found.!"]);exit;
                //please dont do anything here:: YROS :: no classname found
            }
        } else {
            echo  json_encode(["code"=>404, "status"=>"Page Not Found", "message"=>"API:: File $className.php not found.!"]);exit;
            // //please dont do anything here:: YROS :: Nof file found
        }
    }
    else{
        include "app/config/settings.php";
        $className = ucfirst($url[0]);
        $methodName = isset($url[1]) ? $url[1] : 'index';
        $is_set = false;
        if($app_settings['single_route']){
            foreach($routes as $key=>$value){
                if(strtolower($key)!="default"){
                    if($methodName=="index"){
                        $val = strtolower($value);
                        $r1 = strtolower($className);
                        $r2 = strtolower($className."/");
                        $r3 = strtolower($className."/index");
                        if($val == $r1 || $val == $r2 || $val == $r3){
                            $is_set = true;
                        }
                    }
                    else{
                        foreach($routes as $key=>$value){
                            if(strtolower($value) == strtolower($className."/".$methodName)){
                                $is_set =true;
                            }
                        }
                    }
                }
            }
        }
        if($is_set==true){
            header("refresh:0;url=".getProjectRoot().$routes["page_not_found"]."?err=method&class=$className&method=$methodName&routeisset=1");
        }
        $classFile = 'app/controller/' . $className . '.php';

        if (file_exists($classFile)) {
            include $classFile;

            if (class_exists($className)) {
                $classInstance = new $className();

                if (method_exists($classInstance, $methodName)) {
                    $classInstance->$methodName();
                } else {
                    header("refresh:0;url=".getProjectRoot().$routes["page_not_found"]."?err=method&class=$className&method=$methodName");
                }
            } else {
                header("refresh:0; url=".getProjectRoot().$routes["page_not_found"]."?err=class&class=$className&method=$methodName");
            }
        } else {
            header("refresh:0;url=".getProjectRoot().$routes["page_not_found"]."?err=class&class=$className&method=$methodName");
        }
    }
}

?>