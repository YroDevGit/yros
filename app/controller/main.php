<?php


defined('BASEPATH') OR exit('No direct script access allowed');
class Main extends Yros{

    public function __construct() {
        parent::__construct(); 
        $YROS = &Yros::get_instance();
    }

    // Main controller is YROS index controller, you can add functions but don't delete any (might cause system errors).


    function welcome_page(){
        view_page("welcome.php");
    }

   
    function page_not_found(){
        view_error("page_not_found.php");
    }
    

    function error_page(){
        view_error("error_page.php");
    }

    function sample_page(){
        echo "Hello, this is a sample page";
    }

    

    

    
}
?>
