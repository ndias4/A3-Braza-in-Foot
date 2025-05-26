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

// Inclui o cabeçalho com o badge do carrinho
include __DIR__ . '/header.php';
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
      cursor: pointer;
      user-select: none;
    }
    .tamanhos button:hover {
      border-color: #000;
    }
    .tamanhos button.selected {
      background-color: #003300;
      color: white;
      border-color: #003300;
    }
    .error-message {
      color: #cc0000;
      font-size: 0.9rem;
      margin-top: 5px;
      display: none;
    }
  </style>
</head>
<body>
<div class="container py-5">
  <div class="row g-5">

    <!-- IMAGEM -->
    <div class="col-md-6 text-center">
      <img src="../<?= htmlspecialchars($produto['imagem']) ?>" alt="<?= htmlspecialchars($produto['nome']) ?>" class="produto-imagem shadow-sm">
    </div>

    <!-- INFORMAÇÕES DO PRODUTO -->
    <div class="col-md-6 produto-info">
      <p class="text-muted">Tênis Masculino</p>
      <h1><?= htmlspecialchars($produto['nome']) ?></h1>
      <p class="produto-preco">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></p>
      <p><?= nl2br(htmlspecialchars($produto['descricao'])) ?></p>

      <!-- Opções de tamanho -->
      <div class="mb-4">
        <strong>Tamanho</strong>
        <div class="tamanhos d-flex flex-wrap mt-2" role="radiogroup" aria-label="Selecione o tamanho do tênis">
          <?php foreach ([34, 35, 36, 37, 38, 39, 40, 41, 42, 43] as $tamanho): ?>
            <button type="button" class="btn" role="radio" aria-checked="false" tabindex="0" data-tamanho="<?= $tamanho ?>"><?= $tamanho ?></button>
          <?php endforeach; ?>
        </div>
        <div id="tamanho-error" class="error-message" role="alert" aria-live="assertive"></div>
      </div>

      <!-- Formulário -->
      <form method="POST" action="addCarrinho.php" class="d-flex flex-column gap-2" id="form-produto">
        <input type="hidden" name="id" value="<?= $produto['id'] ?>">
        <input type="hidden" name="tamanho" id="input-tamanho" value="">
        <div class="d-flex gap-2 align-items-center mb-2">
          <label for="quantidade" class="me-2">Quantidade:</label>
          <input type="number" name="quantidade" id="quantidade" value="1" min="1" class="form-control w-25" aria-label="Quantidade do produto">
        </div>
        <button type="submit" class="btn btn-comprar">COMPRAR AGORA</button>
        <button type="submit" class="btn btn-carrinho">ADICIONAR AO CARRINHO</button>
      </form>
    </div>
  </div>
</div>

<footer class="rodape">
  <div class="rodape-container">
    <div class="rodape-info">
      <img class="logo" src="../images/IMG-20250409-WA0006.jpg" alt="Logo">
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

<script>
  (function(){
    const botoesTamanho = document.querySelectorAll('.tamanhos button');
    const inputTamanho = document.getElementById('input-tamanho');
    const form = document.getElementById('form-produto');
    const erroTamanho = document.getElementById('tamanho-error');

    // Função para limpar seleção
    function limparSelecao() {
      botoesTamanho.forEach(btn => {
        btn.classList.remove('selected');
        btn.setAttribute('aria-checked', 'false');
        btn.tabIndex = 0;
      });
      inputTamanho.value = '';
    }

    // Selecionar um tamanho
    botoesTamanho.forEach(btn => {
      btn.addEventListener('click', () => {
        // Se já está selecionado, desseleciona
        if(btn.classList.contains('selected')) {
          limparSelecao();
        } else {
          limparSelecao();
          btn.classList.add('selected');
          btn.setAttribute('aria-checked', 'true');
          inputTamanho.value = btn.dataset.tamanho;
          erroTamanho.style.display = 'none';
          erroTamanho.textContent = '';
        }
      });

      // Suporte para seleção via teclado (barra de espaço e Enter)
      btn.addEventListener('keydown', (e) => {
        if(e.key === ' ' || e.key === 'Enter') {
          e.preventDefault();
          btn.click();
        }
      });
    });

    // Validação antes de enviar o formulário
    form.addEventListener('submit', (e) => {
      if(!inputTamanho.value) {
        e.preventDefault();
        erroTamanho.textContent = 'Por favor, selecione um tamanho antes de continuar.';
        erroTamanho.style.display = 'block';
        // Focar no primeiro botão tamanho para facilitar correção
        botoesTamanho[0].focus();
      }
    });

  })();
</script>
</body>
</html>
