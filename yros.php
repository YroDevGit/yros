<?php

/**
 * Yros console command
 */

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
                $cmnd = strtolower($route);
                if($cmnd == "create_controller"|| $cmnd == "make_controller"){
                    $createcontroller = addController($filename);
                    if($createcontroller==200){
                        echo "\nController $filename created.\nOpen @: app/controller/$filename.php\n\n";
                    }
                    elseif($createcontroller==-1){
                        echo "Error";
                    }
                    else{
                        echo "File already exist";
                    }
                }
                else if($cmnd == "create_api" || $cmnd == "make_api"){
                    $createcontroller = addApi($filename);
                    if($createcontroller==200){
                        echo "\nApi created.\nOpen @: app/api/$filename.php\n\n";
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



require_once "app/system/functions/console_command.php";





?>