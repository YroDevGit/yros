<?php
//Please only modify the value, not the key names.

// Header: apikey
$api_config['api_key_enabled'] = false;  //Enable or Disable api key/ disable for public api
$api_config['apikey'] = ["yros"]; //Api keys for authentication, you can add more

// Header: yros_key
$api_config['yros_key_enabled'] = false;  //Enable or Disable api key/ disable for public api
$api_config['yros_key'] = ["yros"]; //Api keys for authentication, you can add more


$api_config['local_api_link'] = "http://localhost/php_raw/api/";


$api_config['api_default_headers'] = [ // default api headers
    "Content-Type: application/json",
    "Access-Control-Allow-Origin: *",
    "Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS",
    "Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With"
];



?>