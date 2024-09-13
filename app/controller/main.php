<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class main extends Yros{

    public function __construct() {
        parent::__construct();
        $YROS = &Yros::get_instance();
    }


    function index(){
        view_page("welcome");
    }
    
    function page_not_found(){
        view_error("page_not_found");
    }

    function error_page(){
        view_error("error_page");
    }

    function arr(){
        echo get_root_page();
    }

    
}
?>
