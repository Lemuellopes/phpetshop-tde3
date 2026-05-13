<?php
// Controller CRUD de serviços
require_once __DIR__ . '/../models/Servico.php';

class ServicoController {
    private $db;
    private $servico;

    // Inicializa com PDO
    public function __construct($db) {
        $this->db = $db;
        $this->servico = new Servico($db);
    }

    // Lista serviços para admin
    public function index() {
        Auth::requireAdmin();
        $servicos = $this->servico->read();
        require __DIR__ . '/../views/admin/servicos/index.php';
    }

    // Lista serviços para cliente
    public function listarCliente() {
        Auth::requireLogin();
        $servicos = $this->servico->read();
        require __DIR__ . '/../views/cliente/servicos/index.php';
    }

    // Exibe formulário de criação
    public function createForm() {
        Auth::requireAdmin();
        require __DIR__ . '/../views/admin/servicos/create.php';
    }

    // Cria novo serviço
    public function store() {
        Auth::requireAdmin();
        $this->servico->nome_servico = trim($_POST['nome_servico'] ?? '');
        $this->servico->descricao    = trim($_POST['descricao'] ?? '');
        $this->servico->preco        = floatval($_POST['preco'] ?? 0);

        if (!$this->servico->nome_servico) {
            $_SESSION['erro'] = "Nome do serviço é obrigatório.";
            header("Location: index.php?action=servicoCreate");
            exit;
        }

        $this->servico->create();
        $_SESSION['sucesso'] = "Serviço cadastrado com sucesso!";
        header("Location: index.php?action=servicos");
        exit;
    }

    // Exibe formulário de edição
    public function editForm() {
        Auth::requireAdmin();
        $id = intval($_GET['id'] ?? 0);
        $servico = $this->servico->findById($id);
        if (!$servico) { header("Location: index.php?action=servicos"); exit; }
        require __DIR__ . '/../views/admin/servicos/edit.php';
    }

    // Atualiza serviço
    public function update() {
        Auth::requireAdmin();
        $this->servico->id           = intval($_POST['id'] ?? 0);
        $this->servico->nome_servico = trim($_POST['nome_servico'] ?? '');
        $this->servico->descricao    = trim($_POST['descricao'] ?? '');
        $this->servico->preco        = floatval($_POST['preco'] ?? 0);
        $this->servico->update();
        $_SESSION['sucesso'] = "Serviço atualizado!";
        header("Location: index.php?action=servicos");
        exit;
    }

    // Deleta serviço
    public function delete() {
        Auth::requireAdmin();
        $id = intval($_GET['id'] ?? 0);
        $this->servico->delete($id);
        $_SESSION['sucesso'] = "Serviço excluído!";
        header("Location: index.php?action=servicos");
        exit;
    }
}
