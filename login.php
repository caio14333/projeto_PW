<?php

session_start();

// Importar arquivo de conexão
require_once 'conexao.php';

// Se o usuário já está logado, redirecionar para dashboard
if (isset($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit();
}

// Variáveis para controlar mensagens
$erro = '';
$sucesso = '';

// Processar formulário quando POST é recebido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Receber dados do formulário
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $senha = isset($_POST['senha']) ? $_POST['senha'] : '';

    // Validar se os campos estão preenchidos
    if (empty($email) || empty($senha)) {
        $erro = 'Por favor, preencha todos os campos!';
    } else {
        // Credenciais fixas (sem banco de dados)
        $admin_email = 'admin@lestedesign.com';
        $admin_senha = 'admin123';
        $admin_nome = 'Administrador';

        // Verificar credenciais
        if ($email === $admin_email && $senha === $admin_senha) {
            // Credenciais corretas! Criar sessão
            $_SESSION['admin_id'] = 1;
            $_SESSION['admin_email'] = $admin_email;
            $_SESSION['admin_nome'] = $admin_nome;

            // Redirecionar para dashboard
            header('Location: dashboard.php');
            exit();
        } else {
            // Credenciais incorretas
            $erro = 'Email ou senha incorretos!';
        }
    }
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Leste Design</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Div centralizadora -->
    <div class="flex-center">
        <!-- Formulário de Login -->
        <div class="login-container">
            <!-- Logo/Ícone -->
            <div class="login-logo">
                ◆
            </div>

            <!-- Título -->
            <h1>Leste Design</h1>
            <p>Sistema de Gerenciamento</p>

            <!-- Exibir erro se houver -->
            <?php if (!empty($erro)): ?>
                <div class="alerta alerta-erro">
                    <?php echo htmlspecialchars($erro); ?>
                </div>
            <?php endif; ?>

            <!-- Formulário -->
            <form method="POST" action="">
                <!-- Campo: Email -->
                <div class="form-group">
                    <label for="email">Email do Administrador</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        required
                        placeholder="admin@lestedesign.com"
                        value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                    >
                </div>

                <!-- Campo: Senha -->
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

                <!-- Botão: Entrar -->
                <button type="submit" class="btn btn-principal" style="width: 100%;">
                    ENTRAR
                </button>
            </form>

            <!-- Informações de teste -->
            <hr style="margin: 30px 0; border: none; border-top: 1px solid #444;">
            <p style="font-size: 12px; text-align: center;">
                <strong>Dados de Teste:</strong><br>
                Email: admin@lashdesign.com<br>
                Senha: admin123
            </p>
        </div>
    </div>
</body>
</html>
