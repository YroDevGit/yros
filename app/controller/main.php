<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Main extends Yros{

    public function __construct() {
        parent::__construct();
        $YROS = &Yros::get_instance();
    }


    function welcome_page(){
        view_page("welcome.php");
    }

    function page(){
        view_page("page.php");
    }
    
    function page_not_found(){
        view_error("page_not_found.php");
    }

    function error_page(){
        view_error("error_page.php");
    }

    function arr(){
        echo get_root_page();
    }

    
}
?>
