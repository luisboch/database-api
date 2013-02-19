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
