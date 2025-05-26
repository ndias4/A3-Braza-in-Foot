<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php?erro=login_requerido');
    exit;
}

require_once __DIR__ . '/../db_braza_in_foot/db.php';

$id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT nome, endereco, complemento, bairro, cidade, estado, cep, telefone FROM usuarios WHERE id = ?");
$stmt->execute([$id]);
$usuario = $stmt->fetch();

$produto = [
    'nome' => 'Tênis New Balance 725 White Beige',
    'imagem' => '../images/tenis-nb1.png',
    'preco_pix' => 799.99,
    'preco_cartao' => 899.99,
    'quantidade' => 1,
    'tamanho' => 42
];

// Inclui o cabeçalho com o badge do carrinho
include __DIR__ . '/header.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Pagamento - Braza in Foot</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/styleHome.css">
</head>
<body class="bg-light">
<div class="container py-5">
    <h2 class="mb-4">Endereço e Pagamento</h2>
    <div class="row g-4">

        <!-- Endereço -->
        <div class="col-md-4">
            <div class="card p-3">
                <h5>1. Endereços</h5>
                <p><strong><?= $usuario['nome'] ?></strong><br>
                    <?= $usuario['endereco'] ?>, <?= $usuario['complemento'] ?><br>
                    <?= $usuario['bairro'] ?> - <?= $usuario['cidade'] ?> - <?= $usuario['estado'] ?><br>
                    <?= $usuario['cep'] ?><br>
                    <?= $usuario['telefone'] ?>
                </p>
                <a href="#" class="text-primary">Editar</a> | <a href="#" class="text-primary">Selecionar outro</a>
                <hr>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" checked>
                    <label class="form-check-label">Endereço de cobrança igual ao de entrega</label>
                </div>
                <button class="btn btn-outline-success w-100 mt-2">Inserir novo endereço</button>
            </div>
        </div>

        <!-- Entrega e Pagamento -->
        <div class="col-md-4">
            <div class="card p-3 mb-4">
                <h5>2. Opções de Entrega</h5>
                <div class="form-check">
                    <input class="form-check-input" type="radio" checked>
                    <label class="form-check-label">
                        Normal - até 20/mai <strong class="text-success">Grátis</strong>
                        <small class="d-block">Pedido liberado após confirmação de pagamento.</small>
                    </label>
                </div>
            </div>

            <div class="card p-3">
                <h5>3. Forma de Pagamento</h5>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="pagamento" id="pix" checked>
                    <label class="form-check-label" for="pix">Pix <span class="text-success">(Receba mais rápido)</span></label>
                </div>
                <div class="form-check mt-2">
                    <input class="form-check-input" type="radio" name="pagamento" id="cartao">
                    <label class="form-check-label" for="cartao">Cartão de Crédito</label>
                </div>
                <input type="text" class="form-control mt-3" placeholder="Número do cartão">
                <div class="row mt-2">
                    <div class="col">
                        <input type="text" class="form-control" placeholder="MM/AAAA">
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" placeholder="CVV">
                    </div>
                </div>
                <select class="form-select mt-2">
                    <option>Selecione uma parcela</option>
                    <option>1x sem juros</option>
                    <option>2x sem juros</option>
                </select>
                <button class="btn btn-outline-success w-100 mt-3">Inserir novo cartão</button>
            </div>
        </div>

        <!-- Resumo -->
        <div class="col-md-4">
            <div class="card p-3">
                <h5>Resumo</h5>
                <div class="d-flex mb-2">
                    <img src="<?= $produto['imagem'] ?>" alt="Produto" class="me-2" width="60">
                    <div>
                        <strong><?= $produto['nome'] ?></strong><br>
                        Tam: <?= $produto['tamanho'] ?> | Quant: <?= $produto['quantidade'] ?><br>
                        <small class="text-muted"><del>R$ 399,99</del></small><br>
                        <span class="text-success">R$ <?= number_format($produto['preco_pix'], 2, ',', '.') ?> no Pix</span><br>
                        <span>R$ <?= number_format($produto['preco_cartao'], 2, ',', '.') ?> no Cartão</span>
                    </div>
                </div>
                <hr>
                <h6>Cupom ou Vale Troca</h6>
                <input type="text" class="form-control mb-2" placeholder="Digite o cupom">
                <button class="btn btn-outline-secondary w-100">Aplicar</button>
                <hr>
                <div class="d-flex justify-content-between">
                    <span>Subtotal</span>
                    <strong>R$ <?= number_format($produto['preco_cartao'], 2, ',', '.') ?></strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Entrega</span>
                    <strong class="text-success">Grátis</strong>
                </div>
                <hr>
                <div class="d-flex justify-content-between fs-5">
                    <strong>Total</strong>
                    <strong class="text-primary">R$ <?= number_format($produto['preco_cartao'], 2, ',', '.') ?></strong>
                </div>
                <button class="btn btn-primary w-100 mt-3">Finalizar Compra</button>
            </div>
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
</body>
</html>
