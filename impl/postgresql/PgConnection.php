<?php

require_once 'PgPreparedStatement.php';
require_once 'PgResultSet.php';

/**
 * Description of PgConnection
 *
 * @author luis
 */
class PgConnection extends BasicConnection{
    
    private $conn;
    private $autocommit = false;
    /**
     *
     * @var Logger
     */
    private static $logger;
    
    private function __construct() {
        
    }

    /**
     * 
     * @param boolean $commit
     */
    public function autoCommit($commit = true) {
        $this->autocommit = $commit;
    }

    /**
     * Start an transaction
     * @throws IllegalStateException
     */
    public function begin() {
        if ($this->conn === null) {
            throw new IllegalStateException("Not connected");
        }
        pg_query($this->conn, "BEGIN TRANSACTION");
    }

    public function close() {
        if ($this->conn !== null) {
            pg_close($this->conn);
        }
    }

    /**
     * 
     * @throws IllegalStateException
     */
    public function commit() {
        if ($this->conn === null) {
            throw new IllegalStateException("Not connected");
        }
        pg_query($this->conn, "COMMIT TRANSACTION");
    }

    /**
     * 
     * @param string $sql
     * @return PreparedStatement
     * @throws IllegalStateException
     * @throws QueryException
     */
    public function prepare($sql) {
        if ($this->conn === null) {
            throw new IllegalStateException("Not connected");
        }
        $sucess = pg_prepare($this->conn, "", $sql);

        if ($sucess === false) {
            throw new
            QueryException("Failed to prepare query: " . pg_last_error($this->conn));
        }
        self::$logger->debug("GOOD: '" . $sql . "'");
        $prepare = pg_get_result($this->conn);

        $rs = new PgPreparedStatement();
        $rs->setResource($prepare);
        $rs->setConnection($this->conn);
        return $rs;
    }

    public function rollback() {
        pg_query($this->conn, "ROLLBACK TRANSACTION");
    }

    /**
     * 
     * @param type $host
     * @param type $database
     * @param type $user
     * @param type $password
     * @param type $port
     * @return Connection
     * @throws DatabaseException
     */
    public static function connect($host, $database, $user, $password, $port = null) {
        $resource = pg_pconnect("host=$host " .
                ($port === NULL ? "port=5432" : "port=$port") .
                " dbname=$database user=$user password=$password");
        if ($resource === FALSE) {
            throw new DatabaseException("Fail to connect on host: $host and database: $database");
        }

        $conn = new PgConnection();
        $conn->conn = &$resource;
        
        // Log Support
        self::$logger = Logger::getLogger(__CLASS__);
        return $conn;
    }

}

?>
