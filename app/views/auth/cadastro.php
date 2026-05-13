<?php require __DIR__ . '/../layouts/header.php'; ?>
<div class="card">
    <h2>Cadastro de Cliente</h2>
    <form method="POST" action="index.php?action=cadastro">
        <label>Nome</label>
        <input type="text" name="nome" required>
        <label>Email</label>
        <input type="email" name="email" required>
        <label>Senha</label>
        <input type="password" name="senha" required>
        <button type="submit" class="btn">Cadastrar</button>
    </form>
</div>
<?php require __DIR__ . '/../layouts/footer.php'; ?>
