<?php

class Database
{
    public $pdo;
    private $stmt;
    private $error;

    public $pdo_success = true;
    private $lastQuery;
    private $lastParams = [];
    public $dbn;

    public function __construct($dbConfig)
    {
        $this->dbn = null;
        if($dbConfig['database'] != "" && $dbConfig['database'] != null){
            $this->dbn = $dbConfig['database'];
            $dsn  = "";
            if($dbConfig['driver'] == "mysqli" || $dbConfig['driver'] == "mysql" || $dbConfig['driver'] == "pdo"){
                $dsn = "mysql:host=" . $dbConfig['host'] . ";dbname=" . $dbConfig['database'] . ";charset=" . $dbConfig['charset'];
            }
            elseif($dbConfig['driver']==strtolower("PostgreSQL") || $dbConfig['driver']=="pgsql" || $dbConfig['driver']=="postgres"){
                $dsn = "pgsql:host=" . $dbConfig['host'] . ";dbname=" . $dbConfig['database'];
            }
            

            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_PERSISTENT => true,
            ];

            try {
                $this->pdo = new PDO($dsn, $dbConfig['username'], $dbConfig['password'], $options);
            } catch (PDOException $e) {
                    $this->error = $e->getMessage();
                    die("Database connection failed: " . $this->error);
            }
        }
           
    }

    public function myPDO(){
        if($this->dbn=="" || $this->dbn ==null){
            die("You haven't yet set up database/dbname in your system.");
        }
        else{
            return $this->pdo;
        }
    }

    public function sql_query(string $sql, $params = [])
    {
        $this->lastQuery = $sql;
        $this->lastParams = $params;
        $this->stmt = $this->myPDO()->prepare($sql);
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                if(is_array($value)){
                    show_error("Table (Column) Value should not be an array. ".json_encode($value));
                    exit;
                }
                if (is_numeric($key)) {
                    $this->stmt->bindValue($key + 1, $value);
                } else {
                    $this->stmt->bindValue($key, $value);
                }
            }
        }
    }

    public function delete($table, $conditions = [])
    {
        $sql = "DELETE FROM $table";

        if (!empty($conditions)) {
            $sql .= " WHERE ";

            $whereClause = [];
            foreach ($conditions as $column => $value) {
                $whereClause[] = "$column = ?";
            }
            $sql .= implode(" AND ", $whereClause);
        }
        $this->sql_query($sql, array_values($conditions));

        $this->execute();

        return $this->stmt->rowCount();
    }

    public function update($table, $data, $conditions = [])
    {
        $sql = "UPDATE $table SET ";

        $setClause = [];
        foreach ($data as $column => $value) {
            $setClause[] = "$column = ?";
        }
        $sql .= implode(", ", $setClause);

        if (!empty($conditions)) {
            $sql .= " WHERE ";

            $whereClause = [];
            foreach ($conditions as $column => $value) {
                $whereClause[] = "$column = ?";
            }
            $sql .= implode(" AND ", $whereClause);
        }
        $this->sql_query($sql, array_merge(array_values($data), array_values($conditions)));

        $this->execute();

        return $this->stmt->rowCount();
    }

    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    public function execute()
    {
        write_sql_log($this->getLastQuery());
        return $this->stmt->execute();
    }

    public function resultSet()
    {
        $this->execute();
        return $this->stmt->fetchAll();
    }

    public function single()
    {
        $this->execute();
        return $this->stmt->fetch();
    }

    public function rowCount()
    {
        return $this->stmt->rowCount();
    }

    public function lastInsertId()
    {
        return $this->myPDO()->lastInsertId();
    }

    public function insert($table, $data)
    {
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), '?'));

        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $this->sql_query($sql, array_values($data));

        $res = $this->execute();

        if ($res) {
            return $this->myPDO()->lastInsertId();
        } else {
            return -1;
        }
    }

    public function beginTransaction()
    {
        write_sql_log("<<=== YROS:: db tracker started ===>>");
        $this->pdo_success = true;
        return $this->myPDO()->beginTransaction();
    }

    public function commit()
    {
        if ($this->pdo_success == true) {
            write_sql_log("<<=== YROS:: db_tracker_success : sql queries submitted ===>>");
            return $this->myPDO()->commit();
        } else {
            write_sql_log("<<=== YROS:: db_tracker failed : sql rollback ===>>");
            $this->rollBack();
        }
    }

    public function rollBack()
    {
        return $this->myPDO()->rollBack();
    }

    public function inTransaction()
    {
        return $this->myPDO()->inTransaction();
    }

    public function getLastQuery()
    {
        $query = $this->lastQuery;
        if (!empty($this->lastParams)) {
            foreach ($this->lastParams as $param) {
                if(is_array($param)){
                    $param =  "Error here:: value is an array ".json_encode($param);
                }
                $quotedParam = $this->myPDO()->quote($param);
                $query = preg_replace('/\?/', $quotedParam, $query, 1);
            }
        }
        return $query;
    }

   
}
?>
