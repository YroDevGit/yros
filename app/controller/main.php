<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class main extends Yros{

    public function __construct() {
        parent::__construct();
        $YROS = &Yros::get_instance();
    }

    function index(){
        view("welcome");
      
    }

    
}
?>
