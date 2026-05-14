<?php
session_start();

// Processa o formulário de cadastro
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = isset($_POST["nome"]) ? trim($_POST["nome"]) : "";
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : "";
    $senha = isset($_POST["senha"]) ? trim($_POST["senha"]) : "";

    // Validações básicas
    if (empty($nome) || empty($email) || empty($senha)) {
        $erro = "Todos os campos são obrigatórios";
    } elseif (strlen($senha) < 6) {
        $erro = "A senha deve ter no mínimo 6 caracteres";
    } else {
        // Aqui você pode adicionar lógica para salvar no banco de dados
        $_SESSION["cadastro_sucesso"] = "Conta criada com sucesso! Faça login agora.";
        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cadastro - Eloisa Lash</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <header>
        <h1>Eloisa Lash</h1>
    </header>

    <main>

        <h2>Cadastrar Conta</h2>

        <?php
        if (isset($erro)) {
            echo '<div class="error">' . htmlspecialchars($erro) . '</div>';
        }
        ?>

        <form method="POST" class="form-container">

            <div class="form-group">
                <label>Nome:</label>
                <input type="text" name="nome" required>
            </div>

            <div class="form-group">
                <label>E-mail:</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label>Senha:</label>
                <input type="password" name="senha" required>
            </div>

            <button type="submit">Cadastrar</button>

        </form>

        <p style="margin-top: 20px;">Já possui conta? <a href="index.php">Faça login aqui</a></p>

    </main>

    <footer>
        <p>&copy; 2026 Eloisa Lash. Todos os direitos reservados.</p>
    </footer>

</body>

</html>