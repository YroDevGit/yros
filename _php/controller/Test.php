<?php


defined('BASEPATH') OR exit('No direct script access allowed');
class Test extends Yros{

    public function __construct() {
        parent::__construct(); 
        $YROS = &Yros::get_instance();
    }

    
    function testpage(){
        display("This is a test page");
    }







}

?>