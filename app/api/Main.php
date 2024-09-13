<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Main extends Api{

        public function __construct() {
            parent::__construct();
            $YROS = &Yros::get_instance();
            //This is a API file, where we can share our data across sites.
        }

        public function test(){
            $data = ["code"=>200, "status"=>"success", "message"=>"Yros PHP framework"];
            json_response($data);
        }

    }
?>