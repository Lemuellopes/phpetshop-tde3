<?php
// app/models/Usuario.php
/**
 * Model `Usuario` — encapsula operações na tabela `usuarios`.
 * Campos públicos representam os atributos usados pelos controllers.
 */
class Usuario {
    private $conn;
    private $table = "usuarios";

    public $id;
    public $nome;
    public $email;
    public $senha;
    public $tipo; // 'admin' ou 'cliente'

    /**
     * Recebe conexão PDO no construtor.
     * @param PDO $db
     */
    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * CREATE - cadastra novo usuário.
     * - faz hash seguro da senha antes de salvar
     * @return bool sucesso da operação
     */
    public function create() {
        $sql = "INSERT INTO {$this->table} (nome, email, senha, tipo)
                VALUES (:nome, :email, :senha, :tipo)";
        $stmt = $this->conn->prepare($sql);

        // Hash seguro da senha
        $senhaHash = password_hash($this->senha, PASSWORD_BCRYPT);

        $stmt->bindParam(":nome",  $this->nome);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":senha", $senhaHash);
        $stmt->bindParam(":tipo",  $this->tipo);

        return $stmt->execute();
    }

    /**
     * READ - lista todos os usuários (sem a senha)
     * @return array lista de usuários
     */
    public function read() {
        $sql = "SELECT id, nome, email, tipo FROM {$this->table} ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Busca um usuário por id (retorna todos os campos, inclusive senha hash).
     * @param int $id
     * @return array|false registro do usuário ou false
     */
    public function findById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    /**
     * Busca por email — usado no processo de login.
     * @param string $email
     * @return array|false registro do usuário ou false
     */
    public function findByEmail($email) {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        return $stmt->fetch();
    }

    /**
     * UPDATE - atualiza usuário.
     * - se `$this->senha` estiver vazia, a senha não é alterada
     * @return bool sucesso da operação
     */
    public function update() {
        // Atualiza senha somente se informada
        if (!empty($this->senha)) {
            $sql = "UPDATE {$this->table}
                    SET nome=:nome, email=:email, senha=:senha, tipo=:tipo
                    WHERE id=:id";
            $stmt = $this->conn->prepare($sql);
            $senhaHash = password_hash($this->senha, PASSWORD_BCRYPT);
            $stmt->bindParam(":senha", $senhaHash);
        } else {
            $sql = "UPDATE {$this->table}
                    SET nome=:nome, email=:email, tipo=:tipo
                    WHERE id=:id";
            $stmt = $this->conn->prepare($sql);
        }
        $stmt->bindParam(":nome",  $this->nome);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":tipo",  $this->tipo);
        $stmt->bindParam(":id",    $this->id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * DELETE - remove usuário por id.
     * @param int $id
     * @return bool
     */
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Retorna a contagem total de usuários (usado no dashboard).
     * @return int
     */
    public function count() {
        $stmt = $this->conn->query("SELECT COUNT(*) AS total FROM {$this->table}");
        return $stmt->fetch()['total'];
    }
}
