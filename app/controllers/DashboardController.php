<?php
// app/controllers/DashboardController.php
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Servico.php';
require_once __DIR__ . '/../models/Agendamento.php';

class DashboardController {
    private $db;
    public function __construct($db) { $this->db = $db; }

    public function index() {
        Auth::requireAdmin();
        $totalUsuarios     = (new Usuario($this->db))->count();
        $totalServicos     = (new Servico($this->db))->count();
        $totalAgendamentos = (new Agendamento($this->db))->count();
        require __DIR__ . '/../views/admin/dashboard.php';
    }
}
