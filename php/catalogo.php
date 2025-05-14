<?php
session_start();
require_once __DIR__ . '/../db_braza_in_foot/db.php';

$categoria = $_GET['categoria'] ?? '';

if (!$categoria) {
    header('Location: home.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM produtos WHERE categoria = ?");
$stmt->execute([$categoria]);
$produtos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../CSS/styleHome.css">
  <title><?= ucfirst($categoria) ?> - Braza in Foot</title>
</head>
<body>

  <?php include __DIR__ . '/header.php'; ?>

  <div class="banner">
    <h2 style="text-align: center; margin: 20px 0;"><?= ucfirst($categoria) ?></h2>
  </div>

  <main class="produtos-container">
    <?php foreach ($produtos as $produto): ?>
      <div class="produto-card">
        <img src="<?= htmlspecialchars($produto['imagem']) ?>" alt="<?= htmlspecialchars($produto['nome']) ?>">
        <h3><?= htmlspecialchars($produto['nome']) ?></h3>
        <p><?= htmlspecialchars($produto['descricao']) ?></p>
        <strong>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></strong>
        <button>Adicionar ao carrinho</button>
      </div>
    <?php endforeach; ?>
  </main>

  <script>
  const userIcon = document.getElementById('user-icon');
  const dropdown = document.getElementById('user-dropdown');

  userIcon?.addEventListener('click', (e) => {
    e.preventDefault();
    dropdown.classList.toggle('hidden');
  });

  window.addEventListener('click', function (e) {
    if (!userIcon?.contains(e.target) && !dropdown?.contains(e.target)) {
      dropdown?.classList.add('hidden');
    }
  });
</script>

</body>
</html>
