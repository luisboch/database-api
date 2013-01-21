<?php
/**
 * @author luis
 */
interface ResultSet
{
    public function getNumRows();

    /**
     * @return boolean
     */
    public function next();

    public function addData($data, $pointer=null);

    public function setData($data);

    /**
     *
     * @return array
     */
    public function fetchAssoc();

    /**
     *
     * @return array
     */
    public function fetchArray();

}
?>
