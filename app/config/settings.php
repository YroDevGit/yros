<?php
/**
 * Yros app settings
 */

$app_settings['page_guide'] = true; // display route and path details below.

$app_settings['error_log'] = false; //Log all php errors // find logs @ app/system/logs/error_logs

$app_settings['save_db_logs'] = false; // log all db activities // find logs @ app/system/logs/sql_logs

$app_settings['save_db_errors'] = true; // log all db activities // find logs @ app/system/logs/sql_logs

$app_settings['views_log'] = true; //Log all view calls

$app_settings['encryption_key'] = "yros"; //set up unique encryption key for security


$app_settings['enable_curly_template'] = false; //Enable {{}} in views files

$app_settings['single_route'] = false; // if page route has set, you can't navigate using controller name/function.



$app_settings['host'] = getenv("APP_HOST"); //set up your host here

$app_settings['port'] = getenv("APP_PORT"); // app server port: example 5010 in http://localhost:5010

//$app_settings['project_root_url'] is the root url of the app. Ex: http://localhost:5010
$app_settings['project_root_url'] = getenv("APP_URL");   // Leave it empty/null for auto detect root url
$app_settings['local_ip'] = getenv("LOCALIPV4");


$app_settings['default_header'] = [ // default headers
    "Access-Control-Allow-Origin: *",
    "Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS",
    "Access-Control-Allow-Headers: *"
];




?>