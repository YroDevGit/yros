<?php
class Db_lib{
    public function __construct()
	{

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
                return ["code"=>SUCCESS, "status"=>"success", "result"=>$results, "data"=>$results, "message"=>"data has been fetched", "first_row"=>$results[0]];
            }
            else if(stripos(trim($sql), 'insert') === 0){
                return ["code"=>SUCCESS, "status"=>"success", "message" => "Data inserted successfully", "insert_id"=>$YROS->db->lastInsertId(), "parameters"=>$param];
            }
            else{
                return ["code"=>SUCCESS, "status"=>"success", "message" => $results, "parameters"=>$param];
            }
            }
        catch (Exception $e) {
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
                    return ["code"=>200, "status"=>"success", "message"=>"Data deleted successfully", "affected_rows"=>$result, "conditions"=>$conditions];
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
                    return ["code"=>200, "status"=>"success", "message"=>"Data updated successfully", "affected_rows"=>$result, "conditions"=>$conditions];
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
            $YROS->db->pdo_success = false;
            return ["code"=>-1, "status"=>"error", "message"=>$e->getMessage(), "file"=>$e->getFile()." line ".$e->getLine()];
        }
    }


}

?>