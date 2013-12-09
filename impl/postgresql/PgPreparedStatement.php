<?php
/**
 * Description of PgPreparedStatement
 *
 * @author luis
 */
class PgPreparedStatement extends BasicPreparedStatement{
    private $resource;
    private $types = array();
    private $params = array();
    private $conn;
    /**
     *
     * @var Logger
     */
    private static $logger;
    
    function __construct() {
       if(self::$logger === null){
           self::$logger = Logger::getLogger(__CLASS__);
       }
    }

    /**
     * @return void
     * @throws QueryException
     */
    public function execute() {
        $this->reindexParams();
        
        self::$logger->debug("BIND: [" . implode(', ', $this->params) . "]");
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
        
        $this->reindexParams();
        
        self::$logger->debug("BIND: [" . implode(', ', $this->params) . "]");
        $source = pg_execute($this->conn, "", $this->params);
        if($source === false){
            throw new QueryException("Failed to execute query: ".  pg_last_error($this->conn));
        }
        $rs = new PgResultSet();
        $rs->setResultSet($source);
        return $rs;
    }

    public function setParameter($index, $parameter, $type) {
       $this->types[$index] = $type;
       $this->params[$index] = $parameter;
    }
    
    public function setResource(&$resource){
        $this->resource = &$resource;
    }
    
    function setConnection($conn) {
        $this->conn = $conn;
    }
    
    public function reindexParams(){
        ksort($this->params);
    }
    
    public function getSingleResult() {
        $rs = $this->getResult();
        if($rs->getNumRows() == 1){
            return $rs;
        }
        
        if($rs->getNumRows() > 1) {
            throw new NoUniqueResultException("More than one result has been found.");
        } else if($rs->getNumRows() > 1) {
            throw new NoUniqueResultException("Anyone result has been found.");
        }
    }
}

?>