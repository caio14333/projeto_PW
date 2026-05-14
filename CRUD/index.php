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

    <header>
        <h1>Eloisa Lash</h1>
    </header>

    <main>

        <div class="form-container" style="max-width: 400px; margin: 50px auto;">

            <h2>Login</h2>

            <?php
            if (isset($_SESSION["cadastro_sucesso"])) {
                echo '<div class="success">' . $_SESSION["cadastro_sucesso"] . '</div>';
                unset($_SESSION["cadastro_sucesso"]);
            }
            ?>

            <form method="POST">

                <div class="form-group">
                    <label>E-mail:</label>
                    <input type="email" name="email" required>
                </div>

                <div class="form-group">
                    <label>Senha:</label>
                    <input type="password" name="senha" required>
                </div>

                <button type="submit" style="width: 100%;">Entrar</button>

            </form>

            <p style="margin-top: 20px; text-align: center;">
                Não possui conta? <a href="cadastro.php"><strong>Cadastre-se aqui</strong></a>
            </p>

            <?php
            if ($erro) {
                echo '<div class="error" style="margin-top: 20px;">' . $erro . '</div>';
            }
            ?>

        </div>

    </main>

    <footer>
        <p>&copy; 2026 Eloisa Lash. Feito por: Luis Caio - Infor2.</p>
    </footer>

</body>

</html>