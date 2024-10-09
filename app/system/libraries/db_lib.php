<?php
class Db_lib{
    public $storage = [];
    public function __construct()
	{

	}


    public function set_db_data(int $unique, array $data):void{

        $id = "";
        if(is_string($unique)){
            $id = $unique;
        }
        else{
            $id = strval($unique);
        }
        $key = array_key_first($data);
        $this->storage[$id][$key] = $data[$key];
    }

    public function get_db_data(int $unique):array{
        $id = "";
        if(is_string($unique)){
            $id = $unique;
        }
        else{
            $id = strval($unique);
        }
        $ret = $this->storage[$id];
        $this->storage[$id] = [];
        return $ret;
    }

    public function clear_db_data(){
        $this->storage = [];
    }

    public function db_select(string $table, array|string $columns = ['*'], string $conditions = '', array $parameters = []) {
        $str = "";
        if(is_string($columns)){
            if($columns=="" || $columns==null){
                $str = "*";
            }
            else{
                $str = $columns;
            }
        }
        if(is_array($columns)){
            if(empty($columns)){
                $str = "*";
            }
            else{
                $dt = implode(', ', $columns);
                $str = $dt;
            }
        }
        $query= 'SELECT ' . $str . ' FROM ' . $table . ' ' . $conditions;
        return $this->setQuery($query, $parameters);
    }

    public function insert($table, $data){
        $YROS = &Yros::get_instance();
        try{
            $result = $YROS->db->insert($table, $data);
            if($result==-1){
                return ["code"=>-1, "status"=>"error", "message"=>"Data not inserted"];
            }
            else{
                return ["code"=>SUCCESS, "status"=>"success", "message"=>"Data inserted", "insert_id"=>$result,"ID"=>$result, "id"=>$result];
            }

        }
        catch (Exception $e) {
            write_sql_log("Previous query failed: ".$e->getMessage()." @ ".$e->getFile()." line ".$e->getLine());
            $YROS->db->pdo_success = false;
            return ["code"=>-1, "status"=>"error", "message"=>$e->getMessage(), "file"=>$e->getFile()." line ".$e->getLine()];
        }
    }

    public function setQuery($sql, $param){
        if (empty($sql)) {
            throw new Exception("SQL query cannot be empty.");
        }
        try{
            $command = $sql;
            $YROS = &Yros::get_instance();
            $YROS->db->sql_query($command, $param);
            $results = $YROS->db->resultSet();
            
            if (stripos(trim($command), 'select') === 0) {
                $frow = [];
                $has_data = false;
                if(!empty($results)){
                    $frow = isset($results[0]) ? $results[0] : [];
                    $has_data = true;
                }
                return ["code"=>SUCCESS, "status"=>"success", "has_data"=>$has_data, "result"=>$results, "data"=>$results, "message"=>"data has been fetched", "first_row"=>$frow, "single" => $frow];
            }
            else if(stripos(trim($sql), 'insert') === 0){
                return ["code"=>SUCCESS, "status"=>"success", "message" => "Data inserted successfully", "insert_id"=>$YROS->db->lastInsertId(), "parameters"=>$param];
            }
            else{
                return ["code"=>SUCCESS, "status"=>"success", "message" => $results, "parameters"=>$param];
            }
            }
        catch (Exception $e) {
            write_sql_log("Previous query failed: ".$e->getMessage()." @ ".$e->getFile()." line ".$e->getLine());
            $YROS->db->pdo_success = false;
            return ["code"=>-1, "status"=>"error", "message"=>$e->getMessage(), "file"=>$e->getFile()." line ".$e->getLine()];
        }
    }


    public function deleteQuery(string $table, array $conditions){
        $YROS = &Yros::get_instance();
        try{
            $result = $YROS->db->delete($table, $conditions);
            if(isset($result)){
                if($result == 0||$result=="0"){
                    return ["code"=>200, "status"=>"success", "message"=>"Success, but no Data has been deleted.", "affected_rows"=>$result, "conditions"=>$conditions];
                }
                else{
                    return ["code"=>200, "status"=>"success", "message"=>"Data deleted successfully","affected_rows"=>$result, "conditions"=>$conditions];
                }
            }
            else{
                return ["code"=>-1, "status"=>"error", "message"=>"Error in deleteQuery db_lib.php libraries"];

            }
        }
        catch(Exception $e){
            write_sql_log("Previous query failed: ".$e->getMessage()." @ ".$e->getFile()." line ".$e->getLine());
            $YROS->db->pdo_success = false;
            return ["code"=>-1, "status"=>"error", "message"=>$e->getMessage(), "file"=>$e->getFile()." line ".$e->getLine()];
        }    
    }

    public function updateQuery(string $table, array $data, array $conditions){
        $YROS = &Yros::get_instance();
        try{
            $result = $YROS->db->update($table, $data, $conditions);
            if(isset($result)){
                if($result == 0||$result=="0"){
                    return ["code"=>200, "status"=>"success", "message"=>"Success, but no data has been deleted", "affected_rows"=>$result, "conditions"=>$conditions];
                }
                else{
                    return ["code"=>200, "status"=>"success", "message"=>"Data updated successfully", "affected_rows"=>$result, "conditions"=>$conditions];
                }
            }
            else{
                return ["code"=>-1, "status"=>"error", "message"=>"Error in updateQuery db_lib.php libraries"];

            }
        }
        catch(Exception $e){
            write_sql_log("Previous query failed: ".$e->getMessage()." @ ".$e->getFile()." line ".$e->getLine());
            $YROS->db->pdo_success = false;
            return ["code"=>-1, "status"=>"error", "message"=>$e->getMessage(), "file"=>$e->getFile()." line ".$e->getLine()];
        }
    }

    public function db_last_query(){
        $YROS = &Yros::get_instance();
        return $YROS->db->getLastQuery();
    }


}

?>