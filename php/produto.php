<?php
session_start();
require_once '../db_braza_in_foot/db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "Produto não encontrado!";
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
$stmt->execute([$id]);
$produto = $stmt->fetch();

if (!$produto) {
    echo "Produto não encontrado!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($produto['nome']) ?> - Braza in Foot</title>
  <link rel="stylesheet" href="../CSS/produto.css">
</head>
<body>

<div class="produto-container">
  <img src="<?= $produto['imagem'] ?>" alt="<?= htmlspecialchars($produto['nome']) ?>" class="produto-img">
  <div class="produto-info">
    <h1><?= htmlspecialchars($produto['nome']) ?></h1>
    <p><?= htmlspecialchars($produto['descricao']) ?></p>
    <strong>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></strong>

    <form id="form-carrinho" method="POST" action="carrinho.php">
      <input type="hidden" name="id" value="<?= $produto['id'] ?>">
      <input type="number" name="quantidade" value="1" min="1">
      <button type="submit">Adicionar ao Carrinho</button>
    </form>
  </div>
</div>

</body>
</html>
