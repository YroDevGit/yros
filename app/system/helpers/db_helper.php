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
    function db_insert(string $table, string|array|int &$data, bool $array_data_remain = false){
        $YROS = &Yros::get_instance();
        if(is_array($data)){
            $ins = $data;
            if($array_data_remain == false){$data = [];}
            return $YROS->dblib->insert($table, $ins);
        }
        elseif(is_string($data)){
            $arr = preg_split('/[&|]/', $data);
            $dt = array();
            foreach($arr as $key){
                $k = $key;
                $kv = explode("=", $k);
                $kk = $kv[0];
                $vv = $kv[1];
                $dt[$kk] = $vv;
            }
            $dtt = $dt;
            return $YROS->dblib->insert($table, $dtt);
        }
        else{
            $dta = $YROS->dblib->get_db_data($data);
            return $YROS->dblib->insert($table, $dta);
        }
        
    }
}

if(! function_exists("db_select")){
    function db_select(string $table, array|string $columns =["*"], string $conditions="", array $parameters =[] ){
        $YROS = &Yros::get_instance();
        return $YROS->dblib->db_select($table, $columns, $conditions, $parameters);
    }
}

if(! function_exists("db_delete")){
    function db_delete(string $table, array|string|int &$conditions, bool $array_data_remain = false){
        $YROS = &Yros::get_instance();
        if(is_array($conditions)){
            $ins = $conditions;
            if($array_data_remain == false){$conditions = [];}
            return $YROS->dblib->deleteQuery($table, $ins);
        }
        elseif(is_string($conditions)){
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
        else{
            $dta = $YROS->dblib->get_db_data($conditions);
            return $YROS->dblib->deleteQuery($table, $dta);
        }
    }
}

if(! function_exists("db_setData")){
    function db_setData(int $group, array $data){
        $YROS = &Yros::get_instance();
        $YROS->dblib->set_db_data($group, $data);
    }
}

if(! function_exists("dbData")){
    function dbData(int $group){
        $YROS = &Yros::get_instance();
        return $YROS->dblib->get_db_data($group);
    }
}

if(! function_exists("db_update")){
    function db_update(string $table, array|int &$data, array|int &$conditions, bool $array_data_remain = false){
        $YROS = &Yros::get_instance();
        if(is_array($data) && is_array($conditions)){
            $dt = $data;
            $cond = $conditions;
            if($array_data_remain==false){$data=[]; $conditions = [];}
            return $YROS->dblib->updateQuery($table, $dt, $cond);
        }
        elseif(! is_array($data) && is_array($conditions)){
            $cond = $conditions;
            if($array_data_remain==false){$conditions=[];}
            return $YROS->dblib->updateQuery($table, $YROS->dblib->get_db_data($data), $cond);
        }
        elseif(is_array($data) && ! is_array($conditions)){
            $dt = $data;
            if($array_data_remain==false){$data=[];}
            return $YROS->dblib->updateQuery($table, $dt, $YROS->dblib->get_db_data($conditions));
        }
        else{
            return $YROS->dblib->updateQuery($table,$YROS->dblib->get_db_data($data), $YROS->dblib->get_db_data($conditions));
        }
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