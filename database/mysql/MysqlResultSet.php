<?php
/**
 * @author luis
 */
class MysqlResultSet
{

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
     * @var mixed
     */
    private $data;
    /**
     *
     * @var mixed
     */
    private $map;
    /**
     *
     * @var array
     */
    private $fields;


    public function getNumRows()
    {
        return $this->numRows;
    }

    public function setNumRows($num_rows)
    {
        $this->numRows = $num_rows;
    }

    /**
     * @return boolean
     */
    public function next()
    {
        $this->pointer++;
        $r = ($this->pointer < $this->numRows);
        return $r;
    }

    public function addData($data)
    {
        $this->data[] = $data;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     *
     * @return array
     */
    public function fetchAssoc()
    {
        return $this->data[$this->pointer];
    }

    /**
     *
     * @return array
     */
    public function fetchArray()
    {
        return $this->map[$this->pointer];
    }

    public function setMysqlStmt(mysqli_stmt $stmt)
    {
        $parameters = "";
        $size = $stmt->field_count;
        $k = 0;
        if ($size > 0) {
            for ($i = 0; $i < $size; $i++) {
                $parameters .= '$var_' . $i;
                if ($size > $i + 1) {
                    $parameters .= ", ";
                }
                eval('$var_' . $i . ' = NULL;');
            }
            eval('$stmt->bind_result(' . $parameters . ');');

            while ($stmt->fetch()) {
                $v = array();
                $map = array();

                for ($i = 0; $i < $size; $i++) {
                    eval('$v[$i] = $var_' . $i . ';');
                    eval('$map[$this->fields[$i]] = $var_' . $i . ';');
                }
                $this->data[] = $v;
                $this->map[] = $map;
                $k++;
            }
        }
        $this->setNumRows($k);
    }

    public function setMysqlResult(mysqli_result $result)
    {
        while ($v = $result->fetch_row()) {
            $this->data[] = $v;
            $map = array();
            foreach ($v as $k => $v) {
                $map[$this->fields[$k]] = $v;
            }
            $this->map[] = $map;
        }
        $this->numRows = $result->num_rows;
    }

}

?>
