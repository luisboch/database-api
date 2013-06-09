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
     * Used when need retrieve a ResultSet
     * @return ResultSet
     */
    public function getResult();
    
    /**
     *
     * @return ResultSet
     */
    public function execute();
    
    /**
     * Retrieve only one Result of query.
     * @throws NoUniqueResultException when found 0 or more than 1 results
     */
    public function getSingleResult();
}

?>