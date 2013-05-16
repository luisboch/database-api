<?php

/**
 * Description of BasicConnection
 *
 * @author luis
 */
abstract class BasicConnection implements Connection{
    /**
     * 
     * @param string $sql querie to call
     * @param string $class class name
     * @return ResultSet
     */
    public function query($sql, $class = NULL) {
        
        $prepare = $this->prepare($sql);
        
        $result = $prepare->getResult();
        
        if($class === NULL){
            return $result;
        }
        
        $list = array();
        $rf = new ReflectionClass($class);
        
        while ($result->next()) {
            $arr = $result->fetchArray();
            $instance = $rf->newInstance();
            foreach ($arr as $k => $v) {
                if (!is_numeric($k)) {
                    $pr = $rf->getProperty($k);
                    $propertieName = $pr->getName();
                    $method = "set" . ucfirst($propertieName);
                    $method = $rf->getMethod($method);
                    $method->invoke($instance, $v);
                }
            }

            $list[] = $instance;
        }
        return $list;
    }
}

?>
