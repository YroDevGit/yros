<?php

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
    $php_command = 'php -S localhost:5105';
    echo "\nWelcome to Yros framework\nServer run at: http://localhost:5105\n\n";
    passthru($php_command); 
}

?>