<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Array_lib{
    public function __construct()
	{
		
	}

    public function isJsonArray($input){
        if (!is_string($input)) {
            return false;
        }
    
        $decoded = json_decode($input, true);
    
        return (json_last_error() == JSON_ERROR_NONE) && is_array($decoded);
    }
}

?>