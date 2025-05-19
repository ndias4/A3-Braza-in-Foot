<?php
session_start();
require_once '../db_braza_in_foot/db.php';

// Iniciar carrinho se não existir
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

// Adicionar ao carrinho
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $quantidade = intval($_POST['quantidade'] ?? 1);

    if ($id) {
        if (isset($_SESSION['carrinho'][$id])) {
            $_SESSION['carrinho'][$id] += $quantidade;
        } else {
            $_SESSION['carrinho'][$id] = $quantidade;
        }
    }
}

// Remover item
if (isset($_GET['remover'])) {
    unset($_SESSION['carrinho'][$_GET['remover']]);
}

// Buscar produtos do banco
$produtos = [];
$total = 0;

foreach ($_SESSION['carrinho'] as $id => $qtd) {
    $stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
    $stmt->execute([$id]);
    $produto = $stmt->fetch();
    
    if ($produto) {
        $produto['quantidade'] = $qtd;
        $produto['subtotal'] = $qtd * $produto['preco'];
        $total += $produto['subtotal'];
        $produtos[] = $produto;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Carrinho - Braza in Foot</title>
  <link rel="stylesheet" href="../CSS/carrinho.css">
</head>
<body>
  <h1>Seu Carrinho</h1>

  <?php if (empty($produtos)): ?>
    <p>Seu carrinho está vazio.</p>
  <?php else: ?>
    <table>
      <thead>
        <tr>
          <th>Produto</th>
          <th>Quantidade</th>
          <th>Preço</th>
          <th>Subtotal</th>
          <th>Ação</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($produtos as $produto): ?>
          <tr>
            <td><?= htmlspecialchars($produto['nome']) ?></td>
            <td><?= $produto['quantidade'] ?></td>
            <td>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></td>
            <td>R$ <?= number_format($produto['subtotal'], 2, ',', '.') ?></td>
            <td><a href="?remover=<?= $produto['id'] ?>">Remover</a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <h3>Total: R$ <?= number_format($total, 2, ',', '.') ?></h3>

    <a href="pagamento.php"><button>Ir para pagamento</button></a>
  <?php endif; ?>
</body>
</html>
