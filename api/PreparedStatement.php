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
     * Set parameters to query
     * @deprecated Consider use #set(array) method
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

    /**
     * This method is a short cut to {@link #setParameter($a, $b)}
     * See this example:
     * $p = $conn->prepare("insert into mytable(a,b,c) values (?, ?, ?)")
     * 
     * to set three parameters using setParameter method:
     * 
     * $p->setParamenter(1, "a");
     * $p->setParamenter(2, "b");
     * $p->setParamenter(3, "c");
     * 
     * using this method:
     * $p->set(array("a", "b","c");
     * 
     * Remember: in this case the function receive an array like this:
     * array(
     *  0 => "a",
     *  1 => "b",
     *  2 => "c" );
     * But it will converted to be accepted by query, in another words it will be 
     * processed like this:
     * array(
     *  1 => "a",
     *  2 => "b",
     *  3 => "c" );
     * 
     * ************************************************************
     * ******************* CAUTION ********************************
     * ************************************************************
     * If you are using mysql only use this method when all parameters is 
     * String because it set with this type. In case of PostgreSQL does not matter.
     * 
     */
    public function set($params = array());
}

?>