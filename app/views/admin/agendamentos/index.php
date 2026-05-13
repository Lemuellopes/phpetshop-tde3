<?php require __DIR__ . '/../../layouts/header.php'; ?>
<h1>Agendamentos</h1>
<form method="GET" class="filtro">
    <input type="hidden" name="action" value="agendamentos">
    <label>Filtrar por data:</label>
    <input type="date" name="data" value="<?= htmlspecialchars($_GET['data'] ?? '') ?>">
    <button class="btn small">Filtrar</button>
    <a href="index.php?action=agendamentos" class="btn small ghost">Limpar</a>
</form>
<table class="table">
    <thead><tr><th>ID</th><th>Cliente</th><th>Serviço</th><th>Data</th><th>Hora</th><th>Obs.</th><th>Ações</th></tr></thead>
    <tbody>
    <?php foreach ($agendamentos as $a): ?>
        <tr>
            <td><?= $a['id'] ?></td>
            <td><?= htmlspecialchars($a['cliente']) ?></td>
            <td><?= htmlspecialchars($a['servico']) ?></td>
            <td><?= date('d/m/Y', strtotime($a['data_agendamento'])) ?></td>
            <td><?= substr($a['horario'],0,5) ?></td>
            <td><?= htmlspecialchars($a['observacao']) ?></td>
            <td>
                <a href="index.php?action=agendamentoEdit&id=<?= $a['id'] ?>" class="btn small">Editar</a>
                <a href="index.php?action=agendamentoDelete&id=<?= $a['id'] ?>" class="btn small danger" onclick="return confirm('Cancelar agendamento?')">Cancelar</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php require __DIR__ . '/../../layouts/footer.php'; ?>
