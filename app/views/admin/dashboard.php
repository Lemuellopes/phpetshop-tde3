<?php require __DIR__ . '/../layouts/header.php'; ?>
<h1>Dashboard</h1>
<div class="cards">
    <div class="card stat"><h3>Usuários</h3><p><?= $totalUsuarios ?></p></div>
    <div class="card stat"><h3>Serviços</h3><p><?= $totalServicos ?></p></div>
    <div class="card stat"><h3>Agendamentos</h3><p><?= $totalAgendamentos ?></p></div>
</div>
<?php require __DIR__ . '/../layouts/footer.php'; ?>
