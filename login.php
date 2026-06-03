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
        
        $admin_email = 'admin@eloisalashdesign.com';
        $admin_senha = 'admin123';
        $admin_nome = 'Administrador';

        
        if ($email === $admin_email && $senha === $admin_senha) {
            
            $_SESSION['admin_id'] = 1;
            $_SESSION['admin_email'] = $admin_email;
            $_SESSION['admin_nome'] = $admin_nome;

            
            header('Location: dashboard.php');
            exit();
        } else {
            
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
    <title>Login - Eloisa Lash Design</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    
    <div class="flex-center">
        
        <div class="login-container">
            
            <div class="login-logo">
                ◆
            </div>

            
            <h1>Eloisa Lash Design</h1>
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
                        placeholder="admin@eloisalashdesign.com"
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
            <p style="font-size: 12px; text-align: center;">
                <strong>Dados de Teste:</strong><br>
                Email: admin@eloisalashdesign.com<br>
                Senha: admin123
            </p>
        </div>
    </div>
</body>
</html>


