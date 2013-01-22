<?php

/**
 *
 * @author luis
 */
interface PreparedStatement {
    const STRING = "s";
    const DOUBLE = "d";
    const INTEGER = "i";
    const BLOB = "b";
    const BOOLEAN = "i";

    /**
     *
     * @param integer $index
     * @param object $parameter
     * @param string $type
     */
    public function setParameter($index, $parameter, $type);

    /**
     *
     * @return ResultSet
     */
    public function getResult();
    /**
     *
     * @return void
     */
    public function execute();
    
}

?>