<?php
// Model de agendamentos - operações CRUD
class Agendamento {
    private $conn;
    private $table = "agendamentos";

    public $id;
    public $usuario_id;
    public $servico_id;
    public $data_agendamento;
    public $horario;
    public $observacao;

    // Inicializa com PDO
    public function __construct($db) {
        $this->conn = $db;
    }

    // Insere novo agendamento
    public function create() {
        $sql = "INSERT INTO {$this->table}
                (usuario_id, servico_id, data_agendamento, horario, observacao)
                VALUES (:uid, :sid, :data, :hora, :obs)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":uid",  $this->usuario_id, PDO::PARAM_INT);
        $stmt->bindParam(":sid",  $this->servico_id, PDO::PARAM_INT);
        $stmt->bindParam(":data", $this->data_agendamento);
        $stmt->bindParam(":hora", $this->horario);
        $stmt->bindParam(":obs",  $this->observacao);
        return $stmt->execute();
    }

    // Lista todos agendamentos com JOINs e filtro opcional por data
    public function read($filtroData = null) {
        $sql = "SELECT a.*, u.nome AS cliente, s.nome_servico AS servico, s.preco
                FROM {$this->table} a
                INNER JOIN usuarios u ON a.usuario_id = u.id
                INNER JOIN servicos s ON a.servico_id = s.id";
        if ($filtroData) {
            $sql .= " WHERE a.data_agendamento = :data";
        }
        $sql .= " ORDER BY a.data_agendamento DESC, a.horario DESC";
        $stmt = $this->conn->prepare($sql);
        if ($filtroData) {
            $stmt->bindParam(":data", $filtroData);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Lista agendamentos de um usuário
    public function readByUsuario($usuario_id) {
        $sql = "SELECT a.*, s.nome_servico AS servico, s.preco
                FROM {$this->table} a
                INNER JOIN servicos s ON a.servico_id = s.id
                WHERE a.usuario_id = :uid
                ORDER BY a.data_agendamento DESC, a.horario DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":uid", $usuario_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Busca agendamento por id
    public function findById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Atualiza agendamento
    public function update() {
        $sql = "UPDATE {$this->table}
                SET servico_id=:sid, data_agendamento=:data,
                    horario=:hora, observacao=:obs
                WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":sid",  $this->servico_id, PDO::PARAM_INT);
        $stmt->bindParam(":data", $this->data_agendamento);
        $stmt->bindParam(":hora", $this->horario);
        $stmt->bindParam(":obs",  $this->observacao);
        $stmt->bindParam(":id",   $this->id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Deleta agendamento
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Retorna a contagem total de agendamentos.
     * @return int
     */
    public function count() {
        $stmt = $this->conn->query("SELECT COUNT(*) AS total FROM {$this->table}");
        return $stmt->fetch()['total'];
    }
}
