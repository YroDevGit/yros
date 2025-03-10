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
        new Yros(true);
        self::$instance =& $this;

        require_once "app/system/libraries/db_lib.php";
        $this->dblib = new Db_lib();
        require_once "app/system/functions/FunctionPair.php";
        require_once "app/system/libraries/api_lib.php";
        $this->apilib = new Api_lib();

        require_once "app/system/libraries/array_lib.php";
        $this->arraylib = new Array_lib();

        include "app/config/database.php";
        $this->db = new Database($dbConfig);
        require_once "app/system/helpers/db_helper.php";
        require_once "app/system/helpers/api_helper.php";
        require_once "app/system/helpers/array_helper.php";
        require_once "app/system/helpers/form_helper.php";
        require_once "app/system/helpers/url_helper.php";
        require_once "app/system/helpers/yros_helper.php";

        include "app/config/api_config.php";
        if($api_config['api_key_enabled']){
            $headersTR = getallheaders();
            if(! array_key_exists("apikey", $headersTR)){
                echo json_encode(["code"=>-1, "status"=>"Error", "message"=>"No api_key found"."!", "source"=>"YROS framework"]);
                exit;
            }
            $apiKey = isset($headersTR['apikey']) ? $headersTR['apikey'] : "";
            if (! in_array($apiKey,$api_config['apikey'])) {
                //http_response_code(401);
                echo json_encode(["code"=>-1, "status"=>"Error", "message"=>"Invalid api_key !", "source"=>"YROS framework"]);
                exit;
            }
        }

        if($api_config['yros_key_enabled']){
            $headersTR = getallheaders();
            if(! array_key_exists("yros_key", $headersTR)){
                echo json_encode(["code"=>-1, "status"=>"Error", "message"=>"No yros_key found"."!", "source"=>"YROS framework"]);
                exit;
            }
            $apiKey = isset($headersTR['yros_key']) ? $headersTR['yros_key'] : "";
            if (! in_array($apiKey,$api_config['yros_key'])) {
                //http_response_code(401);
                echo json_encode(["code"=>-1, "status"=>"Error", "message"=>"Invalid yros_key !"]);
                exit;
            }
        }
        
    }

    public static function &get_instance()
	{
		return self::$instance;
		
	}

    public function default_header(){
        include "app/config/api_config.php";
        $headers_arr = $api_config['api_default_headers'];
        foreach($headers_arr as $arr){
            header($arr);
        }
    }

   

    

}
