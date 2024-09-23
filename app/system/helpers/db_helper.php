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
    function db_insert(string $table, string|array $data){
        $YROS = &Yros::get_instance();
        if(is_array($data)){
            return $YROS->dblib->insert($table, $data);
        }
        else{
            $arr = preg_split('/[&|]/', $data);
            $dt = array();
            foreach($arr as $key){
                $k = $key;
                $kv = explode("=", $k);
                $kk = $kv[0];
                $vv = $kv[1];
                $dt[$kk] = $vv;
            }
            return $YROS->dblib->insert($table, $dt);
        }
        
    }
}

if(! function_exists("db_delete")){
    function db_delete(string $table, array|string $conditions){
        $YROS = &Yros::get_instance();
        if(is_array($conditions)){
            return $YROS->dblib->deleteQuery($table, $conditions);
        }
        else{
            $arr = preg_split('/[&|]/', $conditions);
            $dt = array();
            foreach($arr as $key){
                $k = $key;
                $kv = explode("=", $k);
                $kk = $kv[0];
                $vv = $kv[1];
                $dt[$kk] = $vv;
            }
            return $YROS->dblib->deleteQuery($table, $dt);
        }
    }
}

if(! function_exists("db_update")){
    function db_update(string $table, array $data, array $conditions){
        $YROS = &Yros::get_instance();
        return $YROS->dblib->updateQuery($table, $data, $conditions);
    }
}

if(! function_exists("db_last_query")){
    function db_last_query(){
        $YROS = &Yros::get_instance();
        return $YROS->dblib->db_last_query();
    }
}

if(! function_exists("db_tracker_start")){
    function db_tracker_start(){
        $YROS = &Yros::get_instance();
        $YROS->db->beginTransaction();
        FunctionPair::callFirst('db_tracker_start', 'db_tracker_complete');
    }
}

if(! function_exists("db_tracker_complete")){
    function db_tracker_complete(){
        $YROS = &Yros::get_instance();
        if ($YROS->db->inTransaction()) {
            $YROS->db->commit();
        } else {
            trigger_error("tracker not started, db_tracker_start() must be called", E_USER_WARNING);
        }
        FunctionPair::callSecond('db_tracker_complete');
    }
}
FunctionPair::pair('db_tracker_start', 'db_tracker_complete');

?>