<?php
session_start();
include '../conexao.php';

$mensagem = "";
$cliente = null;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM clientes WHERE id = :id";
    $stmt = $conect->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $instagram = $_POST['instagram'];
    $observacoes = $_POST['observacoes'];

    $sql = "UPDATE clientes SET nome = :nome, telefone = :telefone, instagram = :instagram, observacoes = :observacoes WHERE id = :id";
    
    try {
        $stmt = $conect->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':instagram', $instagram);
        $stmt->bindParam(':observacoes', $observacoes);
        
        if ($stmt->execute()) {
            $mensagem = "Cliente atualizado com sucesso!";
            header("Location: read.php");
            exit();
        }
    } catch (PDOException $e) {
        $mensagem = "Erro ao atualizar: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
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
        <h2>Editar Cliente</h2>

        <?php if ($mensagem) echo "<p style='color: green;'>$mensagem</p>"; ?>

        <?php if ($cliente): ?>
            <form method="POST">
                <input type="hidden" name="id" value="<?php echo $cliente['id']; ?>">

                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" value="<?php echo $cliente['nome']; ?>" required>

                <label for="telefone">Telefone:</label>
                <input type="text" id="telefone" name="telefone" value="<?php echo $cliente['telefone']; ?>">

                <label for="instagram">Instagram:</label>
                <input type="text" id="instagram" name="instagram" value="<?php echo $cliente['instagram']; ?>">

                <label for="observacoes">Observações:</label>
                <textarea id="observacoes" name="observacoes"><?php echo $cliente['observacoes']; ?></textarea>

                <button type="submit">Atualizar</button>
            </form>
        <?php else: ?>
            <p>Selecione um cliente para editar em "Ver Clientes".</p>
        <?php endif; ?>
    </main>
</body>
</html>
