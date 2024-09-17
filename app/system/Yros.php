<?php
if(! defined("SUCCESS")){
    define("SUCCESS", 200);
}
if(! defined("SUCCESS_CODE")){
    define("SUCCESS_CODE", 200);
}
if(! defined("yros_input_old_value_1005_yro")){
    define("yros_input_old_value_1005_yro","yros_input_old_value_1005_yro_");
}
class Yros {
    public $db;
    public $dblib;
    public $old_input_value_mask_yros = yros_input_old_value_1005_yro;
    public $apilib;
    public $filelib;
    public $sessionlib;
    public $arraylib;
    public $data_yros;
    public $yrosdb;
    public $validationlib;

    public $yrosmail;

    public $yrossecure;

    private $old_post_data;
    public $POST;
    private static $instance;
    public function __construct() {
        self::$instance =& $this;
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        require_once "app/config/database.php";
        $this->db = new Database($dbConfig);
        require_once "app/system/libraries/db_lib.php";
        $this->dblib = new Db_lib();
        require_once "app/system/functions/FunctionPair.php";
        require_once "app/system/libraries/api_lib.php";
        $this->apilib = new Api_lib();
        require_once "app/system/libraries/file_lib.php";
        $this->filelib = new File_lib();
        require_once "app/system/libraries/session_lib.php";
        $this->sessionlib = new Session_lib();

        require_once "app/system/libraries/array_lib.php";
        $this->arraylib = new Array_lib();

        require_once "app/system/libraries/validation_lib.php";
        $this->validationlib = new Validation_lib();

        require_once "app/system/libraries/yros_mail.php";
        $this->yrosmail = new Yros_mail();

        require_once "app/system/libraries/secure_lib.php";
        $this->yrossecure = new Secure_lib();
        
        require_once "app/system/helpers/db_helper.php";
        require_once "app/system/helpers/api_helper.php";
        require_once "app/system/helpers/array_helper.php";
        require_once "app/system/helpers/form_helper.php";
        require_once "app/system/helpers/url_helper.php";
        require_once "app/system/helpers/yros_helper.php";
        require_once "app/system/helpers/session_helper.php";
        require_once "app/system/helpers/email_helper.php";
        $this->old_post_data = post_data();

        require_once "app/autorun.php";
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
        if(substr($view, -4)==".php"){
            include_once "views/".$view;
        }
        else{
            include_once "views/".$view.".php";
        }
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


    public function get_previous_page(){
        $previousUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] :rootpath;
        return $previousUrl;
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
