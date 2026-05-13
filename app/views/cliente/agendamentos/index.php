<?php require __DIR__ . '/../../layouts/header.php'; ?>
<h1>Meus Agendamentos</h1>
<a href="index.php?action=servicosCliente" class="btn">+ Novo Agendamento</a>
<table class="table">
    <thead><tr><th>Serviço</th><th>Data</th><th>Hora</th><th>Obs.</th><th>Ações</th></tr></thead>
    <tbody>
    <?php foreach ($agendamentos as $a): ?>
        <tr>
            <td><?= htmlspecialchars($a['servico']) ?></td>
            <td><?= date('d/m/Y', strtotime($a['data_agendamento'])) ?></td>
            <td><?= substr($a['horario'],0,5) ?></td>
            <td><?= htmlspecialchars($a['observacao']) ?></td>
            <td>
                <a href="index.php?action=agendamentoEdit&id=<?= $a['id'] ?>" class="btn small">Editar</a>
                <a href="index.php?action=agendamentoDelete&id=<?= $a['id'] ?>" class="btn small danger" onclick="return confirm('Cancelar?')">Cancelar</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php require __DIR__ . '/../../layouts/footer.php'; ?>
