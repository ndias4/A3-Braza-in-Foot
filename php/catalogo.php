<?php
session_start();
require_once __DIR__ . '/../db_braza_in_foot/db.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: index.html');
    exit;
}

$categoria = $_GET['categoria'] ?? '';

// Validação básica da categoria para evitar SQL Injection e garantir categoria válida
$categorias_validas = ['novidades', 'masculino', 'feminino', 'infantil', 'esportivo'];

if (!in_array($categoria, $categorias_validas)) {
    header('Location: home.php');
    exit;
}

// Busca os produtos da categoria selecionada
$stmt = $pdo->prepare("SELECT * FROM produtos WHERE categoria = ?");
$stmt->execute([$categoria]);
$produtos = $stmt->fetchAll();

// Inclui o cabeçalho com o badge do carrinho
include __DIR__ . '/header.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= htmlspecialchars(ucfirst($categoria)) ?> - Braza in Foot</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="../CSS/styleHome.css" />
</head>
<body>
  <div class="banner my-4">
    <h2 class="text-center"><?= htmlspecialchars(ucfirst($categoria)) ?></h2>
  </div>

  <main class="container">
    <div class="row row-cols-1 row-cols-md-3 g-4">
      <?php if (count($produtos) === 0): ?>
        <p class="text-center">Nenhum produto encontrado para esta categoria.</p>
      <?php else: ?>
        <?php foreach ($produtos as $produto): ?>
          <div class="col">
            <div class="card h-100 shadow-sm">
              <img src="../<?= htmlspecialchars($produto['imagem']) ?>" class="card-img-top" alt="<?= htmlspecialchars($produto['nome']) ?>" />
              <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($produto['nome']) ?></h5>
                <p class="card-text"><?= htmlspecialchars($produto['descricao']) ?></p>
              </div>
              <div class="card-footer d-flex justify-content-between align-items-center">
                <strong>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></strong>
                <a href="produto.php?id=<?= (int)$produto['id'] ?>" class="btn btn-success btn-sm">Ver detalhes</a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </main>

  <script>
    const userIcon = document.getElementById('user-icon');
    const dropdown = document.getElementById('user-dropdown');

    userIcon?.addEventListener('click', (e) => {
      e.preventDefault();
      dropdown.classList.toggle('hidden');
    });

    window.addEventListener('click', (e) => {
      if (!userIcon?.contains(e.target) && !dropdown?.contains(e.target)) {
        dropdown.classList.add('hidden');
      }
    });
  </script>

  <footer class="rodape mt-5">
    <div class="rodape-container">
      <div class="rodape-info">
        <img class="logo" src="../images/IMG-20250409-WA0006.jpg" alt="Logo" />
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
