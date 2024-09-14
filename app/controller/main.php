<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Main extends Yros{

    public function __construct() {
        parent::__construct();
        $YROS = &Yros::get_instance();
    }


    function index(){
        //view_page("welcome");
        echo get_root_page();
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
