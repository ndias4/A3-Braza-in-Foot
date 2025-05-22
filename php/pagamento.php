<?php
session_start();

// Simulação de dados
$usuario = [
    'nome' => 'Fernando Dias',
    'endereco' => 'Rua Barão de Iguape, 985',
    'complemento' => 'Apto 918',
    'bairro' => 'Liberdade',
    'cep' => '01507-001',
    'cidade' => 'São Paulo',
    'estado' => 'SP',
    'telefone' => '11991686512'
];

$produto = [
    'nome' => 'Tênis New Balance 725 White Beige',
    'imagem' => '../images/tenis-nb1.png',
    'preco_pix' => 799.99,
    'preco_cartao' => 899.99,
    'quantidade' => 1,
    'tamanho' => 42
];
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

</body>
</html>
