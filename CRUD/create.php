<?php
session_start();
include '../conexao.php';

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $instagram = $_POST['instagram'];
    $observacoes = $_POST['observacoes'];

    $sql = "INSERT INTO clientes (nome, telefone, instagram, observacoes) VALUES (:nome, :telefone, :instagram, :observacoes)";
    
    try {
        $stmt = $conect->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':instagram', $instagram);
        $stmt->bindParam(':observacoes', $observacoes);
        
        if ($stmt->execute()) {
            $mensagem = "Cliente cadastrado com sucesso!";
        }
    } catch (PDOException $e) {
        $mensagem = "Erro ao cadastrar: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Cliente</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Eloisa Lash</h1>
        <a href="dashboard.php" style="float: right;">
            <button>Voltar</button>
        </a>
    </header>

    <main>
        <h2>Cadastrar Cliente</h2>

        <?php if ($mensagem) echo "<p style='color: green;'>$mensagem</p>"; ?>

        <form method="POST">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone">

            <label for="instagram">Instagram:</label>
            <input type="text" id="instagram" name="instagram">

            <label for="observacoes">Observações:</label>
            <textarea id="observacoes" name="observacoes"></textarea>

            <button type="submit">Cadastrar</button>
        </form>
    </main>
</body>
</html>