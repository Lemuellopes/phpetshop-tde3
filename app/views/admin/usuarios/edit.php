<?php require __DIR__ . '/../../layouts/header.php'; ?>
<div class="card">
    <h2>Editar Usuário</h2>
    <form method="POST" action="index.php?action=usuarioUpdate">
        <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
        <label>Nome</label><input type="text" name="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required>
        <label>Email</label><input type="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required>
        <label>Senha (deixe vazio para manter)</label><input type="password" name="senha">
        <label>Tipo</label>
        <select name="tipo">
            <option value="cliente" <?= $usuario['tipo']==='cliente'?'selected':'' ?>>Cliente</option>
            <option value="admin"   <?= $usuario['tipo']==='admin'?'selected':'' ?>>Admin</option>
        </select>
        <button class="btn">Atualizar</button>
        <a href="index.php?action=usuarios" class="btn ghost">Cancelar</a>
    </form>
</div>
<?php require __DIR__ . '/../../layouts/footer.php'; ?>
