<?php require __DIR__ . '/../../layouts/header.php'; ?>
<h1>Usuários</h1>
<a href="index.php?action=usuarioCreate" class="btn">+ Novo Usuário</a>
<table class="table">
    <thead><tr><th>ID</th><th>Nome</th><th>Email</th><th>Tipo</th><th>Ações</th></tr></thead>
    <tbody>
    <?php foreach ($usuarios as $u): ?>
        <tr>
            <td><?= $u['id'] ?></td>
            <td><?= htmlspecialchars($u['nome']) ?></td>
            <td><?= htmlspecialchars($u['email']) ?></td>
            <td><?= $u['tipo'] ?></td>
            <td>
                <a href="index.php?action=usuarioEdit&id=<?= $u['id'] ?>" class="btn small">Editar</a>
                <a href="index.php?action=usuarioDelete&id=<?= $u['id'] ?>" class="btn small danger" onclick="return confirm('Excluir?')">Excluir</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php require __DIR__ . '/../../layouts/footer.php'; ?>
