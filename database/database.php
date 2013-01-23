<?php
require_once 'exceptions/QueryException.php';
require_once 'exceptions/DatabaseException.php';
require_once 'exceptions/IllegalStateException.php';
require_once 'exceptions/NoResultException.php';
require_once 'api/Connection.php';
require_once 'api/BasicConnection.php';
require_once 'api/PreparedStatement.php';
require_once 'api/ResultSet.php';

class DatabaseManager{
    
    /**
     * @param type $config
     * @return Connection
     */
    public static function getConnection($config = null){
        if($config === NULL){
            $config = parse_ini_file('database.ini');
        }
        /**
         * type Connection
         */
        $conn = NULL;
        if ($config['provider']  == 'mysql') {
            require_once 'impl/mysql/MysqlConnection.php';
            $conn = MysqlConnection::connect(
                    $config['host'], $config['database'],
                    $config['user'], $config['password']);
        } else if ($config['provider'] == 'postgresql'){
            require_once 'impl/postgresql/PgConnection.php';
            $conn = PgConnection::connect(
                    $config['host'], $config['database'], 
                    $config['user'], $config['password']);
            
        }
        
        return $conn;
    }
    
}