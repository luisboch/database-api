<?php
/**
 * Description of PgPreparedStatement
 *
 * @author luis
 */
class PgPreparedStatement implements PreparedStatement{
    private $resource;
    private $types = array();
    private $params = array();
    private $conn;


    /**
     * @return void
     * @throws QueryException
     */
    public function execute() {
        $source = pg_execute($this->conn, "", $this->params);
        if($source === false){
            throw new QueryException("Failed to execute query: ".  pg_last_error($this->conn));
        }
        $rs = new PgResultSet();
        $rs->setResultSet($source);
        return $rs;
        
    }

    /**
     * 
     * @return ResultSet
     * @throws QueryException
     */
    public function getResult() {
        $source = pg_execute($this->conn, "", $this->params);
        if($source === false){
            throw new QueryException("Failed to execute query: ".  pg_last_error($this->conn));
        }
        $rs = new PgResultSet();
        $rs->setResultSet($source);
        return $rs;
    }

    public function setParameter($index, $parameter, $type) {
       $this->types[$index] = $index;
       $this->params[$index] = $parameter;
    }
    
    public function setResource(&$resource){
        $this->resource = &$resource;
    }
    
    function setConnection($conn) {
        $this->conn = $conn;
    }
}

?>