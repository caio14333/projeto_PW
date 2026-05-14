<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Cadastro - Eloisa Lash</title>

    <link rel="stylesheet" href="style.css">
</head>
<body>

    <main>

        <h1>Cadastrar Conta</h1>

        <form action="processar_cadastro.php" method="POST">

            <label>Nome:</label>
            <input type="text" name="nome" required>

            <label>E-mail:</label>
            <input type="email" name="email" required>

            <label>Senha:</label>
            <input type="password" name="senha" required>

            <button type="submit">Cadastrar</button>

        </form>

        <p><a href="logout.php">Voltar ao Login</a></p>

    </main>

</body>
</html>