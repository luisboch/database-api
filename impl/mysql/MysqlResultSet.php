<?php

/**
 * @author luis
 */
class MysqlResultSet implements ResultSet {

    /**
     *
     * @var int
     */
    private $pointer;

    /**
     *
     * @var int
     */
    private $numRows;

    /**
     *
     * @var mysqli_result
     */
    private $mysql_result;

    function __construct($sql) {
        $this->pointer = -1;
    }

    public function getNumRows() {
        return $this->numRows;
    }

    /**
     * @return boolean
     */
    public function next() {
        $this->pointer++;
        $r = ($this->pointer < $this->numRows);
        return $r;
    }

    public function addData($data) {
        $this->data[] = $data;
    }

    public function setData($data) {
        $this->data = $data;
    }

    /**
     *
     * @return array
     */
    public function fetchAssoc() {
        return $this->mysql_result->fetch_assoc();
    }

    /**
     *
     * @return array
     */
    public function fetchArray() {
        if ($this->mysql_result !== null) {
            return $this->mysql_result->fetch_array();
        }
        return $this->map[$this->pointer];
    }

    public function setMysqlStmt(mysqli_stmt $stmt) {
        $rs = $stmt->get_result();
         if(is_object($rs) && $rs instanceof mysqli_result ){
            $this->setMysqlResult($rs); 
        }
    }

    public function setMysqlResult(mysqli_result $result) {
        $this->mysql_result = $result;
        $this->numRows = $this->mysql_result->num_rows;
    }

}

?>