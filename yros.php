<?php

/**
 * Yros console command
 */
require_once "app/system/functions/console_command.php";
if (PHP_SAPI !== 'cli') {
    echo "This script should only be run from the command line.";
    exit(1);
}

$arguments = $argv;
$route = isset($arguments[1]) ? $arguments[1] : '';
$filename = isset($arguments[2]) ? $arguments[2] : '';
$filelower = strtolower($filename);
if($route==null ||$route ==""){
    runDev();
}
else{
    $routelower = strtolower($route);
    if($routelower == "create_api" || $routelower == "make_api" || $routelower == "add_api" || $routelower == "create_controller" || $routelower == "make_controller" || $routelower == "add_controller"){
            if($filename==""||$filename==null){
                echo "No file to create, please add filename";exit;
            }
            else if($filelower == "api" || $filelower == "controller" || $filelower == "controllers"){
                echo "File not created, Filename '$filename' is not valid.! , try another file name.";exit;
            }
            else{
                $cmnd = strtolower($route);
                if($cmnd == "create_controller"|| $cmnd == "make_controller" || $cmnd == "add_controller"){
                    $createcontroller = addController($filename);
                    if($createcontroller==200){
                        echo "\nController $filename created.\nOpen @: app/controller/$filename.php\n\n";exit;
                    }
                    elseif($createcontroller==-1){
                        echo "Error";exit;
                    }
                    else{
                        echo "ERROR:: Controller: filename is already exist.!";exit;
                    }
                }
                else if($cmnd == "create_api" || $cmnd == "make_api" || $cmnd == "add_api"){
                    $createcontroller = addApi($filename);
                    if($createcontroller==200){
                        echo "\nApi created.\nOpen @: app/api/$filename.php\n\n";exit;
                    }
                    elseif($createcontroller==-1){
                        echo "Error";exit;
                    }
                    else{
                        echo "ERROR:: API Filename already exist.!";exit;
                    }
                }
            }
    }
    elseif($route=="run"||$route=="RUN"){
        runDev();
    }
    else{
        echo "Invalid command";
    }
}









?>