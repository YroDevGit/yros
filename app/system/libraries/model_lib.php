<?php

class Model_lib{
    public function __construct()
	{}

    public function model_post(string $model_function, array $send_data=[]) {
        try{
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
        catch(Exception $e){
            trigger_error(display_error($e->getMessage()));
        }          
    }

    public function model_get(string $model_function, string $send_string=""){
        try{
            $data = [];
            if($send_string != "" && $send_string != null){
                $exp = preg_split('/(\|\||&)/', $send_string);
                foreach($exp as $ex){
                    $keyvalue = explode("=", $ex);               
                        $key = $keyvalue[0];
                        $value = $keyvalue[1];
                        $data[$key] = $value;
                }
            }
            $send_data = $data;

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
        catch(Exception $e){
            trigger_error(display_error($e->getMessage()));
        }

        
    }
}
?>