<?php
// app/controllers/AgendamentoController.php
require_once __DIR__ . '/../models/Agendamento.php';
require_once __DIR__ . '/../models/Servico.php';

class AgendamentoController {
    private $db;
    private $agendamento;

    public function __construct($db) {
        $this->db = $db;
        $this->agendamento = new Agendamento($db);
    }

    // Admin: ver todos
    public function index() {
        Auth::requireAdmin();
        $filtro = $_GET['data'] ?? null;
        $agendamentos = $this->agendamento->read($filtro);
        require __DIR__ . '/../views/admin/agendamentos/index.php';
    }

    // Cliente: ver os meus
    public function meus() {
        Auth::requireLogin();
        $agendamentos = $this->agendamento->readByUsuario($_SESSION['user']['id']);
        require __DIR__ . '/../views/cliente/agendamentos/index.php';
    }

    // Cliente: form de novo agendamento
    public function createForm() {
        Auth::requireLogin();
        $servicoModel = new Servico($this->db);
        $servicos = $servicoModel->read();
        $servico_id = intval($_GET['servico_id'] ?? 0);
        require __DIR__ . '/../views/cliente/agendamentos/create.php';
    }

    public function store() {
        Auth::requireLogin();
        $this->agendamento->usuario_id       = $_SESSION['user']['id'];
        $this->agendamento->servico_id       = intval($_POST['servico_id'] ?? 0);
        $this->agendamento->data_agendamento = $_POST['data_agendamento'] ?? '';
        $this->agendamento->horario          = $_POST['horario'] ?? '';
        $this->agendamento->observacao       = trim($_POST['observacao'] ?? '');

        if (!$this->agendamento->servico_id || !$this->agendamento->data_agendamento || !$this->agendamento->horario) {
            $_SESSION['erro'] = "Preencha todos os campos obrigatórios.";
            header("Location: index.php?action=agendamentoCreate");
            exit;
        }

        $this->agendamento->create();
        $_SESSION['sucesso'] = "Agendamento realizado!";
        header("Location: index.php?action=meusAgendamentos");
        exit;
    }

    public function editForm() {
        Auth::requireLogin();
        $id = intval($_GET['id'] ?? 0);
        $ag = $this->agendamento->findById($id);
        if (!$ag) { header("Location: index.php?action=meusAgendamentos"); exit; }
        // Apenas dono ou admin
        if ($_SESSION['user']['tipo'] !== 'admin' && $ag['usuario_id'] != $_SESSION['user']['id']) {
            header("Location: index.php?action=meusAgendamentos"); exit;
        }
        $servicoModel = new Servico($this->db);
        $servicos = $servicoModel->read();
        require __DIR__ . '/../views/cliente/agendamentos/edit.php';
    }

    public function update() {
        Auth::requireLogin();
        $id = intval($_POST['id'] ?? 0);
        $existente = $this->agendamento->findById($id);
        if (!$existente) { header("Location: index.php?action=meusAgendamentos"); exit; }
        if ($_SESSION['user']['tipo'] !== 'admin' && $existente['usuario_id'] != $_SESSION['user']['id']) {
            header("Location: index.php?action=meusAgendamentos"); exit;
        }
        $this->agendamento->id               = $id;
        $this->agendamento->servico_id       = intval($_POST['servico_id'] ?? 0);
        $this->agendamento->data_agendamento = $_POST['data_agendamento'] ?? '';
        $this->agendamento->horario          = $_POST['horario'] ?? '';
        $this->agendamento->observacao       = trim($_POST['observacao'] ?? '');
        $this->agendamento->update();
        $_SESSION['sucesso'] = "Agendamento atualizado!";
        $dest = $_SESSION['user']['tipo'] === 'admin' ? 'agendamentos' : 'meusAgendamentos';
        header("Location: index.php?action={$dest}");
        exit;
    }

    public function delete() {
        Auth::requireLogin();
        $id = intval($_GET['id'] ?? 0);
        $existente = $this->agendamento->findById($id);
        if ($existente && ($_SESSION['user']['tipo'] === 'admin' || $existente['usuario_id'] == $_SESSION['user']['id'])) {
            $this->agendamento->delete($id);
            $_SESSION['sucesso'] = "Agendamento cancelado!";
        }
        $dest = $_SESSION['user']['tipo'] === 'admin' ? 'agendamentos' : 'meusAgendamentos';
        header("Location: index.php?action={$dest}");
        exit;
    }
}
