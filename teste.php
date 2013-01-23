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
    echo "result of first query [ ".$array['num']." ] <br>";
}

// single query
$prepare = $conn->prepare("select 15 * ? as num");
$prepare->setParameter(1, 5, PreparedStatement::INTEGER);
$prepare->execute();
$q = $prepare->getResult();
while($q->next()){
    $array = $q->fetchArray();
    echo "result of second query [ ".$array['num']." ]";
}

class Produto{
    private $id;
    private $nome;
    private $descricao;
    private $valor_venda;
    private $status;
    private $categoria_id;
    private $exibir_index;
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function getValor_venda() {
        return $this->valor_venda;
    }

    public function setValor_venda($valor_venda) {
        $this->valor_venda = $valor_venda;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function getCategoria_id() {
        return $this->categoria_id;
    }

    public function setCategoria_id($categoria_id) {
        $this->categoria_id = $categoria_id;
    }

    public function getExibir_index() {
        return $this->exibir_index;
    }

    public function setExibir_index($exibir_index) {
        $this->exibir_index = $exibir_index;
    }


}


$sql = "select id, nome, descricao, valor_venda, status, categoria_id, exibir_index from produtos";
$result = $conn->query($sql, 'Produto');
            echo '<pre>';
            print_r($result);
            exit;
?>