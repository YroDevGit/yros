<?php
class Db_lib{
    public $storage = [];
    public $db_errors = [];
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
        $ret = $this->setQuery($query, $parameters);
        return $ret;
    }

    public function select_all_where(string|array $table, array|string $where, array $param = []){
        $sql = "";
        $par = [];
        if(is_array($table)){
            $table = $table[0] ? $table[0] : "";
        }
        if(is_array($where)){
            if(array_is_multidimensional($where)){
                $eex = [];
                foreach($where as $key=>$value){
                    $eex[] = $key." = ?";
                    $par[] = $value;
                }
                $imp = implode(" & ", $eex);
                $param = $par;
                $sql = "SELECT * from $table where ".$imp;
            }else{
                $imp = implode(" & ", $where);
                $sql = "SELECT * from $table where ".$imp;
            }
        }else{
            $sql = "SELECT * from $table where ".$where;  
        }
        return $this->setQuery($sql, $param)['data'];
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
            $err = $e->getMessage();
            $disp = display_error($err);
            write_sql_log($disp);
            $YROS->db->pdo_success = false;
            $this->db_errors[] = $err;
            return ["code"=>-1, "status"=>"error", "message"=>$err, "file"=>$disp];
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
            $err = $e->getMessage();
            $disp = display_error($err);
            write_sql_log($disp);
            $YROS->db->pdo_success = false;
            $this->db_errors[] = $err;
            $return = ["code"=>-1, "status"=>"error", "message"=>$err, "file"=>$disp];
            return $return;
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
            $err = $e->getMessage();
            $disp = display_error($err);
            write_sql_log($disp);
            $YROS->db->pdo_success = false;
            $this->db_errors[] = $err;
            return ["code"=>-1, "status"=>"error", "message"=>$err, "file"=>$disp];
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
            $err = $e->getMessage();
            $disp = display_error($err);
            write_sql_log($disp);
            $YROS->db->pdo_success = false;
            $this->db_errors[] = $err;
            return ["code"=>-1, "status"=>"error", "message"=>$err, "file"=>$disp];
        }
    }



    public function db_dump(array $result, string $error_map=""){
        if(! isset($result['code'])){
            die("Key: code is not found inside result array");
        }
        if($result['code'] != SUCCESS){
            if($error_map=="" || $error_map==null){
                show_error($result['message']);
            }else{
                trigger_error("Error: ".$result['message']." @ ".$error_map);exit;
            }
        }
    }

   public function db_result_dump(array $result, string $key=null):bool{
        $ret = false;
        if(! isset($result['code'])){
            die("code is not found inside result array");
        }
        if($result['code'] != SUCCESS){
            show_error(" ===> SQL ERROR: ".$result['message']);
        }else{
            if($key != null && $key != ""){
                if(! isset($result[$key])){
                    die("Your Key: [$key] is not found inside result array");
                }      
            }
            $ret = true;
        }
        return $ret;
   }

    public function db_last_query(){
        $YROS = &Yros::get_instance();
        return $YROS->db->getLastQuery();
    }


}

?>