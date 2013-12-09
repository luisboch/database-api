<?php

/**
 * Description of BasicPreparedStatement
 *
 * @author Luis Carlos
 */
abstract class BasicPreparedStatement implements PreparedStatement{
    
    public function set($params = array()) {
        foreach($params as $k => $p){
            $this->setParameter($k + 1, $p, PreparedStatement::STRING);
        }
    }
}
