<?php
session_start();
require_once __DIR__ . '/../db_braza_in_foot/db.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: index.html');
    exit;
}

// Buscar os produtos do banco
$stmt = $pdo->query("SELECT * FROM produtos");
$produtos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loja - Braza in Foot</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Estilo personalizado -->
    <link rel="stylesheet" href="../CSS/styleHome.css">
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

    <!-- Carrossel Bootstrap -->
    <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="../images/Banner Tenis 2.png" class="d-block w-100" alt="Banner 1">
            </div>
            <div class="carousel-item">
                <img src="../images/Banner Tenis 3.png" class="d-block w-100" alt="Banner 2">
            </div>
            <div class="carousel-item">
                <img src="../images/Banner Tenis 4.png" class="d-block w-100" alt="Banner 3">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
            <span class="visually-hidden">Próximo</span>
        </button>
    </div>

   <main class="container my-5">
  <h2 class="mb-4 text-center">Mais Vendidos</h2>
  <div class="row row-cols-1 row-cols-md-3 g-4">
    <?php foreach ($produtos as $produto): ?>
      <div class="col">
        <div class="card h-100 shadow-sm">
          <<img src="../<?= htmlspecialchars($produto['imagem']) ?>" alt="<?= htmlspecialchars($produto['nome']) ?>" class="card-img-top">>
          <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($produto['nome']) ?></h5>
            <p class="card-text"><?= htmlspecialchars($produto['descricao']) ?></p>
          </div>
          <div class="card-footer d-flex justify-content-between align-items-center">
            <strong>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></strong>
            <a href="produto.php?id=<?= $produto['id'] ?>" class="btn btn-success btn-sm">Ver detalhes</a>
            </form>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</main>
    <!-- Dropdown script -->
    <script>
        const userIcon = document.getElementById('user-icon');
        const dropdown = document.getElementById('user-dropdown');

        userIcon?.addEventListener('click', (e) => {
            e.preventDefault();
            dropdown.classList.toggle('hidden');
        });

        window.addEventListener('click', function (e) {
            if (!userIcon?.contains(e.target) && !dropdown?.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
