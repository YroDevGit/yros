<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Web extends Model{

        public function __construct() {
            parent::__construct();
            $YROS = &Yros::get_instance();
        }

        // Model:: stores global functions that can be called accross controllers.

        static function test(){
            return "this is a test model.!";
        }

        
    }
?>