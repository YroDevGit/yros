<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Main extends Api{

        public function __construct() {
            parent::__construct();
            $YROS = &Yros::get_instance();
        }

        //API:: stores universal functions that can be called across sites/apps.
        

        public function test(){  
            $data = ["code"=>200, "status"=>"success", "message"=>"Yros PHP framework"];
            json_response($data);
        }





    }
?>