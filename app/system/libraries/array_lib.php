<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Array_lib{
    private $currentIndex = 0;
    public function __construct()
	{
		
	}

    public function fetch_array(&$data) {
        if ($this->currentIndex < count($data)) {
            return $data[$this->currentIndex++];
        } else {
            $this->currentIndex = 0;
            return false;
        }
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