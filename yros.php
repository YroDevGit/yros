<?php

if (PHP_SAPI !== 'cli') {
    echo "This script should only be run from the command line.";
    exit(1);
}

$arguments = $argv;
$route = isset($arguments[1]) ? $arguments[1] : '';
$filename = isset($arguments[2]) ? $arguments[2] : '';

if($route==null ||$route ==""){
    runDev();
}
else{
    if($route == "create_api" || $route == "CREATE_API" || $route=="create_controller" || $route=="CREATE_CONTROLLER"){
            if($filename==""||$filename==null){
                echo "No file to create, please add filename";
            }
            else{
                if($route=="create_controller"||$route=="CREATE_CONTROLLER"){
                    $createcontroller = addController($filename);
                    if($createcontroller==200){
                        echo "Controller created.";
                    }
                    elseif($createcontroller==-1){
                        echo "Error";
                    }
                    else{
                        echo "File already exist";
                    }
                }
                else{
                    $createcontroller = addApi($filename);
                    if($createcontroller==200){
                        echo "Api created.";
                    }
                    elseif($createcontroller==-1){
                        echo "Error";
                    }
                    else{
                        echo "File already exist";
                    }
                }
            }
    }
    elseif($route=="controller" || $route =="CONTROLLER"){

    }
    elseif($route=="api" || $route == "API"){

    }
    elseif($route=="run"||$route=="RUN"){
        runDev();
    }
    else{
        echo "Invalid command";
    }
}










function addController($name){

    $newname = ucfirst($name);
    $phpFile = "app/controller/".ucfirst($newname).".php"; // Name of the PHP file to be created

    $phpContent = <<<EOT
    <?php
        defined('BASEPATH') OR exit('No direct script access allowed');
        class $newname extends Yros{

            public function __construct() {
                parent::__construct();
                \$YROS = &Yros::get_instance();
            }

            function index(){
                echo 'Hello Yros user.';
            }

            
        }
    ?>
    EOT;
    
    if (file_exists($phpFile)) {
        return -2;
    } else {
        if (file_put_contents($phpFile, $phpContent) !== false) {
            return 200;
        } else {
            return -1;
        }
    }
}

function addApi($name){

    $newname = ucfirst($name);
    $phpFile = "app/api/".ucfirst($newname).".php"; // Name of the PHP file to be created

    $phpContent = <<<EOT
    <?php
        defined('BASEPATH') OR exit('No direct script access allowed');
        class $newname extends Api{

            public function __construct() {
                parent::__construct();
                \$YROS = &Yros::get_instance();
                //This is a API file, where we can share our data across sites.
            }

            function test(){
                \$data = ["code"=>200, "status"=>"success", "message"=>"Yros PHP framework"];
                json_response(\$data);
            }
        }
    ?>
    EOT;
    
    if (file_exists($phpFile)) {
        return -2;
    } else {
        if (file_put_contents($phpFile, $phpContent) !== false) {
            return 200;
        } else {
            return -1;
        }
    }
}

function runDev(){
    $php_command = 'php -S localhost:5105';
    echo "\nWelcome to Yros framework\nServer run at: http://localhost:5105\n\n";
    passthru($php_command);
    

}

?>