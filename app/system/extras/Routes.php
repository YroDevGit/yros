<?php
class Routes
{
    private static $dbConfig;

    public function __construct(&$dbConfig)
    {
        self::$dbConfig = &$dbConfig;
        self::set(["view" => "main/index"]);
    }

    public static function add(string $route, string $path)
    {
        self::$dbConfig[$route] = $path;
    }

    public static function set(array $route){
        if(!empty($route)){
            foreach($route as $key=>$value){
                self::$dbConfig[$key] = $value;
            }
        }
    }

    public static function set_default_route(string $path){
        self::set(["default"=>$path]);
    }
    public static function set_PageNotFound_route(string $path){
        self::set(["page_not_found"=>$path]);
    }

    public static function set_PageError_route(string $path){
        self::set(["error"=>$path]);
    }


}

?>