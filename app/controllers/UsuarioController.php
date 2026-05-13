<?php
// Controller de gerenciamento de usuários
require_once __DIR__ . '/../models/Usuario.php';

class UsuarioController {
    private $db;
    private $usuario;

    // Inicializa com PDO
    public function __construct($db) {
        $this->db = $db;
        $this->usuario = new Usuario($db);
    }

    // Lista todos os usuários
    public function index() {
        Auth::requireAdmin();
        $usuarios = $this->usuario->read();
        require __DIR__ . '/../views/admin/usuarios/index.php';
    }

    // Exibe formulário de criação
    public function createForm() {
        Auth::requireAdmin();
        require __DIR__ . '/../views/admin/usuarios/create.php';
    }

    // Cria novo usuário
    public function store() {
        Auth::requireAdmin();
        $this->usuario->nome  = trim($_POST['nome']  ?? '');
        $this->usuario->email = trim($_POST['email'] ?? '');
        $this->usuario->senha = $_POST['senha'] ?? '';
        $this->usuario->tipo  = $_POST['tipo'] ?? 'cliente';

        if (!$this->usuario->nome || !$this->usuario->email || !$this->usuario->senha) {
            $_SESSION['erro'] = "Preencha todos os campos.";
            header("Location: index.php?action=usuarioCreate");
            exit;
        }
        if ($this->usuario->findByEmail($this->usuario->email)) {
            $_SESSION['erro'] = "Email já cadastrado.";
            header("Location: index.php?action=usuarioCreate");
            exit;
        }
        $this->usuario->create();
        $_SESSION['sucesso'] = "Usuário criado!";
        header("Location: index.php?action=usuarios");
        exit;
    }

    // Exibe formulário de edição
    public function editForm() {
        Auth::requireAdmin();
        $id = intval($_GET['id'] ?? 0);
        $usuario = $this->usuario->findById($id);
        if (!$usuario) { header("Location: index.php?action=usuarios"); exit; }
        require __DIR__ . '/../views/admin/usuarios/edit.php';
    }

    // Atualiza usuário
    public function update() {
        Auth::requireAdmin();
        $this->usuario->id    = intval($_POST['id'] ?? 0);
        $this->usuario->nome  = trim($_POST['nome']  ?? '');
        $this->usuario->email = trim($_POST['email'] ?? '');
        $this->usuario->senha = $_POST['senha'] ?? ''; // se vazio, não atualiza
        $this->usuario->tipo  = $_POST['tipo'] ?? 'cliente';
        $this->usuario->update();
        $_SESSION['sucesso'] = "Usuário atualizado!";
        header("Location: index.php?action=usuarios");
        exit;
    }

    // Deleta usuário (exceto a si mesmo)
    public function delete() {
        Auth::requireAdmin();
        $id = intval($_GET['id'] ?? 0);
        if ($id == $_SESSION['user']['id']) {
            $_SESSION['erro'] = "Você não pode excluir seu próprio usuário.";
        } else {
            $this->usuario->delete($id);
            $_SESSION['sucesso'] = "Usuário excluído!";
        }
        header("Location: index.php?action=usuarios");
        exit;
    }
}
