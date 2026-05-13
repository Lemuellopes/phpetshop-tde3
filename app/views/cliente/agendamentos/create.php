<?php require __DIR__ . '/../../layouts/header.php'; ?>
<div class="card">
    <h2>Novo Agendamento</h2>
    <form method="POST" action="index.php?action=agendamentoStore">
        <label>Serviço</label>
        <select name="servico_id" required>
            <option value="">-- escolha --</option>
            <?php foreach ($servicos as $s): ?>
                <option value="<?= $s['id'] ?>" <?= $servico_id == $s['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($s['nome_servico']) ?> (R$ <?= number_format($s['preco'],2,',','.') ?>)
                </option>
            <?php endforeach; ?>
        </select>
        <label>Data</label><input type="date" name="data_agendamento" required>
        <label>Horário</label><input type="time" name="horario" required>
        <label>Observação</label><textarea name="observacao"></textarea>
        <button class="btn">Agendar</button>
        <a href="index.php?action=meusAgendamentos" class="btn ghost">Cancelar</a>
    </form>
</div>
<?php require __DIR__ . '/../../layouts/footer.php'; ?>
