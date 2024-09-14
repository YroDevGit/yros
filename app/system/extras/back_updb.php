<?php

class Back_updb
{
    public $pdo;
    private $stmt;
    private $error;

    public $pdo_success =true;

    public function __construct($dbConfig)
    {
        $dsn = "mysql:host=" . $dbConfig['host'] . ";dbname=" . $dbConfig['database'] . ";charset=" . $dbConfig['charset'];

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

    // Prepare SQL query
    public function sql_query(string $sql, $params = [])
    {
        $this->stmt = $this->pdo->prepare($sql);
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                if (is_numeric($key)) {
                    $this->stmt->bindValue($key + 1, $value);
                } else {
                    $this->stmt->bindValue($key, $value);
                }
            }
        }
    }

public function delete($table, $conditions = []) {
    $sql = "DELETE FROM $table";

    if (!empty($conditions)) {
        $sql .= " WHERE ";

        $whereClause = [];
        foreach ($conditions as $column => $value) {
            $whereClause[] = "$column = ?";
        }
        $sql .= implode(" AND ", $whereClause);
    }
        $this->stmt = $this->pdo->prepare($sql);

        $this->stmt->execute(array_values($conditions));

        return $this->stmt->rowCount();
}


public function update($table, $data, $conditions = []) {

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
        $this->stmt = $this->pdo->prepare($sql);

        $params = array_merge(array_values($data), array_values($conditions));

        $this->stmt->execute($params);

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

        $ret = $this->stmt->execute();
        return $ret;
    }

    // Fetch multiple rows as an array
    public function resultSet()
    {
        $this->execute();
        return $this->stmt->fetchAll();
    }

    // Fetch a single row
    public function single()
    {
        $this->execute();
        return $this->stmt->fetch();
    }

    // Get row count
    public function rowCount()
    {
        return $this->stmt->rowCount();
    }

    // Get the last inserted ID
    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

    public function insert($table, $data) {
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), '?'));
        
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
            $this->stmt = $this->pdo->prepare($sql);
            $res = $this->stmt->execute(array_values($data));
            if($res){
                return $this->pdo->lastInsertId();
            }
            else{
                return -1;
            }      
    }

    public function beginTransaction()
    {
        $this->pdo_success = true;
        return $this->pdo->beginTransaction();
    }

    // Commit a transaction
    public function commit()
    {
        if($this->pdo_success==true){
            return $this->pdo->commit();
        }
        else{
            $this->rollBack();
        }
    }

    // Rollback a transaction
    public function rollBack()
    {
        return $this->pdo->rollBack();
    }

    public function inTransaction(){
        return $this->pdo->inTransaction();
    }
}
?>