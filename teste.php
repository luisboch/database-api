<?php
include 'logger/log4php/Logger.php';
Logger::configure('logger/log4php.xml');
include 'database/database.php';
define("ENVIRONMENT", 'development');
Connection::setDatabaseTarget(Connection::POSTGRES);
$con = Connection::getConnection();
$con->query("select 1");
?>
