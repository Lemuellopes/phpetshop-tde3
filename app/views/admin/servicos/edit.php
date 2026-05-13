<?php require __DIR__ . '/../../layouts/header.php'; ?>
<div class="card">
    <h2>Editar Serviço</h2>
    <form method="POST" action="index.php?action=servicoUpdate">
        <input type="hidden" name="id" value="<?= $servico['id'] ?>">
        <label>Nome</label><input type="text" name="nome_servico" value="<?= htmlspecialchars($servico['nome_servico']) ?>" required>
        <label>Descrição</label><textarea name="descricao"><?= htmlspecialchars($servico['descricao']) ?></textarea>
        <label>Preço (R$)</label><input type="number" step="0.01" name="preco" value="<?= $servico['preco'] ?>" required>
        <button class="btn">Atualizar</button>
        <a href="index.php?action=servicos" class="btn ghost">Cancelar</a>
    </form>
</div>
<?php require __DIR__ . '/../../layouts/footer.php'; ?>
