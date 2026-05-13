<?php
// app/controllers/AgendamentoController.php
require_once __DIR__ . '/../models/Agendamento.php';
require_once __DIR__ . '/../models/Servico.php';

/**
 * Controller responsável por ações relacionadas a agendamentos.
 * - métodos para admin (listar todos) e cliente (listar/meus, criar, editar, deletar)
 * - usa o model `Agendamento` para persistência e `Servico` para listar serviços
 */
class AgendamentoController {
    private $db;
    private $agendamento;

    /**
     * Construtor recebe a conexão PDO e inicializa o model de Agendamento.
     * @param PDO $db Conexão com o banco
     */
    public function __construct($db) {
        $this->db = $db;
        $this->agendamento = new Agendamento($db);
    }

    /**
     * Lista todos os agendamentos (visão do admin).
     * Lê possível filtro por data via GET['data'] e carrega a view administrativa.
     */
    public function index() {
        Auth::requireAdmin();
        $filtro = $_GET['data'] ?? null;
        $agendamentos = $this->agendamento->read($filtro);
        require __DIR__ . '/../views/admin/agendamentos/index.php';
    }

    /**
     * Mostra os agendamentos do usuário logado (cliente).
     * Exige autenticação e passa os dados para a view de cliente.
     */
    public function meus() {
        Auth::requireLogin();
        $agendamentos = $this->agendamento->readByUsuario($_SESSION['user']['id']);
        require __DIR__ . '/../views/cliente/agendamentos/index.php';
    }

    /**
     * Exibe o formulário de criação de agendamento para cliente.
     * Carrega lista de serviços disponíveis e um possível `servico_id` via GET.
     */
    public function createForm() {
        Auth::requireLogin();
        $servicoModel = new Servico($this->db);
        $servicos = $servicoModel->read();
        $servico_id = intval($_GET['servico_id'] ?? 0);
        require __DIR__ . '/../views/cliente/agendamentos/create.php';
    }

    /**
     * Recebe POST do formulário e cria um novo agendamento.
     * - valida campos obrigatórios
     * - grava usando o model `Agendamento`
     * - configura mensagem flash e redireciona para "meus agendamentos"
     */
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

    /**
     * Exibe o formulário de edição de agendamento.
     * - garante que o agendamento exista
     * - só permite o dono do agendamento ou admin editá-lo
     */
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

    /**
     * Atualiza um agendamento existente com dados vindos do POST.
     * - valida existência e permissão (dono ou admin)
     * - grava via model e redireciona para vista adequada
     */
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

    /**
     * Remove um agendamento (admin ou dono podem apagar).
     * - busca o registro e, se autorizado, deleta via model
     */
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
