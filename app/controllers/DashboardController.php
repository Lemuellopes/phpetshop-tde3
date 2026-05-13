<?php
// app/controllers/DashboardController.php
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Servico.php';
require_once __DIR__ . '/../models/Agendamento.php';

/**
 * Controller do dashboard administrativo.
 * Mostra totais e informações resumidas usando os models.
 */
class DashboardController {
    private $db;

    /**
     * Recebe conexão PDO no construtor.
     */
    public function __construct($db) { $this->db = $db; }

    /**
     * Exibe a página do dashboard para admins:
     * - exige permissão de admin
     * - calcula totais de usuários, serviços e agendamentos
     */
    public function index() {
        Auth::requireAdmin();
        $totalUsuarios     = (new Usuario($this->db))->count();
        $totalServicos     = (new Servico($this->db))->count();
        $totalAgendamentos = (new Agendamento($this->db))->count();
        require __DIR__ . '/../views/admin/dashboard.php';
    }
}
