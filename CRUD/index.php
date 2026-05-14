<?php
session_start();

$usuarios = [
    "admin@email.com" => "123456"
];

$erro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $senha = $_POST["senha"];

    if (isset($usuarios[$email]) && $usuarios[$email] == $senha) {

        $_SESSION["usuario"] = $email;

        header("Location: dashboard.php");
        exit();

    } else {

        $erro = "E-mail ou senha incorretos!";

    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Login - Eloisa Lash</title>

    <link rel="stylesheet" href="style.css">
</head>
<body>

    <main>

        <h1>Eloisa Lash</h1>

        <h2>Login</h2>

        <form method="POST">

            <label>E-mail:</label>
            <input type="email" name="email" required>

            <label>Senha:</label>
            <input type="password" name="senha" required>

            <button type="submit">Entrar</button>

        </form>

        <br>

        <p>Não possui conta?</p>

        <a href="cadastro.php">
            <button>Cadastrar</button>
        </a>

        <p style="color:red;">
            <?php echo $erro; ?>
        </p>

    </main>

</body>
</html>