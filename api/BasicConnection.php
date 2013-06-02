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
                
                // Pega apenas as chaves com texto (ignora as chaves numéricas)
                if (!is_numeric($k)) {
                    
                    $propertyName = $this->getPropertyName($k);
                    
                    $method = "set" . ucfirst($propertyName);
                    
                    $method = $rf->getMethod($method);
                    
                    $method->invoke($instance, $v);
                }
            }

            $list[] = $instance;
        }
        return $list;
    }
    
    private function getPropertyName($name) {
        
        while($underline = strpos($name, '_') !== FALSE){
            // pega a primeira letra após o underline
            $toReplace = substr($name, $underline, 2);
            $after = strtoupper($toReplace);
            $name = str_replace($toReplace, $after, $name);
        }
        
        return $name;
    }
}

?>
