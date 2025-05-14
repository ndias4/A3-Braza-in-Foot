<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.html');
    exit;
}

require_once __DIR__ . '/db.php';

$usuario_id = $_SESSION['user_id'];
$produto_id = intval($_POST['produto_id'] ?? 0);
$qtd        = intval($_POST['quantidade'] ?? 1);

$stmt = $pdo->prepare("INSERT INTO carrinho (usuario_id,produto_id,quantidade) VALUES (?,?,?)");
$stmt->execute([$usuario_id, $produto_id, $qtd]);

header('Location: carrinho.php');
