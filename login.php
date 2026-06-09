<?php


session_start();
require_once 'conexao.php';

if (isset($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit();
}


$erro = '';
$sucesso = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $senha = isset($_POST['senha']) ? $_POST['senha'] : '';

    if (empty($email) || empty($senha)) {
        $erro = 'Por favor, preencha todos os campos!';
    } else {
        $sql = 'SELECT id, email, senha, nome FROM administrador WHERE email = ?';
        $stmt = $conexao->prepare($sql);

        if ($stmt) {
            $stmt->bind_param('s', $email);
            $stmt->execute();

            $resultado = $stmt->get_result();

            if ($resultado->num_rows === 1) {
                $admin = $resultado->fetch_assoc();

                if (password_verify($senha, $admin['senha'])) {
                    $_SESSION['admin_id'] = $admin['id'];
                    $_SESSION['admin_email'] = $admin['email'];
                    $_SESSION['admin_nome'] = $admin['nome'];

                    header('Location: dashboard.php');
                    exit();
                } else {

                    $erro = 'Email ou senha incorretos!';
                }
            } else {
                $erro = 'Email ou senha incorretos!';
            }

            $stmt->close();
        } else {
            $erro = 'Erro ao processar login. Tente novamente!';
        }
    }
}
    // Autenticação fallback com credenciais solicitadas (caso não exista usuário no BD)
    if (!isset($_SESSION['admin_id']) && isset($email, $senha)) {
        if ($email === 'admin@eloisalash.com' && $senha === 'admin123') {
            $_SESSION['admin_id'] = 0;
            $_SESSION['admin_email'] = $email;
            $_SESSION['admin_nome'] = 'Administrador';
            header('Location: dashboard.php');
            exit();
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Eloisa lash Design</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
   -
    <div class="flex-center">
        <div class="login-container">
            <div class="login-logo">
                <img src="logo.svg" alt="Eloisa lash Design" class="logo-img-login">
            </div>
            <h1>Eloisa lash Design</h1>
            <p>Sistema de Gerenciamento</p>

            <?php if (!empty($erro)): ?>
                <div class="alerta alerta-erro">
                    <?php echo htmlspecialchars($erro); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="email">Email do Administrador</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        required
                        placeholder="admin@eloisalash.com"
                        value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                    >
                </div>

                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input 
                        type="password" 
                        id="senha" 
                        name="senha" 
                        required
                        placeholder="Digite sua senha"
                    >
                </div>

                <button type="submit" class="btn btn-principal" style="width: 100%;">
                    ENTRAR
                </button>
            </form>

            <hr style="margin: 30px 0; border: none; border-top: 1px solid #444;">
            <p style="font-size: 14px; text-align: center;">
                Faça o login de administrador para acessar o sistema.
            </p>
        </div>
    </div>
</body>
</html>
