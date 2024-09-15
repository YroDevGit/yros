<?php

function routing_controller($urls){
    include "app/config/routes.php";
    $url = isset($urls) ? $urls :$routes['default'];
    $url = rtrim($url, '/');
    $url = explode('/', $url);
    if($url[0]=="API"||$url[0]=="api"||$url[0]=="Api"){
        if(! isset($url[1])){
            die("No api file found.!");
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
                    echo  json_encode(["code"=>404, "status"=>"Page Not Found", "message"=>"API:: Method $methodName not found.!"]);
                    //please dont do anything here:: YROS :: No method found
                }
            } else {
                echo  json_encode(["code"=>404, "status"=>"Page Not Found", "message"=>"API:: Class $className not found.!"]);
                //please dont do anything here:: YROS :: no classname found
            }
        } else {
            echo  json_encode(["code"=>404, "status"=>"Page Not Found", "message"=>"API:: File $className.php not found.!"]);
            // //please dont do anything here:: YROS :: Nof file found
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

?>