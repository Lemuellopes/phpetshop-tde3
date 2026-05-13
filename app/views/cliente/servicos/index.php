<?php require __DIR__ . '/../../layouts/header.php'; ?>
<h1>Serviços disponíveis</h1>
<div class="cards">
    <?php foreach ($servicos as $s): ?>
        <div class="card">
            <h3><?= htmlspecialchars($s['nome_servico']) ?></h3>
            <p><?= htmlspecialchars($s['descricao']) ?></p>
            <p class="preco">R$ <?= number_format($s['preco'],2,',','.') ?></p>
            <a href="index.php?action=agendamentoCreate&servico_id=<?= $s['id'] ?>" class="btn">Agendar</a>
        </div>
    <?php endforeach; ?>
</div>
<?php require __DIR__ . '/../../layouts/footer.php'; ?>
