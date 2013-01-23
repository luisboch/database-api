<?php
/**
 * Description of BeanUtil
 *
 * @author luis
 */
class BeanUtil {
    /**
     * 
     * @param ResultSet $result
     * @param type $class
     * @return array of $class instances
     */
    public static function makeObject(ResultSet &$result, $class){
        $list = array();
        $rf = new ReflectionClass($class);
        while($result->next()){
            $arr = $result->fetchArray();
            $instance = $rf->newInstance();
            foreach($arr as $k => $v){
                if(!is_numeric($k)){
                $pr = $rf->getProperty($k);
                $propertieName = $pr->getName();
                $method = "set".ucfirst($propertieName);
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
