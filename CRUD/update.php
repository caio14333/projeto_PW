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
    <style>
        .edit-container {
            max-width: 600px;
            margin: 30px auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-left: 4px solid #6a1b9a;
        }

        .edit-form button {
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

        .edit-form button:hover {
            background-color: #4a148c;
        }

        .edit-form button:active {
            transform: translateY(0);
        }

        .no-cliente {
            text-align: center;
            padding: 40px;
            color: #666;
            background-color: #f3e5f5;
            border-radius: 8px;
            margin: 30px auto;
            max-width: 600px;
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
        <h2>Editar Cliente</h2>

        <?php if ($cliente): ?>
            <div class="edit-container">
                <form method="POST" class="edit-form">
                    <input type="hidden" name="id" value="<?php echo $cliente['id'] ?? ''; ?>">

                    <div class="form-group">
                        <label for="nome">Nome:</label>
                        <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($cliente['nome'] ?? ''); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="telefone">Telefone:</label>
                        <input type="text" id="telefone" name="telefone" value="<?php echo htmlspecialchars($cliente['telefone'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label for="instagram">Instagram:</label>
                        <input type="text" id="instagram" name="instagram" value="<?php echo htmlspecialchars($cliente['instagram'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label for="observacoes">Observações:</label>
                        <textarea id="observacoes" name="observacoes"><?php echo htmlspecialchars($cliente['observacoes'] ?? ''); ?></textarea>
                    </div>

                    <button type="submit">Atualizar Cliente</button>
                </form>
            </div>
        <?php else: ?>
            <div class="no-cliente">
                <p>⚠️ Nenhum cliente selecionado para editar.</p>
                <p><a href="read.php">Voltar para Ver Clientes</a></p>
            </div>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; 2026 Eloisa Lash. Todos os direitos reservados.</p>
    </footer>
</body>

</html>