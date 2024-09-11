<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(! function_exists("db_execute_query")){
    function db_execute_query(string $sql, array $param = []) {
        $YROS = &Yros::get_instance();
        return $YROS->dblib->setQuery($sql, $param);   
    }
}

if(! function_exists("db_set_query")){
    function db_set_query(string $sql, array $param = []) {
        $YROS = &Yros::get_instance();
        return $YROS->dblib->setQuery($sql, $param);   
    }
}



if(! function_exists("db_insert")){
    function db_insert(string $table, array $data){
        $YROS = &Yros::get_instance();
        return $YROS->dblib->insert($table, $data);
    }
}

if(! function_exists("db_delete")){
    function db_delete(string $table, array $conditions){
        $YROS = &Yros::get_instance();
        return $YROS->dblib->deleteQuery($table, $conditions);
    }
}

if(! function_exists("db_update")){
    function db_update(string $table, array $data, array $conditions){
        $YROS = &Yros::get_instance();
        return $YROS->dblib->updateQuery($table, $data, $conditions);
    }
}

?>