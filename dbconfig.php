<?php

class Database {

    private $host = "localhost";
    private $db_name = "pimcoredb";
    private $username = "root";
    private $password = "";
    private $conn;
    
    /*
     * Connects to database
     *
     */
    public function connect() { 
	$this->conn = null;    
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
	    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
        }catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
    }
    
    /*
     * For Insert/Delete/Update Sqls
     * Returns count of affected rows
     */
    public function runUpdate($query, $params) {
	
	$stm = $this->conn->prepare($query);
    
	foreach($params as $param => &$value) {
	    $stm->bindParam($param, $value);
	}
	$stm->execute();
    
	return $stm->rowCount();
    }
    
    /*
     * For Select SQLs
     * Returns the results
     */
    public function runSelect($query, $params) {
	
	$stm = $this->conn->prepare($query);
    
	foreach($params as $param => &$value) {
	    $stm->bindParam($param, $value);
	}
    
	$stm->execute();    
	
	return $stm->fetchAll();
    }        
    
    /*
     * Returns the ID of last Insert SQL
     *
     */
    public function lasdID() {
	$stmt = $this->conn->lastInsertId();
	return $stmt;
    }

}

?>
