<?php
include 'logger/log4php/Logger.php';
Logger::configure('logger/log4php.xml');
include 'database/database.php';
define("ENVIRONMENT", 'development');
$conn = DatabaseManager::getConnection();
// single query
$q = $conn->query("select 1 as num");

while($q->next()){
    $array = $q->fetchArray();
    echo "result of query first query [ ".$array['num']." ] <br>";
}

// single query
$prepare = $conn->prepare("select 15 * ? as num");
$prepare->setParameter(1, 5, PreparedStatement::INTEGER);
$prepare->execute();
$q = $prepare->getResult();
while($q->next()){
    $array = $q->fetchArray();
    echo "result of query second query [ ".$array['num']." ]";
}

?>