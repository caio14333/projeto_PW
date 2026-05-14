<?php
session_start();
include '../conexao.php';

$sql = "SELECT * FROM clientes";
$stmt = $conect->query($sql);
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Clientes</title>
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
        <h2>Lista de Clientes</h2>

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
                            <td style="display: flex; gap: 10px;">
                                <a href="update.php?id=<?php echo $cliente['id'] ?? ''; ?>" style="text-decoration: none;">
                                    <button style="background-color: #6a1b9a; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer;">✏️ Editar</button>
                                </a>
                                <a href="delete.php?id=<?php echo $cliente['id'] ?? ''; ?>" style="text-decoration: none;">
                                    <button style="background-color: #c62828; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer;">🗑️ Deletar</button>
                                </a>
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