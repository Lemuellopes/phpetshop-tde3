<?php
// app/controllers/AuthController.php
require_once __DIR__ . '/../models/Usuario.php';

class AuthController {
    private $db;
    private $usuario;

    public function __construct($db) {
        $this->db = $db;
        $this->usuario = new Usuario($db);
    }

    // Tela de login
    public function loginForm() {
        require __DIR__ . '/../views/auth/login.php';
    }

    // Processa o login
    public function login() {
        $email = trim($_POST['email'] ?? '');
        $senha = $_POST['senha'] ?? '';

        if (!$email || !$senha) {
            $_SESSION['erro'] = "Preencha email e senha.";
            header("Location: index.php?action=loginForm");
            exit;
        }

        $user = $this->usuario->findByEmail($email);
        if ($user && password_verify($senha, $user['senha'])) {
            $_SESSION['user'] = [
                'id'    => $user['id'],
                'nome'  => $user['nome'],
                'email' => $user['email'],
                'tipo'  => $user['tipo'],
            ];
            // Redireciona conforme tipo
            if ($user['tipo'] === 'admin') {
                header("Location: index.php?action=dashboard");
            } else {
                header("Location: index.php?action=servicosCliente");
            }
            exit;
        }

        $_SESSION['erro'] = "Email ou senha inválidos.";
        header("Location: index.php?action=loginForm");
        exit;
    }

    // Tela de cadastro (cliente)
    public function cadastroForm() {
        require __DIR__ . '/../views/auth/cadastro.php';
    }

    // Processa cadastro de cliente
    public function cadastro() {
        $nome  = trim($_POST['nome']  ?? '');
        $email = trim($_POST['email'] ?? '');
        $senha = $_POST['senha'] ?? '';

        if (!$nome || !$email || !$senha) {
            $_SESSION['erro'] = "Preencha todos os campos.";
            header("Location: index.php?action=cadastroForm");
            exit;
        }

        if ($this->usuario->findByEmail($email)) {
            $_SESSION['erro'] = "Email já cadastrado.";
            header("Location: index.php?action=cadastroForm");
            exit;
        }

        $this->usuario->nome  = $nome;
        $this->usuario->email = $email;
        $this->usuario->senha = $senha;
        $this->usuario->tipo  = 'cliente';

        if ($this->usuario->create()) {
            $_SESSION['sucesso'] = "Cadastro realizado! Faça login.";
            header("Location: index.php?action=loginForm");
        } else {
            $_SESSION['erro'] = "Erro ao cadastrar.";
            header("Location: index.php?action=cadastroForm");
        }
        exit;
    }

    public function logout() {
        session_destroy();
        header("Location: index.php?action=loginForm");
        exit;
    }
}
