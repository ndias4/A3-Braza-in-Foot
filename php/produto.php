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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../CSS/styleHome.css">
  <style>
    body {
      background-color: #f9f9f9;
      font-family: 'Arial', sans-serif;
    }
    .produto-imagem {
      max-width: 100%;
      height: auto;
      border-radius: 10px;
    }
    .produto-info h1 {
      font-weight: 700;
      font-size: 2rem;
    }
    .produto-preco {
      font-size: 1.5rem;
      font-weight: bold;
      color: #003300;
    }
    .btn-comprar {
      background-color: #003300;
      color: white;
      font-weight: bold;
    }
    .btn-carrinho {
      border: 2px solid #000;
      font-weight: bold;
    }
    .tamanhos button {
      border: 1px solid #ccc;
      padding: 6px 12px;
      background-color: white;
      margin-right: 6px;
      margin-bottom: 6px;
    }
    .tamanhos button:hover {
      border-color: #000;
    }
  </style>
</head>
<body>
<header>
        <a href="home.php">
            <img class="logo" src="../images/IMG-20250409-WA0006.jpg" alt="Logo">
        </a>

        <div class="navbar">
            <a href="catalogo.php?categoria=novidades"><button class="nav-btn">Novidades</button></a>
            <a href="catalogo.php?categoria=masculino"><button class="nav-btn">Masculino</button></a>
            <a href="catalogo.php?categoria=feminino"><button class="nav-btn">Feminino</button></a>
            <a href="catalogo.php?categoria=infantil"><button class="nav-btn">Infantil</button></a>
            <a href="catalogo.php?categoria=esportivo"><button class="nav-btn">Esportivo</button></a>
        </div>

        <div class="icons">
            <div class="search">
                <input class="search-input" type="search" placeholder="Encontre o que você procura">
            </div>

            <div class="busca">
                <a href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z"/></svg>
                </a>
            </div>

            <div class="user">
                <a href="#" id="user-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-160v-112q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v112H160Zm80-80h480v-32q0-11-5.5-20T700-306q-54-27-109-40.5T480-360q-56 0-111 13.5T260-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm0-80Zm0 400Z"/></svg>
                </a>
                <div id="user-dropdown" class="dropdown hidden">
                    <p>Bem-vindo, <?= $_SESSION['user_nome'] ?? 'Usuário'; ?>!</p>
                    <hr>
                    <a href="#">Perfil</a>
                    <a href="../index.html">Sair</a>
                </div>
            </div>

            <div class="carrinho">
                <a href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M280-80q-33 0-56.5-23.5T200-160q0-33 23.5-56.5T280-240q33 0 56.5 23.5T360-160q0 33-23.5 56.5T280-80Zm400 0q-33 0-56.5-23.5T600-160q0-33 23.5-56.5T680-240q33 0 56.5 23.5T760-160q0 33-23.5 56.5T680-80ZM246-720l96 200h280l110-200H246Zm-38-80h590q23 0 35 20.5t1 41.5L692-482q-11 20-29.5 31T622-440H324l-44 80h480v80H280q-45 0-68-39.5t-2-78.5l54-98-144-304H40v-80h130l38 80Zm134 280h280-280Z"/></svg>
                </a>
            </div>
        </div>
    </header>
<div class="container py-5">
  <div class="row g-5">

    <!-- IMAGEM -->
    <div class="col-md-6 text-center">
      <img src="../<?= $produto['imagem'] ?>" alt="<?= htmlspecialchars($produto['nome']) ?>" class="produto-imagem shadow-sm">
    </div>

    <!-- INFORMAÇÕES DO PRODUTO -->
    <div class="col-md-6 produto-info">
      <p class="text-muted">Tênis Masculino</p>
      <h1><?= htmlspecialchars($produto['nome']) ?></h1>
      <p class="produto-preco">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></p>
      <p><?= htmlspecialchars($produto['descricao']) ?></p>

      <!-- Opções de tamanho -->
      <div class="mb-4">
        <strong>Tamanho</strong>
        <div class="tamanhos d-flex flex-wrap mt-2">
          <?php foreach ([34, 35, 36, 37, 38, 39, 40, 41, 42, 43] as $tamanho): ?>
            <button type="button" class="btn"><?= $tamanho ?></button>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Botões de ação -->
      <form method="POST" action="addCarrinho.php" class="d-flex flex-column gap-2">
        <input type="hidden" name="id" value="<?= $produto['id'] ?>">
        <div class="d-flex gap-2">
          <input type="number" name="quantidade" value="1" min="1" class="form-control w-25">
        </div>
        <button type="submit" class="btn btn-comprar">COMPRAR AGORA</button>
        <button type="submit" class="btn btn-carrinho">ADICIONAR AO CARRINHO</button>
      </form>
    </div>
  </div>
</div>

</body>
</html>
