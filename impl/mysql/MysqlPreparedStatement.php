<?php
/**
 *  MysqlPreparedStatement
 *
 * @author luis
 */
class MysqlPreparedStatement implements PreparedStatement{
    /**
     *
     * @var Logger
     */
    private static $logger;
    /**
     *
     * @var string
     */
    private $sql;
    /**
     * have the type of parameters
     * @var array
     */
    protected $types = array();

    /**
     * have the parameters for prepared statement
     * @var array
     */
    protected $parameters = array();

    /**
     *
     * @var mysqli_stmt
     */
    protected $statement;

    /**
     *
     * @param  mysqli_stmt $stmt
     * @param string $sql
     */
    public function __construct(mysqli_stmt $stmt, $sql)
    {
        $this->statement = $stmt;
        $this->sql = $sql;
        self::$logger = Logger::getLogger(__CLASS__);
    }

    /**
     *
     * @param integer $index
     * @param object $parameter
     * @param string $type
     */
    public function setParameter($index, $parameter, $type)
    {
        $this->parameters[$index] = $parameter;
        $this->types[$index] = $type;
    }

    /**
     *
     * @return ResultSet
     */
    public function execute()
    {
        $this->bindParams();
        $result = $this->statement->execute();
        if ($result === FALSE) {
            throw new QueryException("Failed to execute query: " . $this->statement->error);
        }
        
        $rs = new MysqlResultSet($this->sql);
        $rs->setMysqlStmt($this->statement);
        return $rs;
        
    }
    
    private function bindParams(){
        
        $parameters = "";
        $types = "";
        $size = count($this->parameters);
        
        // each parameters
        foreach ($this->parameters as $k => $v) {
            $parameters .= '$var_' . $k;
            if ($size > $k) {
                $parameters .= ", ";
            }
            $types .= $this->types[$k];
            eval('$var_' . $k . ' = $v;');

        }
        
        $eval = '$this->statement->bind_param(\'' . $types . '\',' . $parameters . ');';

        if (count($this->parameters) > 0) {
            eval($eval);
        }
        self::$logger->debug("BIND: [" . implode(', ', $this->parameters) . "]");
    }


    /**
     *
     * @return ResultSet
     */
    public function getResult() {
        
        $this->bindParams();
        $result = $this->statement->execute();
        if ($result === FALSE) {
            throw new QueryException("Failed to prepare query: " . $this->statement->error);
        }
        
        $rs = new MysqlResultSet($this->sql);
        $rs->setMysqlStmt($this->statement);
        return $rs;
        
    }
}

?>
