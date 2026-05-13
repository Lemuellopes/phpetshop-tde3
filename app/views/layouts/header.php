<?php
// Layout: cabeçalho comum
$user = $_SESSION['user'] ?? null;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHPet Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<nav class="navbar">
    <div class="logo">
        <img src="images/php_PNG24.webp" alt="PHPet Shop - elePHPant" class="logo-img">
        <span class="logo-text">PHPet Shop</span>
    </div>
    <ul>
        <?php if ($user): ?>
            <?php if ($user['tipo'] === 'admin'): ?>
                <li><a href="index.php?action=dashboard">Dashboard</a></li>
                <li><a href="index.php?action=servicos">Serviços</a></li>
                <li><a href="index.php?action=agendamentos">Agendamentos</a></li>
                <li><a href="index.php?action=usuarios">Usuários</a></li>
            <?php else: ?>
                <li><a href="index.php?action=servicosCliente">Serviços</a></li>
                <li><a href="index.php?action=meusAgendamentos">Meus Agendamentos</a></li>
            <?php endif; ?>
            <li class="user">Olá, <?= htmlspecialchars($user['nome']) ?></li>
            <li><a href="index.php?action=logout">Sair</a></li>
        <?php else: ?>
            <li><a href="index.php?action=loginForm">Login</a></li>
            <li><a href="index.php?action=cadastroForm">Cadastro</a></li>
        <?php endif; ?>
    </ul>
</nav>
<main class="container">
<?php
// Mensagens flash
if (!empty($_SESSION['sucesso'])) {
    echo '<div class="alert sucesso">'.htmlspecialchars($_SESSION['sucesso']).'</div>';
    unset($_SESSION['sucesso']);
}
if (!empty($_SESSION['erro'])) {
    echo '<div class="alert erro">'.htmlspecialchars($_SESSION['erro']).'</div>';
    unset($_SESSION['erro']);
}
?>
