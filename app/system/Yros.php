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
    // Please do not modify anything, if you want something to add, Go to:: app/autorun.php
    public $apilib;
    public $filelib;
    public $sessionlib;
    public $arraylib;
    public $data_yros;
    public $yrosdb;
    public $validationlib;

    public $yrosmail;

    public $yrossecure;
    public $modellib;
    private $old_post_data;
    public $POST;
    public $removeinputvalues = true;
    public $inputvaluesstorage = [];
    public $db;
    public $dblib;
    public $old_input_value_mask_yros = yros_input_old_value_1005_yro;
    public $yros_input_validation_errors = [];
    private static $instance;
    public function __construct() {
        self::$instance =& $this;
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        include_once "app/config/database.php";
        $this->db = new Database($dbConfig);
        $this->load_library("db_lib");
        $this->dblib = new Db_lib();
        require_once "app/system/functions/FunctionPair.php";
        $this->load_library("api_lib");
        $this->apilib = new Api_lib();
        $this->load_library("file_lib");
        $this->filelib = new File_lib();
        $this->load_library("session_lib");
        $this->sessionlib = new Session_lib();
        $this->load_library("array_lib");
        $this->arraylib = new Array_lib();
        $this->load_library("validation_lib");
        $this->validationlib = new Validation_lib();
        $this->load_library("yros_mail");
        $this->yrosmail = new Yros_mail();
        $this->load_library("secure_lib");
        $this->yrossecure = new Secure_lib();
        $this->load_library("model_lib");
        $this->modellib = new Model_lib();
        $this->load_helper("db_helper");
        $this->load_helper("api_helper");
        $this->load_helper("array_helper");
        $this->load_helper("form_helper");
        $this->load_helper("url_helper");
        $this->load_helper("yros_helper");
        $this->load_helper("session_helper");
        $this->load_helper("email_helper");
        $this->load_helper("controller_model");
        $this->old_post_data = post_data();
        $this->store_input_errors_storage_yros();
        $this->store_input_values_storage_yros();
        //$this->load_all_models();
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

    public function load_helper(string $helper, bool $once=true){
        $path = "";
        if(substr($helper, -4)==".php"){
            $path = $helper;
        }
        else{
            $path = $helper.".php";
        }
        if($once==true){
            include_once "app/system/helpers/".$path;
        }
        else{
            include "app/system/helpers/".$path;
        }
    }

    public function load_config(string $config, bool $once=true){
        $path = "";
        if(substr($config, -4)==".php"){
            $path = $config;
        }
        else{
            $path = $config.".php";
        }
        if($once==true){
            include_once "app/config/".$path;
        }
        else{
            include "app/config/".$path;
        }
    }

    public function load_library(string $library, bool $once=true){
        $path = "";
        if(substr($library, -4)==".php"){
            $path = $library;
        }
        else{
            $path = $library.".php";
        }
        if($once==true){
            include_once "app/system/libraries/".$path;
        }
        else{
            include "app/system/libraries/".$path;
        }
    }

    private function store_input_values_storage_yros(){
        foreach($_SESSION as $key=>$value){
            if(string_contains($key, $this->old_input_value_mask_yros)){
                $this->inputvaluesstorage[$key] = $value;
                unset($_SESSION[$key]);
            }
        }
    }

    private function store_input_errors_storage_yros(){
        foreach($_SESSION  as $key=>$value){
            if(string_contains($key, $this->validationlib->validation_temp_error)){
                $this->yros_input_validation_errors[$key] = $value;
                unset($_SESSION[$key]);
            }
        }
    }

    private function load_all_models(){
        $allModels = "app/models/";
        foreach (glob($allModels . '*.php') as $mod){
            require_once $mod;
        }
    }
}
