<?php

/**
 *
 * @author luis
 */
interface Connection {
    
    /**
     * @return Connection
     */

    /**
     * @return Connection
     */
    public function &createConnection($host, $database, $user, $password,  $port = null);

    /**
     *
     * @param string $string
     * @return ResultSet
     */
    public function query($sql);

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


}

?>