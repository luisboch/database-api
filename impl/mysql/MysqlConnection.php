<?php

require_once 'MysqlPreparedStatement.php';
require_once 'MysqlResultSet.php';

/**
 * Description of MysqlConnection
 *
 * @author luis
 */
class MysqlConnection extends BasicConnection {

    /**
     *
     * @var Logger
     */
    private static $logger;

    /**
     *
     * @var mysqli
     */
    private $db_conn;

    private function __construct() {
        if (self::$logger === NULL) {
            self::$logger = Logger::getLogger(__CLASS__);
        }
    }
    
    /**
     *
     * @param string $sql
     * @return MysqlPreparedStatement
     */
    public function prepare($sql) {
        $stmt = $this->db_conn->prepare($sql . ';');

        if ($stmt === false) {

            self::$logger->error("Error on query [" . $sql . "]");
            throw new QueryException("Error while preparing query \n\"" . $this->db_conn->error."\"\n");
        }

        self::$logger->debug("GOOD: '" . $sql . "'");
        return new MysqlPreparedStatement($stmt, $sql);
    }

    /**
     *
     * @param boolean $commit
     */
    public function autoCommit($commit = true) {
        $this->db_conn->autocommit($commit);
    }

    public function commit() {
        $this->db_conn->commit();
        $this->db_conn->autocommit(true);
    }

    public function rollback() {
        $this->db_conn->rollback();
        $this->db_conn->autocommit(true);
    }

    public function begin() {
        $this->autoCommit(false);
    }


    public function lastId() {
        return $this->db_conn->insert_id;
    }

    public function close() {
        $this->db_conn->close();
    }

    /**
     * 
     * @param type $host
     * @param type $database
     * @param type $user
     * @param type $password
     * @param type $port
     * @return Connection 
     */
    public static function connect($host, $database, $user, $password, $port = null) {
        
        $c = new MysqlConnection();
        self::$logger->info("Connecting to host [" . $host . "] database [" . $database . "] ");
        $c->db_conn = new mysqli($host, $user,
                        $password, $database, $port);
        if ($c->db_conn->connect_errno) {
            throw new DatabaseException("Failed to connect on database");
        }

        return $c;
    }

}

?>
