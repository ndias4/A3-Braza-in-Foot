<?php
session_start();
require_once '../db_braza_in_foot/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php?erro=login_requerido');
    exit;
}

if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $quantidade = filter_input(INPUT_POST, 'quantidade', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) ?? 1;

        if ($id && $quantidade > 0) {
            $_SESSION['carrinho'][$id] = ($_SESSION['carrinho'][$id] ?? 0) + $quantidade;
        }
        header('Location: addCarrinho.php');
        exit;
    }

    if (isset($_POST['update_id'])) {
        $updateId = filter_input(INPUT_POST, 'update_id', FILTER_VALIDATE_INT);
        $newQuantity = filter_input(INPUT_POST, 'new_quantity', FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);

        if ($updateId !== false && $newQuantity !== false) {
            if ($newQuantity > 0) {
                $_SESSION['carrinho'][$updateId] = $newQuantity;
            } else {
                unset($_SESSION['carrinho'][$updateId]);
            }
        }
        header('Location: addCarrinho.php');
        exit;
    }

    if (isset($_POST['remover'])) {
        $removerId = filter_input(INPUT_POST, 'remover', FILTER_VALIDATE_INT);
        if ($removerId) {
            unset($_SESSION['carrinho'][$removerId]);
        }
        header('Location: addCarrinho.php');
        exit;
    }
}

$produtos = [];
$total = 0;

if (!empty($_SESSION['carrinho'])) {
    $ids = array_keys($_SESSION['carrinho']);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $pdo->prepare("SELECT id, nome, preco, imagem FROM produtos WHERE id IN ($placeholders)");
    $stmt->execute($ids);
    $resultados = $stmt->fetchAll();

    foreach ($resultados as $produto) {
        $id = $produto['id'];
        $qtd = $_SESSION['carrinho'][$id];
        $produto['quantidade'] = $qtd;
        $produto['subtotal'] = $produto['preco'] * $qtd;
        $total += $produto['subtotal'];
        $produtos[] = $produto;
    }
}

// Inclui o cabeçalho com o badge do carrinho
include __DIR__ . '/header.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <title>Seu Carrinho - Braza in Foot</title>
  <link rel="stylesheet" href="../CSS/addCarrinho.css" />
  <link rel="stylesheet" href="../CSS/styleHome.css" />
</head>
<body>
  <main class="container">
    <h1 class="page-title">Resumo</h1>

    <?php if (empty($produtos)): ?>
      <p class="empty-cart-message">Seu carrinho está vazio.</p>
    <?php else: ?>
      <section class="cart-details">
        <table class="cart-table">
          <thead>
            <tr>
              <th>Produto</th>
              <th>Quantidade</th>
              <th>Preço Unitário</th>
              <th>Preço Total</th>
              <th>Ação</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($produtos as $produto): ?>
              <tr>
                <td class="product-description" data-label="Produto">
                  <div class="product-item-info">
                    <?php if (!empty($produto['imagem'])): ?>
                      <img src="../<?= htmlspecialchars($produto['imagem']) ?>" alt="<?= htmlspecialchars($produto['nome']) ?>" width="80">
                    <?php endif; ?>
                    <span class="product-name"><?= htmlspecialchars($produto['nome']) ?></span>
                  </div>
                </td>
                <td class="product-quantity-cell" data-label="Quantidade">
                  <form action="addCarrinho.php" method="post" class="quantity-form">
                    <input type="hidden" name="update_id" value="<?= $produto['id'] ?>">
                    <input type="number"
                           name="new_quantity"
                           value="<?= $produto['quantidade'] ?>"
                           min="0" class="quantity-input"
                           aria-label="Quantidade para <?= htmlspecialchars($produto['nome']) ?>">
                  </form>
                </td>
                <td class="product-unit-price" data-label="Preço Unitário">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></td>
                <td class="product-total-price" data-label="Preço Total">R$ <?= number_format($produto['subtotal'], 2, ',', '.') ?></td>
                <td class="product-action-cell">
                  <form method="post" action="addCarrinho.php">
                    <input type="hidden" name="remover" value="<?= $produto['id'] ?>">
                    <button type="submit" class="remove-item-icon" aria-label="Remover <?= htmlspecialchars($produto['nome']) ?>">❌</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </section>

      <section class="cart-summary-total">
        <div class="summary-line">
            <span>Total:</span>
            <span class="total-value">R$ <?= number_format($total, 2, ',', '.') ?></span>
        </div>
      </section>

      <section class="cart-actions">
        <a href="home.php" class="button secondary-button">Continuar Comprando</a>
        <a href="pagamento.php" class="button success-button">Finalizar Compra</a>
      </section>
    <?php endif; ?>
  </main>

  <script>
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            if (parseInt(this.value) < 0) {
                this.value = 0;
            }
            this.closest('form').submit();
        });
    });
  </script>

  <footer class="rodape">
    <div class="rodape-container">
      <div class="rodape-info">
        <img class="logo" src="../images/IMG-20250409-WA0006.jpg" alt="Logo Braza in Foot" />
        <p>CNPJ: 12.345.678/0001-90</p>
        <p>Rua Exemplo, 123 - São Paulo/SP</p>
        <p>CEP: 01234-000</p>
        <p>Telefone: (11) 99999-9999</p>
        <p>Email: contato@brazainfoot.com</p>
      </div>
      <div class="rodape-direitos">
        <p>&copy; <?= date('Y') ?> Braza in Foot. Todos os direitos reservados.</p>
      </div>
    </div>
  </footer>
</body>
</html>
