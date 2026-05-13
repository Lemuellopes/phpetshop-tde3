<?php
// public/index.php - Front Controller (única porta de entrada)
session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/ServicoController.php';
require_once __DIR__ . '/../app/controllers/AgendamentoController.php';
require_once __DIR__ . '/../app/controllers/UsuarioController.php';
require_once __DIR__ . '/../app/controllers/DashboardController.php';

// Helper de autenticação (controle de acesso)
class Auth {
    public static function check() { return !empty($_SESSION['user']); }
    public static function isAdmin() { return self::check() && $_SESSION['user']['tipo'] === 'admin'; }
    public static function requireLogin() {
        if (!self::check()) {
            $_SESSION['erro'] = "Faça login para continuar.";
            header("Location: index.php?action=loginForm"); exit;
        }
    }
    public static function requireAdmin() {
        self::requireLogin();
        if (!self::isAdmin()) {
            $_SESSION['erro'] = "Acesso restrito ao administrador.";
            header("Location: index.php?action=servicosCliente"); exit;
        }
    }
}

// Conexão
$db = (new Database())->connect();

// Mapa de ações -> [Controller, método]
// (substitui o "arquivo de rotas" mantendo tudo simples e em um lugar só)
$action = $_GET['action'] ?? 'loginForm';

$map = [
    // Auth
    'loginForm'         => [AuthController::class,        'loginForm'],
    'login'             => [AuthController::class,        'login'],
    'cadastroForm'      => [AuthController::class,        'cadastroForm'],
    'cadastro'          => [AuthController::class,        'cadastro'],
    'logout'            => [AuthController::class,        'logout'],
    // Dashboard
    'dashboard'         => [DashboardController::class,   'index'],
    // Serviços (admin)
    'servicos'          => [ServicoController::class,     'index'],
    'servicoCreate'     => [ServicoController::class,     'createForm'],
    'servicoStore'      => [ServicoController::class,     'store'],
    'servicoEdit'       => [ServicoController::class,     'editForm'],
    'servicoUpdate'     => [ServicoController::class,     'update'],
    'servicoDelete'     => [ServicoController::class,     'delete'],
    // Serviços (cliente)
    'servicosCliente'   => [ServicoController::class,     'listarCliente'],
    // Agendamentos
    'agendamentos'      => [AgendamentoController::class, 'index'],
    'meusAgendamentos'  => [AgendamentoController::class, 'meus'],
    'agendamentoCreate' => [AgendamentoController::class, 'createForm'],
    'agendamentoStore'  => [AgendamentoController::class, 'store'],
    'agendamentoEdit'   => [AgendamentoController::class, 'editForm'],
    'agendamentoUpdate' => [AgendamentoController::class, 'update'],
    'agendamentoDelete' => [AgendamentoController::class, 'delete'],
    // Usuários (admin)
    'usuarios'          => [UsuarioController::class,     'index'],
    'usuarioCreate'     => [UsuarioController::class,     'createForm'],
    'usuarioStore'      => [UsuarioController::class,     'store'],
    'usuarioEdit'       => [UsuarioController::class,     'editForm'],
    'usuarioUpdate'     => [UsuarioController::class,     'update'],
    'usuarioDelete'     => [UsuarioController::class,     'delete'],
];

if (!isset($map[$action])) {
    http_response_code(404);
    echo "Ação não encontrada: " . htmlspecialchars($action);
    exit;
}

[$class, $method] = $map[$action];
$controller = new $class($db);
$controller->$method();
