<?php require __DIR__ . '/../../layouts/header.php'; ?>
<div class="card">
    <h2>Editar Agendamento</h2>
    <form method="POST" action="index.php?action=agendamentoUpdate">
        <input type="hidden" name="id" value="<?= $ag['id'] ?>">
        <label>Serviço</label>
        <select name="servico_id" required>
            <?php foreach ($servicos as $s): ?>
                <option value="<?= $s['id'] ?>" <?= $ag['servico_id']==$s['id']?'selected':'' ?>>
                    <?= htmlspecialchars($s['nome_servico']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <label>Data</label><input type="date" name="data_agendamento" value="<?= $ag['data_agendamento'] ?>" required>
        <label>Horário</label><input type="time" name="horario" value="<?= substr($ag['horario'],0,5) ?>" required>
        <label>Observação</label><textarea name="observacao"><?= htmlspecialchars($ag['observacao']) ?></textarea>
        <button class="btn">Atualizar</button>
        <a href="index.php?action=meusAgendamentos" class="btn ghost">Cancelar</a>
    </form>
</div>
<?php require __DIR__ . '/../../layouts/footer.php'; ?>
