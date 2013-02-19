<?php

/**
 * This Exception is throwed on a result of critical querie is empty
 * @author luis
 */
class IllegalStateException extends Exception
{
    public function __construct($message, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

}

?>