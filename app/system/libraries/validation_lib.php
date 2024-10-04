<?php

class Validation_lib{
    public $validation_errors;
    public $validation_session_error = "yros_1005_codeyro_";
    public $validation_temp_error = "yros_1005_temp_codeyro_";
    public function __construct()
	{

	}


    public function validate_input(string $inputname, string $label, string $validation){
        $rules = explode('|', $validation);
    
        $inputData = $_POST[$inputname] ?? '';
    
        $errors = [];
    
        foreach ($rules as $rule) {
            $parts = explode(':', $rule);
            $ruleName = $parts[0];
            $ruleParam = $parts[1] ?? null;
    
            switch ($ruleName) {
                case "important":
                case 'required':
                    if (empty(trim($inputData))) {
                        $errors[$inputname] = "{$label} is required.";
                    }
                    break;
                
                case "number":
                case "numeric":
                    if(! is_numeric($inputData)){
                        $errors[$inputname] = "{$label} should be a number.";
                    }
                    break;

                case "string":
                case "text":
                    if(! is_string($inputData)){
                        $errors[$inputname] = "{$label} should be a string/letters.";
                    }
                    break;

                case "length":
                case "characters":
                case "character":
                case "size":
                    if (strlen($inputData) != (int)$ruleParam) {
                        $errors[$inputname] = "{$label} should have {$ruleParam} characters.";
                    }
                    break;
    
                case 'max':
                    if (strlen($inputData) > (int)$ruleParam) {
                        $errors[$inputname] = "{$label} cannot be more than {$ruleParam} characters.";
                    }
                    break;

                case 'min':
                    if (strlen($inputData) < (int)$ruleParam) {
                        $errors[$inputname] = "{$label} cannot be less than {$ruleParam} characters.";
                    }
                    break;
                case "no-symbols":
                    if(! preg_match('/^[a-zA-Z0-9\s]*$/', $inputData)){
                        $errors[$inputname] = "{$label} should not have symbols.";
                    }
                    break;
                case "with-symbols":
                    if(preg_match('/^[a-zA-Z0-9\s]*$/', $inputData)){
                        $errors[$inputname] = "{$label} should have a symbols";
                    }
                default:
                    $errors[$inputname] = "Unknown validation rule: {$ruleName}";
            }
        }
    
        if (!empty($errors)) {
            $this->validation_errors = $errors;
            $_SESSION[$this->validation_temp_error.$inputname] = $errors[$inputname];
        }
    }


    public function set_input_error(string $input, string $message){
        $_SESSION[$this->validation_temp_error.$input] = $message;
    }

    public function get_input_error(string $inputname):string{
        //$val = get_flash_data($this->validation_session_error.$inputname);
        $YROS = &Yros::get_instance();
        if(array_key_exists($this->validation_temp_error.$inputname, $YROS->yros_input_validation_errors)){
            $val = $YROS->yros_input_validation_errors[$this->validation_temp_error.$inputname];
            if($val==""||$val==null){
                return "";
            }
            else{
                return $val;
            }
        }
        else{
            return "";
        }
        
    }



    public function validation_failed(){
        if(! empty($this->validation_errors)){
            return true;
        }
        else{
            return false;
        }
    }
    
}

?>