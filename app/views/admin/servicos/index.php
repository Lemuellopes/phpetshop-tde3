<?php require __DIR__ . '/../../layouts/header.php'; ?>
<h1>Serviços</h1>
<a href="index.php?action=servicoCreate" class="btn">+ Novo Serviço</a>
<table class="table">
    <thead><tr><th>ID</th><th>Nome</th><th>Descrição</th><th>Preço</th><th>Ações</th></tr></thead>
    <tbody>
    <?php foreach ($servicos as $s): ?>
        <tr>
            <td><?= $s['id'] ?></td>
            <td><?= htmlspecialchars($s['nome_servico']) ?></td>
            <td><?= htmlspecialchars($s['descricao']) ?></td>
            <td>R$ <?= number_format($s['preco'],2,',','.') ?></td>
            <td>
                <a href="index.php?action=servicoEdit&id=<?= $s['id'] ?>" class="btn small">Editar</a>
                <a href="index.php?action=servicoDelete&id=<?= $s['id'] ?>" class="btn small danger" onclick="return confirm('Excluir?')">Excluir</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php require __DIR__ . '/../../layouts/footer.php'; ?>
