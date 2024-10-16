<?php

class Validation_lib{
    public $validation_errors;
    public $validation_session_error = "yros_1005_codeyro_";
    public $validation_temp_error = "yros_1005_temp_codeyro_";
    public function __construct()
	{

	}

    public function validate_file(string $inputfile, string $label, string $validation, int $type = 1){
        $rules = explode('|', $validation);
    
        $inputData = $_FILES[$inputfile] ?? [];

        $errors = [];
        $rules = array_reverse($rules);
        foreach($rules as $rule){
            $parts = explode(':', $rule);
            $ruleName = $parts[0];
            $ruleParam = $parts[1] ?? null;
            switch($ruleName){
                case "file":
                case "files":
                    $cond = 1;
                    break;
                case "required":
                case "important":
                    display($inputData);
                    if(empty($inputData)){
                        $errors[$inputfile] = "{$label} is required.";
                        if($type == 2){
                            $errors[$inputfile] = "Required";
                        }
                    }else{
                        if($inputData['full_path'] == "" || $inputData['full_path'] == null){
                            $errors[$inputfile] = "{$label} is required."; 
                            if($type == 2){
                                $errors[$inputfile] = "Required";
                            }
                        }
                    }
                    break;
                
                case "max":
                    if($_FILES[$inputfile]['full_path']!="" && $_FILES[$inputfile]['full_path'] != null){
                        $fsize = intval($inputData['size'])  / 1024;
                        if($fsize > intval($ruleParam)){
                            $errors[$inputfile] = "{$label} should not more than {$ruleParam}mb"; 
                            if($type == 2){
                                $errors[$inputfile] = "Size limit {$ruleParam}mb";
                            }
                        }
                    }
                    break;
                case "image":
                    if($_FILES[$inputfile]['full_path']!="" && $_FILES[$inputfile]['full_path'] != null){
                        $nm = $inputData['name'];
                        $fileExtension = strtolower(pathinfo($nm, PATHINFO_EXTENSION));
                        $arr = ["jpg", "jpeg", "png", "svg", "webp", "ico", "gif"];
                        if(! in_array($fileExtension, $arr)){
                            $errors[$inputfile] = "{$label} should be an image/picture"; 
                            if($type == 2){
                                $errors[$inputfile] = "Image/Picture only";
                            }
                        }
                    }
                    break;
                
                case "video":
                case "movie":
                    if($_FILES[$inputfile]['full_path']!="" && $_FILES[$inputfile]['full_path'] != null){
                        $nm = $inputData['name'];
                        $fileExtension = strtolower(pathinfo($nm, PATHINFO_EXTENSION));
                        $videoArr = [
                            "mp4", "mkv", "avi", "mov", "wmv", "flv", 
                            "webm", "mpeg", "mpg", "3gp"
                        ];
                    
                        if (!in_array($fileExtension, $videoArr)) {
                            $errors[$inputfile] = "{$label} should be a video";
                    
                            if ($type == 2) {
                                $errors[$inputfile] = "Videos only";
                            }
                        }
                    }
                    break;
                case "document":
                case "file":
                    if($_FILES[$inputfile]['full_path']!="" && $_FILES[$inputfile]['full_path'] != null){
                        $nm = $inputData['name'];
                        $fileExtension = strtolower(pathinfo($nm, PATHINFO_EXTENSION));
                        $arr = [
                            "pdf", "doc", "docx", "txt", "rtf", "odt", "xml", 
                            "wps", "xls", "xlsx", "ppt", "pptx", 
                            "pdf", "doc", "docx", "txt", "rtf", "odt", "xml", 
                            "wps", "xls", "xlsx", "ppt", "pptx"
                        ];
                    
                        if (!in_array($fileExtension, $arr)) {
                            $errors[$inputfile] = "{$label} should be a document";
                    
                            if ($type == 2) {
                                $errors[$inputfile] = "Document only";
                            }
                        }
                    }
                    break;

                case "audio":
                case "music":
                    if($_FILES[$inputfile]['full_path']!="" && $_FILES[$inputfile]['full_path'] != null){
                        $nm = $inputData['name'];
                        $fileExtension = strtolower(pathinfo($nm, PATHINFO_EXTENSION));
                        $audioArr = [
                            "mp3", "wav", "aac", "ogg", "flac", 
                            "m4a", "wma", "opus"
                        ];
                    
                        if (!in_array($fileExtension, $audioArr)) {
                            $errors[$inputfile] = "{$label} should be an audio file ".$fileExtension;
                    
                            if ($type == 2) {
                                $errors[$inputfile] = "Audio files only";
                            }
                        }
                    }
                    break;

                case "type":
                    if($_FILES[$inputfile]['full_path']!="" && $_FILES[$inputfile]['full_path'] != null){
                        $nm = $inputData['name'];
                        $fileExtension = strtolower(pathinfo($nm, PATHINFO_EXTENSION));
                        if($ruleParam == "image" || $ruleParam == "picture" || $ruleParam == "photo"){
                            $arr = ["jpg", "jpeg", "png", "svg", "webp", "ico", "gif"];
                            if(! in_array($fileExtension, $arr)){
                                $errors[$inputfile] = "{$label} should be an image/picture"; 
                                if($type == 2){
                                    $errors[$inputfile] = "Image/Picture only";
                                }
                            }
                        }
                        if ($ruleParam == "document" || $ruleParam == "office") {
                            $arr = [
                                "pdf", "doc", "docx", "txt", "rtf", "odt", "xml", 
                                "wps", "xls", "xlsx", "ppt", "pptx", 
                                "pdf", "doc", "docx", "txt", "rtf", "odt", "xml", 
                                "wps", "xls", "xlsx", "ppt", "pptx"
                            ];
                        
                            if (!in_array($fileExtension, $arr)) {
                                $errors[$inputfile] = "{$label} should be a document";
                        
                                if ($type == 2) {
                                    $errors[$inputfile] = "Documents only";
                                }
                            }
                        }
                        if ($ruleParam == "video" || $ruleParam == "movie") {
                            $videoArr = [
                                "mp4", "mkv", "avi", "mov", "wmv", "flv", 
                                "webm", "mpeg", "mpg", "3gp"
                            ];
                        
                            if (!in_array($fileExtension, $videoArr)) {
                                $errors[$inputfile] = "{$label} should be a video";
                        
                                if ($type == 2) {
                                    $errors[$inputfile] = "Videos only";
                                }
                            }
                        }
                        if ($ruleParam == "audio" || $ruleParam == "music") {
                            $audioArr = [
                                "mp3", "wav", "aac", "ogg", "flac", 
                                "m4a", "wma", "opus"
                            ];
                        
                            if (!in_array($fileExtension, $audioArr)) {
                                $errors[$inputfile] = "{$label} should be an audio file";
                        
                                if ($type == 2) {
                                    $errors[$inputfile] = "Audio files only";
                                }
                            }
                        }
                    }
                    break;
                
                case "accept":
                    if($_FILES[$inputfile]['full_path']!="" && $_FILES[$inputfile]['full_path'] != null){
                        $nm = $inputData['name'];
                        $fileExtension = strtolower(pathinfo($nm, PATHINFO_EXTENSION));
                        $xpl = explode(",", $ruleParam);
                        if(! in_array($fileExtension, $xpl)){
                            $impp = implode(", ", $xpl);
                            $errors[$inputfile] = "{$label} only accepts ".$impp. " files";
                            if ($type == 2) {
                                $errors[$inputfile] = $impp." files only";
                            }
                        }
                    }
                    break;

                default: $errors[$inputfile] = "Unknown validation rule: {$ruleName}";

            }
        }
        if (!empty($errors)) {
            $this->validation_errors = $errors;
            $_SESSION[$this->validation_temp_error.$inputfile] = $errors[$inputfile];
        }
    }

