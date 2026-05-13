<?php
// Model de serviços - operações CRUD
class Servico {
    private $conn;
    private $table = "servicos";

    public $id;
    public $nome_servico;
    public $descricao;
    public $preco;

    // Inicializa com PDO
    public function __construct($db) {
        $this->conn = $db;
    }

    // Insere novo serviço
    public function create() {
        $sql = "INSERT INTO {$this->table} (nome_servico, descricao, preco)
                VALUES (:nome, :desc, :preco)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":nome",  $this->nome_servico);
        $stmt->bindParam(":desc",  $this->descricao);
        $stmt->bindParam(":preco", $this->preco);
        return $stmt->execute();
    }

    // Lista todos os serviços
    public function read() {
        $sql = "SELECT * FROM {$this->table} ORDER BY nome_servico ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Busca serviço por id
    public function findById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Atualiza serviço
    public function update() {
        $sql = "UPDATE {$this->table}
                SET nome_servico=:nome, descricao=:desc, preco=:preco
                WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":nome",  $this->nome_servico);
        $stmt->bindParam(":desc",  $this->descricao);
        $stmt->bindParam(":preco", $this->preco);
        $stmt->bindParam(":id",    $this->id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Deleta serviço
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Retorna a contagem total de serviços.
     * @return int
     */
    public function count() {
        $stmt = $this->conn->query("SELECT COUNT(*) AS total FROM {$this->table}");
        return $stmt->fetch()['total'];
    }
}
