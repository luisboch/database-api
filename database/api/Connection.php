<?php

/**
 *
 * @author luis
 */
interface Connection {
    
    /**
     *
     * @param string $string
     * @return ResultSet
     */
    public function query($sql, $class = NULL);

    /**
     *
     * @param string $sql
     * @return PreparedStatement
     */
    public function prepare($sql);

    /**
     *
     * @param boolean $commit
     */
    public function autoCommit($commit = true);

    public function commit();

    public function rollback();

    public function begin();

    public function close();

    /**
     * @return Connection
     */
    public static function connect($host, $database, $user, $password, $port = null);
}

?>