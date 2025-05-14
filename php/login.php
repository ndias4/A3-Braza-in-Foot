<?php
session_start();
require_once __DIR__ . '/../db_braza_in_foot/db.php';  

$email = trim($_POST['chave'] ?? '');
$senha = trim($_POST['senha'] ?? '');

$stmt = $pdo->prepare("SELECT id, nome, senha, tipo FROM usuarios WHERE email = ?");
$stmt->execute([$email]);
$usuario = $stmt->fetch();

if ($usuario && $usuario['senha'] === $senha) {
    $_SESSION['user_id'] = $usuario['id'];
    $_SESSION['user_nome'] = $usuario['nome'];
    $_SESSION['user_tipo'] = $usuario['tipo'];
    $basePath = "/A3-Braza-in-Foot";
    header("Location: $basePath/php/home.php");
    exit();

} else {
    echo "<script>
        alert('Usuário ou senha incorretos!');
        window.location.href = 'index.html';
    </script>";
}
?>
