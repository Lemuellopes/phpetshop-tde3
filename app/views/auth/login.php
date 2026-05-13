<?php require __DIR__ . '/../layouts/header.php'; ?>
<div class="card">
    <h2>Login</h2>
    <form method="POST" action="index.php?action=login">
        <label>Email</label>
        <input type="email" name="email" required>
        <label>Senha</label>
        <input type="password" name="senha" required>
        <button type="submit" class="btn">Entrar</button>
    </form>
    <p>Não tem conta? <a href="index.php?action=cadastroForm">Cadastre-se</a></p>
</div>
<?php require __DIR__ . '/../layouts/footer.php'; ?>
