<?php require __DIR__ . '/../../layouts/header.php'; ?>
<div class="card">
    <h2>Novo Usuário</h2>
    <form method="POST" action="index.php?action=usuarioStore">
        <label>Nome</label><input type="text" name="nome" required>
        <label>Email</label><input type="email" name="email" required>
        <label>Senha</label><input type="password" name="senha" required>
        <label>Tipo</label>
        <select name="tipo">
            <option value="cliente">Cliente</option>
            <option value="admin">Admin</option>
        </select>
        <button class="btn">Salvar</button>
        <a href="index.php?action=usuarios" class="btn ghost">Cancelar</a>
    </form>
</div>
<?php require __DIR__ . '/../../layouts/footer.php'; ?>
