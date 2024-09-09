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

        require_once "app/database/config.php";
        $this->db = new Database($dbConfig);
        require_once "app/system/helpers/db_helper.php";
        require_once "app/system/helpers/form_helper.php";
        require_once "app/system/helpers/url_helper.php";
        require_once "app/system/helpers/yros_helper.php";
        
    }

    public static function &get_instance()
	{
		return self::$instance;
		
	}

}
