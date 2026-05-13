<?php require __DIR__ . '/../../layouts/header.php'; ?>
<div class="card">
    <h2>Novo Serviço</h2>
    <form method="POST" action="index.php?action=servicoStore">
        <label>Nome</label><input type="text" name="nome_servico" required>
        <label>Descrição</label><textarea name="descricao"></textarea>
        <label>Preço (R$)</label><input type="number" step="0.01" name="preco" required>
        <button class="btn">Salvar</button>
        <a href="index.php?action=servicos" class="btn ghost">Cancelar</a>
    </form>
</div>
<?php require __DIR__ . '/../../layouts/footer.php'; ?>
