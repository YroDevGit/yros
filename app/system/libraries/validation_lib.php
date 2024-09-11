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
            set_flash_data($this->validation_temp_error.$inputname, $errors[$inputname]);
        }
    }


    public function set_input_error(string $input, string $message){
        set_flash_data($this->validation_session_error.$input, $message);
    }

    public function get_input_error(string $inputname):string{
        $val = get_flash_data($this->validation_session_error.$inputname);
        if($val==""||$val==null){
            return "";
        }
        else{
            return $val;
        }
    }



    public function validation_failed(){
        if(! empty($this->validation_errors)){
            foreach($_SESSION as $key=>$val){
                if(string_contains($key, $this->validation_session_error)){
                    unset($_SESSION[$key]);
                }
            }
            foreach($_SESSION as $key=>$val){
                if(string_contains($key, $this->validation_temp_error)){
                    $newname = string_replace($key,$this->validation_temp_error, $this->validation_session_error);
                    $_SESSION[$newname] = $val;
                    unset($_SESSION[$key]);
                }
            }
            return true;
        }
        else{
            return false;
        }
    }
    
}

?>