<?php 

/**
 * Yros PHP framework
 * 
 */

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
    if($routelower == "make_api"||$routelower == "+api" || $routelower == "m_a" || $routelower == "make_controller"||$routelower == "+controller" || $routelower == "m_c" || $routelower == "make_model"||$routelower == "+model" || $routelower == "m_m"){
            if($filename==""||$filename==null){
                echo "No file to create, please add filename";exit;
            }
            else if($filelower == "api" || $filelower == "public" || $filelower == "views" || $filelower == "view"){
                echo "❌ File not created, Filename '$filename' is not valid.! , try another file name.";exit;
            }
            else{
                $cmnd = strtolower($route);
                if($cmnd == "make_controller"|| $cmnd == "+controller" || $cmnd == "m_c"){
                    if(strtolower($filename)=="public" || strtolower($filename)=="app" || strtolower($filename)=="api" || strtolower($filename)=="views"){
                        echo "❌ ERROR:: Controller name '$filename' is a case sensitive name.";exit;
                    }
                    $createcontroller = addController($filename);
                    if($createcontroller==200){
                        echo "\n✅ Controller $filename created.\nOpen @: php/controller/$filename.php\n\n";exit;
                    }
                    elseif($createcontroller==-1){
                        echo "❌ Error";exit;
                    }
                    else{
                        echo "❌ ERROR:: Controller: filename is already exist.!";exit;
                    }
                }
                else if($cmnd == "make_model"|| $cmnd == "+model" || $cmnd == "m_m"){
                    $createcontroller = addModel($filename);
                    if($createcontroller==200){
                        echo "\n✅ Model $filename created.\nOpen @: app/model/$filename.php\n\n";exit;
                    }
                    elseif($createcontroller==-1){
                        echo "❌ Error";exit;
                    }
                    else{
                        echo "❌ ERROR:: Model: filename is already exist.!";exit;
                    }
                }
                else if($cmnd == "make_api" || $cmnd == "+api" || $cmnd == "m_a"){
                    $createcontroller = addApi($filename);
                    if($createcontroller==200){
                        echo "\n✅ Api created.\nOpen @: app/api/$filename.php\n\n";exit;
                    }
                    elseif($createcontroller==-1){
                        echo "❌ Error";exit;
                    }
                    else{
                        echo "❌ ERROR:: API Filename already exist.!";exit;
                    }
                }
            }
    }
    elseif($route=="run"||$route=="RUN"){
        runDev();
    }
    else if($routelower=="test_routes"){
        yrosTestRoutes();  
    }
    else if($routelower=="clear_viewlogs" || $routelower=="del_viewlogs" || $routelower=="-viewlogs"){
        deleteAllViewsLogs(); 
    }
    else{
        echo "❌ Invalid command";
    }
}


?>