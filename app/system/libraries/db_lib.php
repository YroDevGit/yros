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


    public function execute_insert(array $dataset) {
        $table = $dataset['table'] ?? $dataset['into'] ?? null;
        if (!$table || empty($dataset['data'])) {
            return false;
        }
    
        $columns = array_keys($dataset['data']);
        $placeholders = array_fill(0, count($columns), '?');
        $values = array_values($dataset['data']);
    
        $query = "INSERT INTO `$table` (`" . implode("`, `", $columns) . "`) VALUES (" . implode(", ", $placeholders) . ")";
    
        // Debugging: Replace placeholders with actual values
        $finalQuery = $this->replace_placeholders($query, $values);
    
        return $this->setQuery($finalQuery,[]);
    }


    public function execute_update(array $dataset) {
        $table = $dataset['table'] ?? null;
        if (!$table || empty($dataset['data']) || empty($dataset['where'])) {
            return false;
        }
    
        $setClauses = [];
        $values = [];
    
        foreach ($dataset['data'] as $column => $value) {
            $setClauses[] = "`$column` = ?";
            $values[] = $value;
        }
    
        $query = "UPDATE `$table` SET " . implode(", ", $setClauses);
        $boundValues = [];
    
        // Add WHERE conditions
        if (!empty($dataset['where'])) {
            $whereCondition = $this->build_conditions($dataset['where'], $boundValues, 'AND');
            $query .= " WHERE " . $whereCondition;
        }
    
        $values = array_merge($values, $boundValues);
    
        // Debugging: Replace placeholders with actual values
        $finalQuery = $this->replace_placeholders($query, $values);
    
        return $this->setQuery($finalQuery,[]);
    }


    public function execute_delete(array $dataset) {
        $table = $dataset['table'] ?? $dataset['from'] ?? null;
        if (!$table) {
            return "Error: No table specified";
        }
    
        if (empty($dataset['where']) && empty($dataset['or_where']) && empty($dataset['like']) && empty($dataset['or_like'])) {
            return "Error: DELETE operation requires at least one WHERE condition to prevent full table deletion.";
        }
    
        $query = "DELETE FROM `$table`";
        $boundValues = [];
        $conditions = [];
    
        // Handle AND conditions
        if (!empty($dataset['where'])) {
            $conditions[] = $this->build_conditions($dataset['where'], $boundValues, 'AND');
        }
    
        // Handle OR conditions
        if (!empty($dataset['or_where'])) {
            $conditions[] = $this->build_conditions($dataset['or_where'], $boundValues, 'OR');
        }
    
        // Handle LIKE conditions
        if (!empty($dataset['like'])) {
            $conditions[] = $this->build_conditions($dataset['like'], $boundValues, 'AND', 'LIKE');
        }
    
        // Handle OR LIKE conditions
        if (!empty($dataset['or_like'])) {
            $conditions[] = $this->build_conditions($dataset['or_like'], $boundValues, 'OR', 'LIKE');
        }
    
        // Combine conditions properly
        $conditions = array_filter($conditions);
        if (!empty($conditions)) {
            $query .= " WHERE " . implode(" OR ", $conditions);
        }
    
        // Debugging: Replace placeholders with actual values
        $finalQuery = $this->replace_placeholders($query, $boundValues);
    
        return $this->setQuery($finalQuery,[]);
    }
    
    
    
    

    public function execute_select(array $dataset) {
        $table = $dataset['table'] ?? $dataset['from'] ?? null;
        $table = is_array($table) ? $table[0] : $table;
    
        $columns = $dataset['columns'] ?? $dataset['select'] ?? ["*"];
        $columnsString = is_array($columns) ? implode(", ", $columns) : $columns;
    
        $query = "SELECT $columnsString FROM `$table`";
        $boundValues = [];
    
        // Build conditions
        $conditions = [];
        if (!empty($dataset['where'])) {
            $conditions[] = $this->build_conditions($dataset['where'], $boundValues, 'AND');
        }
        if (!empty($dataset['or_where'])) {
            $conditions[] = $this->build_conditions($dataset['or_where'], $boundValues, 'OR');
        }
        if (!empty($dataset['like'])) {
            $conditions[] = $this->build_conditions($dataset['like'], $boundValues, 'AND', 'LIKE');
        }
        if (!empty($dataset['or_like'])) {
            $conditions[] = $this->build_conditions($dataset['or_like'], $boundValues, 'OR', 'LIKE');
        }
    
        // Filter out empty conditions and join them properly
        $conditions = array_filter($conditions);
        if (!empty($conditions)) {
            $query .= " WHERE " . implode(" OR ", $conditions);
        }
    
        // Add GROUP BY if specified
        if (!empty($dataset['group_by'])) {
            $groupBy = is_array($dataset['group_by']) ? implode(", ", $dataset['group_by']) : $dataset['group_by'];
            $query .= " GROUP BY $groupBy";
        }
    
        // Add HAVING if specified
        if (!empty($dataset['having'])) {
            $query .= " HAVING " . (is_array($dataset['having']) ? implode(" AND ", $dataset['having']) : $dataset['having']);
        }
    
        // Add ORDER BY if specified
        if (!empty($dataset['order_by'])) {
            $orderBy = is_array($dataset['order_by']) ? implode(", ", $dataset['order_by']) : $dataset['order_by'];
            $query .= " ORDER BY $orderBy";
        }
    
        // Add LIMIT if specified
        if (!empty($dataset['limit'])) {
            $query .= " LIMIT " . (int) $dataset['limit'];
        }
    
        // Add OFFSET if specified
        if (!empty($dataset['offset'])) {
            $query .= " OFFSET " . (int) $dataset['offset'];
        }
    
        // Debug: Replace placeholders for debugging
        $finalQuery = $this->replace_placeholders($query, $boundValues);
    
        return $this->setQuery($finalQuery,[]);
    }
    
    
    /**
     * Builds WHERE, OR WHERE, LIKE, and OR LIKE conditions.
     */
    private function build_conditions($conditions, &$boundValues, $logicalOperator = 'AND', $matchType = '=') {
        if (!$conditions) return "";
    
        $clauses = [];
    
        // If conditions is a string, use it directly
        if (is_string($conditions)) {
            return $conditions;
        }
    
        // Handle associative array (e.g., ["id" => 1, "name" => "test"])
        if ($this->is_associative($conditions)) {
            foreach ($conditions as $column => $value) {
                if ($matchType == 'LIKE') {
                    $boundValues[] = "%$value%";
                    $clauses[] = "`$column` LIKE ?";
                } else {
                    $boundValues[] = $value;
                    $clauses[] = "`$column` = ?";
                }
            }
        } else { // Handle indexed array (e.g., [["id", "=", 1], ["name", "LIKE", "%test%"]])
            foreach ($conditions as $condition) {
                if (is_array($condition) && count($condition) === 3) {
                    [$column, $operator, $value] = $condition;
                    if ($matchType == 'LIKE') {
                        $value = "%$value%";
                    }
                    $boundValues[] = $value;
                    $clauses[] = "`$column` $operator ?";
                }
            }
        }
    
        // Join all conditions correctly
        return !empty($clauses) ? "(" . implode(" $logicalOperator ", $clauses) . ")" : "";
    }
    
    /**
     * Detects if an array is associative.
     */
    private function is_associative(array $array) {
        return array_keys($array) !== range(0, count($array) - 1);
    }
    
    /**
     * Replace placeholders in query with actual values for debugging.
     */
    private function replace_placeholders($query, $values) {
        foreach ($values as $value) {
            $query = preg_replace('/\?/', "'" . addslashes($value) . "'", $query, 1);
        }
        return $query;
    }
    

    public function insert($table, $data){
        $YROS = &Yros::get_instance();
        try{
            $result = $YROS->db->insert($table, $data);
            if($result==-1){
                return ["code"=>-1, "status"=>"error", "message"=>"Data not inserted", "query"=>$this->db_last_query()];
            }
            else{
                return ["code"=>SUCCESS, "status"=>"success", "message"=>"Data inserted", "insert_id"=>$result,"ID"=>$result, "id"=>$result, "query"=>$this->db_last_query()];
            }

        }
        catch (Exception $e) {
            $lastquery = $this->db_last_query();
            $err = $e->getMessage();
            $disp = display_error111($err);
            write_sql_log($disp);
            write_sql_error($disp, $lastquery);
            $YROS->db->pdo_success = false;
            $this->db_errors[] = $disp;
            return ["code"=>-1, "status"=>"error", "message"=>$err, "file"=>$disp, "query"=>$lastquery];
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
            
            if (stripos(strtolower(trim($command)), 'select') === 0) {
                $frow = [];
                $has_data = false;
                if(!empty($results)){
                    $frow = isset($results[0]) ? $results[0] : [];
                    $has_data = true;
                }
                return ["code"=>SUCCESS, "status"=>"success", "has_data"=>$has_data, "result"=>$results, "data"=>$results, "message"=>"data has been fetched", "first_row"=>$frow, "single" => $frow, "query"=>$this->db_last_query()];
            }
            else if(stripos(strtolower(trim($sql)), 'insert') === 0){
                return ["code"=>SUCCESS, "status"=>"success", "message" => "Data inserted successfully", "insert_id"=>$YROS->db->lastInsertId(), "parameters"=>$param, "query"=>$this->db_last_query()];
            }else if(stripos(strtolower(trim($sql)), 'update') === 0){
                return ["code"=>SUCCESS, "status"=>"success", "message" => "Data updated successfully", "parameters"=>$param, "query"=>$this->db_last_query()];
            }else if(stripos(strtolower(trim($sql)), 'delete') === 0){
                return ["code"=>SUCCESS, "status"=>"success", "message" => "Data deleted successfully", "parameters"=>$param, "query"=>$this->db_last_query()];
            }
            else{
                return ["code"=>SUCCESS, "status"=>"success", "message" => $results, "parameters"=>$param, "query"=>$this->db_last_query()];
            }
            }
        catch (Exception $e) {
            $lastquery = $this->db_last_query();
            $err = $e->getMessage();
            $disp = display_error111($err);
            write_sql_log($disp);
            write_sql_error($disp, $lastquery);
            $YROS->db->pdo_success = false;
            $this->db_errors[] = $disp;
            $return = ["code"=>-1, "status"=>"error", "message"=>$err, "file"=>$disp, "query"=>$lastquery];
            return $return;
        }
    }


    public function deleteQuery(string $table, array $conditions){
        $YROS = &Yros::get_instance();
        try{
            $result = $YROS->db->delete($table, $conditions);
            if(isset($result)){
                if($result == 0||$result=="0"){
                    return ["code"=>200, "status"=>"success", "message"=>"Success, but no Data has been deleted.", "affected_rows"=>$result, "conditions"=>$conditions, "query"=>$this->db_last_query()];
                }
                else{
                    return ["code"=>200, "status"=>"success", "message"=>"Data deleted successfully","affected_rows"=>$result, "conditions"=>$conditions, "query"=>$this->db_last_query()];
                }
            }
            else{
                return ["code"=>-1, "status"=>"error", "message"=>"Error in deleteQuery db_lib.php libraries", "query"=>$this->db_last_query()];

            }
        }
        catch(Exception $e){
            $lastquery = $this->db_last_query();
            $err = $e->getMessage();
            $disp = display_error111($err);
            write_sql_log($disp);
            write_sql_error($disp, $lastquery);
            
            $YROS->db->pdo_success = false;
            $this->db_errors[] = $disp;
            return ["code"=>-1, "status"=>"error", "message"=>$err, "file"=>$disp, "query"=>$lastquery];
        }    
    }

    public function updateQuery(string $table, array $data, array $conditions){
        $YROS = &Yros::get_instance();
        try{
            $result = $YROS->db->update($table, $data, $conditions);
            if(isset($result)){
                if($result == 0||$result=="0"){
                    return ["code"=>200, "status"=>"success", "message"=>"Success, but no data has been affected", "affected_rows"=>$result, "conditions"=>$conditions, "query"=>$this->db_last_query()];
                }
                else{
                    return ["code"=>200, "status"=>"success", "message"=>"Data updated successfully", "affected_rows"=>$result, "conditions"=>$conditions, "query"=>$this->db_last_query()];
                }
            }
            else{
                return ["code"=>-1, "status"=>"error", "message"=>"Error in updateQuery db_lib.php libraries", "query"=>$this->db_last_query()];

            }
        }
        catch(Exception $e){
            $lastquery = $this->db_last_query();
            $err = $e->getMessage();
            $disp = display_error111($err);
            write_sql_log($disp);
            write_sql_error($disp, $lastquery);
            $YROS->db->pdo_success = false;
            $this->db_errors[] = $disp;
            return ["code"=>-1, "status"=>"error", "message"=>$err, "file"=>$disp, "query"=>$lastquery];
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