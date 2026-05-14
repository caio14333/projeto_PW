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
            header("Location: create.php?sucesso=1");
            exit();
        }
    } catch (PDOException $e) {
        $mensagem = "Erro ao cadastrar: " . $e->getMessage();
    }
}

if (isset($_GET['sucesso'])) {
    $mensagem = "✅ Cliente cadastrado com sucesso! Preencha o formulário abaixo para cadastrar outro.";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Cliente</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .create-container {
            max-width: 600px;
            margin: 30px auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-left: 4px solid #6a1b9a;
        }

        .create-form button {
            width: 100%;
            background-color: #6a1b9a;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }

        .create-form button:hover {
            background-color: #4a148c;
        }

        .success-msg {
            background-color: #c8e6c9;
            color: #2e7d32;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #2e7d32;
        }
    </style>
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

        <?php if ($mensagem) echo "<div class='success-msg'>$mensagem</div>"; ?>

        <div class="create-container">
            <form method="POST" class="create-form">
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" required>
                </div>

                <div class="form-group">
                    <label for="telefone">Telefone:</label>
                    <input type="text" id="telefone" name="telefone">
                </div>

                <div class="form-group">
                    <label for="instagram">Instagram:</label>
                    <input type="text" id="instagram" name="instagram">
                </div>

                <div class="form-group">
                    <label for="observacoes">Observações:</label>
                    <textarea id="observacoes" name="observacoes"></textarea>
                </div>

                <button type="submit">Cadastrar Cliente</button>
            </form>
        </div>
    </main>

    <footer>
        <p>&copy; 2026 Eloisa Lash. Todos os direitos reservados.</p>
    </footer>
</body>

</html>