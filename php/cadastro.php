<?php
session_start();
require_once __DIR__ . '/../db_braza_in_foot/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $telefone = $_POST['telefone'];
    $endereco = $_POST['endereco'];
    $complemento = $_POST['complemento'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    $cep = $_POST['cep'];

    $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, telefone, endereco, complemento, bairro, cidade, estado, cep) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nome, $email, $senha, $telefone, $endereco, $complemento, $bairro, $cidade, $estado, $cep]);

    header('Location: login.php?cadastro=sucesso');
    exit;
}

include __DIR__ . '/header.php';
?>

<div class="container mt-5 mb-5">
    <h2 class="mb-4">Criar Conta</h2>
    <form method="post">
        <div class="row">
            <div class="col-md-6 mb-3"><input type="text" name="nome" class="form-control" placeholder="Nome completo" required></div>
            <div class="col-md-6 mb-3"><input type="email" name="email" class="form-control" placeholder="E-mail" required></div>
            <div class="col-md-6 mb-3"><input type="password" name="senha" class="form-control" placeholder="Senha" required></div>
            <div class="col-md-6 mb-3"><input type="text" name="telefone" class="form-control" placeholder="Telefone" required></div>
            <div class="col-12 mb-3"><input type="text" name="endereco" class="form-control" placeholder="Endereço" required></div>
            <div class="col-md-6 mb-3"><input type="text" name="complemento" class="form-control" placeholder="Complemento"></div>
            <div class="col-md-6 mb-3"><input type="text" name="bairro" class="form-control" placeholder="Bairro" required></div>
            <div class="col-md-6 mb-3"><input type="text" name="cidade" class="form-control" placeholder="Cidade" required></div>
            <div class="col-md-3 mb-3"><input type="text" name="estado" class="form-control" placeholder="Estado" required></div>
            <div class="col-md-3 mb-3"><input type="text" name="cep" class="form-control" placeholder="CEP" required></div>
        </div>
        <button type="submit" class="btn btn-success w-100">Cadastrar</button>
        <p class="mt-3">Já tem uma conta? <a href="login.php">Entrar</a></p>
    </form>
</div>

<?php include __DIR__ . '/footer.php'; ?>
