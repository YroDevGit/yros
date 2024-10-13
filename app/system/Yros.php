<?php
/**
 * YROS - PHP framework.
 * Tyrone Limen Malocon
 * 
 */

class Yros {
    // Please do not modify anything, if you want something to add, Go to:: app/yros_custom/autorun.php
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
    public $routelib;
    public $POST;
    public $removeinputvalues = true;
    public $inputvaluesstorage = [];
    public $db; 
    public $dblib;
    public $auth;
    public $old_input_value_mask_yros;
    public $yros_input_validation_errors = [];
    public $yros_back_up_flash_data1005 = [];
    private static $instance;
    public function __construct($isYrosApiOrModel=false) {
        self::$instance =& $this;
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->set_status_definitions();
        $this->load_app("system/code/definitions");
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
        $this->load_library("auth_lib");
        $this->load_library("route_lib");
        $this->routelib = new Route_lib();
        $this->auth = new Auth_lib();
        $this->load_helper("auth_helper");
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
        $this->old_input_value_mask_yros = $this->sessionlib->input_mask;
        $this->store_input_errors_storage_yros();
        $this->store_input_values_storage_yros();
        $this->store_back_up_flash_data1005();
        //$this->load_all_models();

        require_once "app/auto/autorun.php";
        require_once "app/auto/components.php";
        if($isYrosApiOrModel==false){
            //add custom command
        }
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
        include "app/config/settings.php";
        if(! empty($data)){
            extract($data);
        }
        if($app_settings['enable_curly_template']==true){
            $viewPath = (substr($view, -4) == ".php") ? "views/" . $view : "views/" . $view . ".php";
                $content = file_get_contents($viewPath);
                $content = preg_replace('/\{\{\s*(.+?)\s*\}\}/', '<?= htmlspecialchars($1) ?>', $content);
                $tempFile = 'app/system/cache/' . md5($viewPath) . '.php';
                file_put_contents($tempFile, $content);
                require $tempFile;
                unlink($tempFile);
        }
        else{
            if(substr($view, -4)==".php"){
                require "views/".$view;
            }
            else{
                require "views/".$view.".php";
            }
        }

        if($app_settings['views_log']==true){
            $contfunc = $_SESSION['yros_p4ge_contr0ll3r_1005055_v13w5'];
            $exp = explode("/", $contfunc);
            $cc = isset($exp[0]) ? $exp[0] : "";
            $ff = isset($exp[1]) ? $exp[1] : "";
            $this->record_view_in_json_file($view, $cc, $ff);
        }
        
        
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

    public function load_app(string $file, bool $once=true){
        $path = "";
        if(substr($file, -4)==".php"){
            $path = $file;
        }
        else{
            $path = $file.".php";
        }
        if($once==true){
            include_once "app/".$path;
        }
        else{
            include "app/".$path;
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

    private function store_back_up_flash_data1005(){
        foreach($_SESSION as $key=>$value){
            if(string_contains($key, $this->sessionlib->flash_mask)){
                $this->yros_back_up_flash_data1005[$key] = $value;
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

    private function set_status_definitions(){
        if(! defined("SUCCESS")){
            define("SUCCESS", 200);
        }
        if(! defined("SUCCESS_CODE")){
            define("SUCCESS_CODE", 200);
        }
    }

    public function get_random_codes($length=10){ 
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomCode = '';

        for ($i = 0; $i < $length; $i++) {
            $randomCode .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomCode;
    }

    public function record_view_in_json_file(string $viewName, string $controllerName, string $functionName) {
        $filePath = "php/views.json";
         
        if (!file_exists($filePath)) {
            file_put_contents($filePath, json_encode(new stdClass()));
        }
        $jsonData = file_get_contents($filePath);
        $records = json_decode($jsonData, true); 
        $contf = $controllerName."/".$functionName;
        $keyname = $viewName."@".$contf;
        if (!isset($records[$keyname][$controllerName]) && !isset($records[$keyname][$functionName])) {
            $records[$keyname] = [
                'view' => $viewName,
                'controller' => $controllerName,
                'function' => $functionName,
                'path' => $contf,
                'description' => "Last access to this view, if view controller is changed, we can't track it."
            ];
    
            file_put_contents($filePath, json_encode($records, JSON_PRETTY_PRINT| JSON_UNESCAPED_SLASHES));
        }
    }

    public function get_view_logs_inside_json(string $keyContains=""):array{
        $jsonFilePath = "php/views.json";
        $jsonData = file_get_contents($jsonFilePath);
        $dataArray = json_decode($jsonData, true);

        if ($dataArray === null && json_last_error() !== JSON_ERROR_NONE) {
            return [];
        } else {
            if($keyContains=="" || $keyContains == null){
                return $dataArray;
            }
            else{
                $arr = [];
                foreach($dataArray as $key=>$value){
                    if(string_contains($key, $keyContains)){
                        $arr[$key] = $value;
                    }
                }
                return $arr;
            }
        }
    }

    public function getCurrentController(){
        return $_SESSION['yros_p4ge_contr0ll3r_1005055_v13w5'];
    }

    public function getCurrentClass(){
        $ccff = $this->getCurrentController();
        $xpl = explode("/", $ccff);
        return isset($xpl[0]) ? $xpl[0] : "";
    }

    public function getCurrentFunction(){
        $ccff = $this->getCurrentController();
        $xpl = explode("/", $ccff);
        return isset($xpl[1]) ? $xpl[1] : "index";
    }

    
}
