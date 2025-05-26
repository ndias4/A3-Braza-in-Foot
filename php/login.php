<?php
session_start();
require_once __DIR__ . '/../db_braza_in_foot/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['user_id'] = $usuario['id'];
        $_SESSION['user_nome'] = $usuario['nome'];
        header('Location: home.php');
        exit;
    } else {
        $erro = "E-mail ou senha inválidos";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - Braza in Foot</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/styleHome.css">
</head>
<body>

<?php include __DIR__ . '/header.php'; ?>

<div class="container mt-5 mb-5">
    <h2 class="mb-4">Entrar</h2>

    <?php if (isset($_GET['erro']) && $_GET['erro'] === 'login_requerido'): ?>
        <div class="alert alert-warning">Você precisa estar logado para acessar o carrinho ou finalizar a compra.</div>
    <?php endif; ?>

    <?php if (isset($erro)): ?>
        <div class="alert alert-danger"><?= $erro ?></div>
    <?php elseif (isset($_GET['cadastro'])): ?>
        <div class="alert alert-success">Cadastro realizado com sucesso. Faça login.</div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="E-mail" required>
        </div>
        <div class="mb-3">
            <input type="password" name="senha" class="form-control" placeholder="Senha" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Entrar</button>
        <p class="mt-3">Novo por aqui? <a href="cadastro.php">Criar conta</a></p>
    </form>
</div>

<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>

