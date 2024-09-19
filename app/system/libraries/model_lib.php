<?php

class Model_lib{
    public function __construct()
	{}

    public function model(string $model_function, array $send_data=[]) {
        $modelarr = explode("/", $model_function);
        $class = $modelarr[0];

        $model_path = "app/models/$class.php";
        
        include $model_path;

        $func = $modelarr[1];
        $classname = new $class();
        
            if(!empty($send_data)){
                foreach($send_data as $d=>$value){
                    $_GET[$d] = $value;
                }
            }

            $result = $classname->$func(); 
            return $result;          
    }
}
?>