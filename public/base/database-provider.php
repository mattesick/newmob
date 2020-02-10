<?php 
class ResultSet
{
    public $stmt;
    public $row;
    public function __construct($stmt)
    {
        $this->stmt = $stmt;
    }
    public function next()
    {
        $this->row   = $this->stmt->fetch(PDO::FETCH_ASSOC);
        $returnValue = $this->row != NULL;
        if (!$returnValue) {
            $this->free();
        }
        return $returnValue;
    }
    public function free()
    {
        $this->stmt->closeCursor();
        $this->row = null;
    }
    public function rowCount(){
        return $this->stmt->rowCount();
    }
}
class DatabaseProvider 
{
    public $properties;
    public $conn;
    public $stmt;
    protected function connect(){
        if($this->conn == null){
            try {
                $this->conn = new PDO("mysql:host=" . $this->properties["host"] . ";dbname=" . $this->properties["database"].";", $this->properties['username'], $this->properties['password']);
            }
            catch (PDOException $e) {
                $this->handleError($e->getMessage());
            }
        }
    }
    public function executeBatchQuery($sql){
        $this->connect();
        try {
            $this->conn->exec($sql);
        }
        catch (PDOException $e)
        {
            $this->handleError($e->getMessage());
        }
    }
    public function executeQuery($query, $params = []){
        $this->_executeQuery($query, 1, $params);
    }
    public function fetchResultSet($query, $params = []){
        return $this->_executeQuery($query, 2, $params);
    }
    public function fetchRow($query, $params = []){
        return $this->_executeQuery($query, 3, $params);
    }
    public function fetchScalar($query, $params = [])
    {
        return $this->_executeQuery($query, 4, $params);
    }
    private function _executeQuery($query, $executionType, $params = []){
        $this->connect();
        try {
            $this->stmt = $this->conn->prepare($query);
            $this->stmt->execute($params);
        } catch(PDOException $e) {
            $this->handleError($e->getMessage());
        }
        switch($executionType) {
            case 1:
                return;
            case 2:
                return new ResultSet($this->stmt);
            case 3:
                $result = $this->fetchResultSet($query, $params);
                if (!$result->next()) {
                    return;
                }
                $data = [];
                foreach ( $result->row as $k => $v ) {
                    $data[$k] = $v;
                }
                $result->free();
                return $data;
            case 4:
                return $this->stmt->fetchColumn();
        }
        return null;
    }
    public function rowCount(){
        return $this->stmt->rowCount();
    }
    public function lastInsertId()
    {
        $this->connect();
        return $this->conn->lastInsertId();
    }
    public function tableExists($table){
        $this->connect();
        $query = $this->conn->query('SHOW TABLES');
        return in_array($table, $query->fetchAll(PDO::FETCH_COLUMN));
    }
    private function handleError($errorMsg){
        ChromePhp::log($errorMsg);
    }
}
