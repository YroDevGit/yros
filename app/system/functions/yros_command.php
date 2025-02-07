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
    echo "Welcome to YROS framework v 2.4\nCreated by CodeYro (TLM)\n\n";
}
else{
    $routelower = strtolower($route);
    if($routelower == "make_api"||$routelower == "+api" || $routelower == "m_a" || $routelower == "make_controller"||$routelower == "+controller" || $routelower == "m_c" || $routelower == "make_model"||$routelower == "+model" || $routelower == "m_m" || $routelower == "+m" || $routelower == "+c" || $routelower == "+a"){
            if($filename==""||$filename==null){
                echo "No file to create, please add filename";exit;
            }
            else if($filelower == "api" || $filelower == "public" || $filelower == "views" || $filelower == "view"){
                echo "❌ File not created, Filename '$filename' is not valid.! , try another file name.";exit;
            }
            else{
                $cmnd = strtolower($route);
                if($cmnd == "make_controller"|| $cmnd == "+controller" || $cmnd == "m_c" || $cmnd == "+c"){
                    if(strtolower($filename)=="public" || strtolower($filename)=="app" || strtolower($filename)=="api" || strtolower($filename)=="views"){
                        echo "❌ ERROR:: Controller name '$filename' is a case sensitive name.";exit;
                    }
                    $createcontroller = addController($filename);
                    if($createcontroller==200){
                        echo "\n✅ Controller $filename created.\nOpen @: _php/controller/$filename.php\n\n";exit;
                    }
                    elseif($createcontroller==-1){
                        echo "❌ Error";exit;
                    }
                    else{
                        echo "❌ ERROR:: Controller: filename is already exist.!";exit;
                    }
                }
                else if($cmnd == "make_model"|| $cmnd == "+model" || $cmnd == "m_m" || $cmnd == "+m"){
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
                else if($cmnd == "make_api" || $cmnd == "+api" || $cmnd == "m_a" || $cmnd == "+a"){
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
    }elseif(strtolower($route)=="clear_sql_errors" || strtolower($route)=="xsqlerrors"){
        $file = "app/system/errors/sqlerrors.txt";
        if (file_exists($file)) {
            if (unlink($file)) {
                echo "SQL ERRORS CLEARED ✅";
            } else {
                echo "Error !";
            }
        } else {
            echo "SQL ERRORS CLEARED ✅";
        }
    }
    else if($routelower=="test_routes"){
        yrosTestRoutes();  
    }elseif($routelower == "import"){
        include_once "app/system/functions/customs.php";
        $cust = new customs();
        if($filelower == "yroswal"){
            $cust->importswal();
        }else if($filelower == "jspost"){
            $cust->importjspost();
        }elseif($filelower == "jsqrcode"){
            $cust->importqrcode();
        }elseif($filelower =="jsqrscanner"){
            $cust->importqrscanner();
        }else{
            echo "Invalid import! ❌";
        }
    }
    else if($routelower == "db"){
        echo "Database config here (Shift + click): app/config/database.php";
    }
    else if($routelower=="clear_viewlogs" || $routelower=="del_viewlogs" || $routelower=="-viewlogs"){
        deleteAllViewsLogs(); 
    }
    else{
        echo "❌ Invalid command";
    }
}


?>