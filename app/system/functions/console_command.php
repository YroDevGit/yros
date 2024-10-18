<?php

function addController($name){

    $newname = ucfirst($name);
    $phpFile = "php/controller/".ucfirst($newname).".php"; // Name of the PHP file to be created

    $phpContent = <<<EOT
    <?php
        defined('BASEPATH') OR exit('No direct script access allowed');
        class $newname extends Yros{

            public function __construct() {
                parent::__construct();
                \$YROS = &Yros::get_instance();
                //Add initial codes here...
            }


            function index(){
                echo 'Hello Yros user. This is $newname controller';
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


function addModel($name){

    $newname = ucfirst($name);
    $phpFile = "app/models/".ucfirst($newname).".php"; // Name of the PHP file to be created

    $phpContent = <<<EOT
    <?php
        defined('BASEPATH') OR exit('No direct script access allowed');
        class $newname extends Model{

            public function __construct() {
                parent::__construct();
                \$YROS = &Yros::get_instance();
                //Add initial codes here...
            }

            // Model:: stores global functions that can be called accross controllers.

            function test(){
                echo 'Hello Yros user. This is $newname controller';
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
    include "app/config/settings.php";
    $port = $app_settings['port'];
    $php_command = "";
    $php_command = 'php -S localhost:'.$port;
    echo "\nWelcome to Yros, PHP framework (Made by: CodeYro Team)\nServer run at: http://localhost:$port\n\n";
    passthru($php_command); 
}

function yrosTestRoutes(){
    include_once "app/system/functions/myroutes.php";
    include_once "app/system/test/routes_test.php";
    include_once "app/system/Yros.php";
    define("BASEPATH", "d");
    $rtest = new RouteTest($routes);
    $rtest->testRoutes();
}

function deleteAllViewsLogs(){
    $folderPath = "app/system/logs/view_logs";
    if (is_dir($folderPath)) {
        $logFiles = glob($folderPath . '/*.log');
        $count = 0;
        foreach ($logFiles as $file) {
            if (is_file($file)) {
                unlink($file);
                $count +=1;
            }
        }
        if (empty($logFiles)) {
            echo "❌ No logs found.!\n";
        } else {
            echo "✅ All ($count) view logs have been deleted.\n";
        }
    }
}

?>