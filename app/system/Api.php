<?php
if(! defined("SUCCESS")){
    define("SUCCESS", 200);
}
if(! defined("SUCCESS_CODE")){
    define("SUCCESS_CODE", 200);
}
class Api {
    public $db;
    public $dblib;
    public $apilib;

    public $arraylib;

    public $data_yros;
    public $POST;
    private static $instance;
    public function __construct() {
        new Yros();
        self::$instance =& $this;
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        require_once "app/config/api_config.php";

        if($api_config['enabled']){
            $headersTR = getallheaders();
            $apiKey = isset($headersTR[$api_config['api_key_header_name']]) ? $headersTR[$api_config['api_key_header_name']] : null;
            if ($apiKey !== $api_config['api_key']) {
                http_response_code(401);
                echo json_encode(["error_num"=>-1, "status"=>"Error", "message"=>"Invalid ".$api_config['api_key_header_name']."!"]);
                exit;
            }
        }
        require_once "app/system/libraries/db_lib.php";
        $this->dblib = new Db_lib();
        require_once "app/system/libraries/api_lib.php";
        $this->apilib = new Api_lib();

        require_once "app/system/libraries/array_lib.php";
        $this->arraylib = new Array_lib();

        include "app/database/config.php";
        $this->db = new Database($dbConfig);
        require_once "app/system/helpers/db_helper.php";
        require_once "app/system/helpers/api_helper.php";
        require_once "app/system/helpers/array_helper.php";
        require_once "app/system/helpers/form_helper.php";
        require_once "app/system/helpers/url_helper.php";
        require_once "app/system/helpers/yros_helper.php";
        
    }

    public static function &get_instance()
	{
		return self::$instance;
		
	}

   

    

}
