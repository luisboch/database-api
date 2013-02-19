<?php

/**
 * Description of PgResultSet
 *
 * @author luis
 */
class PgResultSet implements ResultSet {
    
    private $source;
    private $pointer = -1;
    
    /**
     *
     * @var numrows; 
     */
    private $numRows;
    
    /**
     * 
     * @return array
     */
    public function fetchArray() {
        return pg_fetch_array($this->source, $this->pointer);
    }

    /**
     * 
     * @return array
     */
    public function fetchAssoc() {
        return pg_fetch_assoc($this->source, $this->pointer);
    }
    /**
     * 
     * @return integer
     */
    public function getNumRows() {
        return $this->numRows;
    }

    /**
     * 
     * @return boolean
     */
    public function next() {
        $this->pointer++;
        return $this->pointer < $this->numRows;
    }
    
    /**
     * 
     * @param #resource $source
     */
    public function setResultSet($source){
        $this->source = $source;
        $this->numRows = pg_num_rows($this->source);
    }
    
}

?>