    public function validate_input(string $inputname, string $label, string $validation, int $type = 1){
        $rules = explode('|', $validation);
        if(in_array("file", $rules) || in_array("files", $rules)){
            $this->validate_file($inputname, $label, $validation, $type);
            return;
        }
    
        $inputData = $_POST[$inputname] ?? '';

        $errors = [];
        $rules = array_reverse($rules);
        foreach ($rules as $rule) {
            $parts = explode(':', $rule);
            $ruleName = $parts[0];
            $ruleParam = $parts[1] ?? null;
    
            switch ($ruleName) {
                case "important":
                case 'required':
                    if (empty(trim($inputData))) {
                        $errors[$inputname] = "{$label} is required.";
                        if($type==2){
                            $errors[$inputname] = "Required";  
                        }
                    }
                    break;
                
                case "number":
                case "numeric":
                case "int":
                case "integer":
                    if($inputData != "" && $inputData != null){
                        if(! is_numeric($inputData)){
                            $errors[$inputname] = "{$label} should be a number.";
                            if($type==2){
                                $errors[$inputname] = "Number only";  
                            }
                        }
                    }
                    break;

                case "string":
                case "text":
                    if($inputData != "" && $inputData != null){
                        if(! is_string($inputData)){
                            $errors[$inputname] = "{$label} should be a string/letters.";
                            if($type==2){
                                $errors[$inputname] = "Plain text only";  
                            }
                        }
                    }
                    break;

                case "length":
                case "characters":
                case "character":
                case "size":
                    if($inputData != "" && $inputData != null){
                        if (strlen($inputData) != (int)$ruleParam) {
                            $errors[$inputname] = "{$label} should have {$ruleParam} characters.";
                            if($type==2){
                                if(strlen($inputData) > (int)$ruleParam){
                                    $errors[$inputname] = "{$ruleParam} Characters only";  
                                }
                                if(strlen($inputData) < (int)$ruleParam){
                                    $errors[$inputname] = "Needs {$ruleParam} Characters";  
                                } 
                            }
                        }

                    }
                    break;
    
                case 'max':
                    if($inputData != "" && $inputData != null){
                        if (strlen($inputData) > (int)$ruleParam) {
                            $errors[$inputname] = "{$label} cannot be more than {$ruleParam} characters.";
                            if($type==2){
                                $errors[$inputname] = "Above {$ruleParam} characters";  
                            }
                        }
                    }
                    break;

                case 'min':
                    if($inputData != "" && $inputData != null){
                        if (strlen($inputData) < (int)$ruleParam) {
                            $errors[$inputname] = "{$label} cannot be less than {$ruleParam} characters.";
                            if($type==2){
                                $errors[$inputname] = "below {$ruleParam} characters";  
                            }
                        }
                    }
                    break;
                case "no-symbols":
                    if($inputData != "" && $inputData != null){
                        if(! preg_match('/^[a-zA-Z0-9\s]*$/', $inputData)){
                            $errors[$inputname] = "{$label} should not have symbols.";
                            if($type==2){
                                $errors[$inputname] = "Remove symbols";  
                            }
                        }
                    }
                    break;
                case "with-symbols":
                    if($inputData != "" && $inputData != null){
                        if(preg_match('/^[a-zA-Z0-9\s]*$/', $inputData)){
                            $errors[$inputname] = "{$label} should have a symbols";
                            if($type==2){
                                $errors[$inputname] = "Add symbols";  
                            }
                        }
                    }
                    break;
                case "email":
                    if($inputData != "" && $inputData != null){
                        if(! filter_var($inputData, FILTER_VALIDATE_EMAIL)){
                            $errors[$inputname] = "{$label} should be a valid email.";
                            if($type==2){
                                $errors[$inputname] = "Invalid email";  
                            }
                        }
                    }
                    break;
                case "date":
                    if($inputData != "" && $inputData != null){
                        if($this->isValidDate($inputData, $ruleParam) == false){
                            $errors[$inputname] = "{$label} should be a valid date.";
                                if($type==2){
                                    $errors[$inputname] = "Invalid date";  
                            }
                        }
                    }
                    break;
                case "modern-password":
                    $arr = [];
                    $h_error = false;
                    if(preg_match('/^[a-zA-Z0-9\s]*$/', $inputData)){
                        $h_error = true;
                        $arr[] = "Symbol(s)";
                    }
                    if(! preg_match('/[a-zA-Z]/', $inputData)){
                        $h_error = true;
                        $arr[] = "Letter(s)";
                    }
                    if(! preg_match('/\d/', $inputData)){
                        $h_error = true;
                        $arr[] = "Number(s)";
                    }
                    if($ruleParam != null && $ruleParam != ""){
                        if(strlen($inputData) < intval($ruleParam)){
                            $h_error = true;
                            $arr[] = "$ruleParam or more characters";
                        }
                    }
                    
                    if($h_error==true){
                        $errs = implode(", ", $arr);
                        $errors[$inputname] = "{$label} should have ".$errs.".";
                    }
                    break;
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
        $errors[$input] = $message;
        $this->validation_errors = $errors;
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

    public function get_all_input_error(){
        $YROS = &Yros::get_instance();
        $all = $YROS->yros_input_validation_errors;
        $ret = [];
        foreach($all as $key=>$value){
            $newkey = str_replace($this->validation_temp_error, "", $key);
            $ret[$newkey] = $value;
        }
        return $ret;
    }
    


    public function validation_failed(){
        if(! empty($this->validation_errors)){
            return true;
        }
        else{
            return false;
        }
    }

    public function isValidDate($date, $format = 'Y-m-d') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }
    
}

?>