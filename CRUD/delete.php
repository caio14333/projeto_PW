<?php
session_start();
include '../conexao.php';

$mensagem = "";
$clientes = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM clientes WHERE id = :id";

    try {
        $stmt = $conect->prepare($sql);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            header("Location: delete.php");
            exit();
        }
    } catch (PDOException $e) {
        $mensagem = "Erro ao deletar: " . $e->getMessage();
    }
}

$sql = "SELECT * FROM clientes";
$stmt = $conect->query($sql);
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deletar Cliente</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .delete-btn {
            background-color: #c62828;
            color: white;
            border: none;
            padding: 8px 15px;
            cursor: pointer;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .delete-btn:hover {
            background-color: #ad1457;
            transform: translateY(-2px);
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
        <h2>Deletar Cliente</h2>

        <?php if ($mensagem) echo "<div class='success-msg'>$mensagem</div>"; ?>

        <?php if (count($clientes) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Telefone</th>
                        <th>Instagram</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clientes as $cliente): ?>
                        <tr>
                            <td><?php echo $cliente['id'] ?? ''; ?></td>
                            <td><?php echo $cliente['nome'] ?? ''; ?></td>
                            <td><?php echo $cliente['telefone'] ?? ''; ?></td>
                            <td><?php echo $cliente['instagram'] ?? ''; ?></td>
                            <td>
                                <form method="POST" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja deletar?');">
                                    <input type="hidden" name="id" value="<?php echo $cliente['id'] ?? ''; ?>">
                                    <button type="submit" class="delete-btn">Deletar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Nenhum cliente cadastrado.</p>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; 2026 Eloisa Lash. Todos os direitos reservados.</p>
    </footer>
</body>

</html>