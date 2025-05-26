<?php
session_start();
require_once __DIR__ . '/../db_braza_in_foot/db.php';

// Redireciona para login se não estiver logado
if (!isset($_SESSION['user_id'])) {
    header('Location: index.html');
    exit;
}

// Busca os produtos do banco
$stmt = $pdo->query("SELECT * FROM produtos");
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Inclui o cabeçalho com o badge do carrinho
include __DIR__ . '/header.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Loja - Braza in Foot</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Estilo personalizado -->
    <link rel="stylesheet" href="../CSS/styleHome.css" />
</head>
<body>
<!-- Carrossel Bootstrap -->
<div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel" aria-label="Carrossel de banners">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="../images/Banner Tenis 2.png" class="d-block w-100" alt="Banner 1" />
        </div>
        <div class="carousel-item">
            <img src="../images/Banner Tenis 3.png" class="d-block w-100" alt="Banner 2" />
        </div>
        <div class="carousel-item">
            <img src="../images/Banner Tenis 4.png" class="d-block w-100" alt="Banner 3" />
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev" aria-label="Anterior">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next" aria-label="Próximo">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>

<main class="container my-5">
    <h2 class="mb-4 text-center">Mais Vendidos</h2>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php foreach ($produtos as $produto): ?>
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <img src="../<?= htmlspecialchars($produto['imagem']) ?>" alt="<?= htmlspecialchars($produto['nome']) ?>" class="card-img-top" />
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
    </div>
</main>

<!-- Dropdown usuário script -->
<script>
    const userIcon = document.getElementById('user-icon');
    const dropdown = document.getElementById('user-dropdown');

    userIcon?.addEventListener('click', (e) => {
        e.preventDefault();
        dropdown.classList.toggle('hidden');
        userIcon.setAttribute('aria-expanded', dropdown.classList.contains('hidden') ? 'false' : 'true');
    });

    window.addEventListener('click', (e) => {
        if (!userIcon?.contains(e.target) && !dropdown?.contains(e.target)) {
            dropdown.classList.add('hidden');
            userIcon?.setAttribute('aria-expanded', 'false');
        }
    });
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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

