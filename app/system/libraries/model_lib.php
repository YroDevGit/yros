<?php

class Model_lib{
    public $receivedData = [];
    public $modelname;
    public function __construct()
	{}


    public function model_x(string|array $model_function, array $params = []){
        try {
            if (is_array($model_function)) {
                $model_function = $model_function[0] ?? "";
            }

            $modelarr = explode("/", $model_function);
            $class = $modelarr[0];
            $func = $modelarr[1];

            $model_path = "app/models/$class.php";

            if (!file_exists($model_path)) {
                show_error("Model file not found: $model_path");
            }

            include $model_path;

            $classname = new $class();
            $method = new ReflectionMethod($class, $func);
            $expectedParams = $method->getParameters();

            $adjustedParams = [];
            foreach ($expectedParams as $index => $param) {
                $adjustedParams[] = $params[$index] ?? null;
            }

            $result = $method->invokeArgs($classname, $adjustedParams);

            return $result;
        } catch (Exception $e) {
            trigger_error(display_error($e->getMessage()));
        }
    }

    
    public function model(string $model){
        $model_path = "app/models/$model.php";
        if (!file_exists($model_path)) {
            show_error("Model file not found: $model_path");
        }
        include $model_path;
        $mod = new $model();
        return $mod;
    }

    public function model_post(string $model_function, array $send_data=[]) {
        try{
            $modelarr = explode("/", $model_function);
            $class = $modelarr[0];

            $model_path = "app/models/$class.php";
            
            include $model_path;

            $func = $modelarr[1];
            $this->receivedData = [];
            $classname = new $class();
            
                if(!empty($send_data)){
                    foreach($send_data as $d=>$value){
                        $this->receivedData[$d] = $value;
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
                $exp = preg_split('/[&|]/', $send_string);
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
            $this->receivedData = [];
            $classname = new $class();
            
            if(!empty($send_data)){
                foreach($send_data as $d=>$value){
                    $this->receivedData[$d] = $value;
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