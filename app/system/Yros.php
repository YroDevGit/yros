<?php
if(! defined("SUCCESS")){
    define("SUCCESS", 200);
}
if(! defined("SUCCESS_CODE")){
    define("SUCCESS_CODE", 200);
}
class Yros {
    public $db;
    public $dblib;
    public $apilib;
    public $filelib;
    public $sessionlib;
    public $data_yros;
    public $POST;
    private static $instance;
    public function __construct() {
        self::$instance =& $this;
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        require_once "app/system/libraries/db_lib.php";
        $this->dblib = new Db_lib();
        require_once "app/system/libraries/api_lib.php";
        $this->apilib = new Api_lib();
        require_once "app/system/libraries/file_lib.php";
        $this->filelib = new File_lib();
        require_once "app/system/libraries/session_lib.php";
        $this->sessionlib = new Session_lib();

        require_once "app/database/config.php";
        $this->db = new Database($dbConfig);
        require_once "app/system/helpers/db_helper.php";
        require_once "app/system/helpers/form_helper.php";
        require_once "app/system/helpers/url_helper.php";
        require_once "app/system/helpers/yros_helper.php";
        require_once "app/system/helpers/session_helper.php";
        
    }

    public static function &get_instance()
	{
		return self::$instance;
		
	}

    public function baseMethod() {
        echo "This is Yros PHP framework";
    }

    public function yros_homepage(){
        return HOMEPAGE;
    }

    public function view(string $view, array $data = array()){
        if(! empty($data)){
            extract($data);
        }
        include "views/".$view.".php";
    }

    public function view_content(string $view, array $data = array()){
        $this->view("contents/".$view, $data);
    }

    public function view_include(string $view, array $data = array()){
        $this->view("includes/".$view, $data);
    }

    public function view_error(string $view, array $data = array()){
        $this->view("errors/".$view, $data);
    }

    public function view_page(string $view, array $data = array()){
        $this->view("pages/".$view, $data);
    }

    public function view_partial(string $view, array $data = array()){
        $this->view("partials/".$view, $data);
    }

    public function loader($name, $once = true){
        if($once==true){
            include_once $name;
        }
        else{
            include  $name;
        }
    }
}
