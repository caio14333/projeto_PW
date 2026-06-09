<?php

require_once '../conexao.php';

$erro = '';
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $telefone = isset($_POST['telefone']) ? trim($_POST['telefone']) : '';

    
    if (empty($nome)) {
        $erro = 'O nome do cliente é obrigatório!';
    } elseif (empty($email)) {
        $erro = 'O email do cliente é obrigatório!';
    } elseif (empty($telefone)) {
        $erro = 'O telefone do cliente é obrigatório!';
    } else {
        
        $sql = 'INSERT INTO clientes (nome, email, telefone) VALUES (?, ?, ?)';
        $stmt = $conexao->prepare($sql);

        if ($stmt) {
            
            $stmt->bind_param('sss', $nome, $email, $telefone);

            
            if ($stmt->execute()) {
                
                header('Location: index.php?sucesso=Cliente criado com sucesso!');
                exit();
            } else {
                $erro = 'Erro ao criar cliente: ' . $stmt->error;
            }

            
            $stmt->close();
        } else {
            $erro = 'Erro ao preparar consulta: ' . $conexao->error;
        }
    }
}

?>
<?php
    $pageTitle = 'Novo Cliente - Eloísa Leste Design';
    $basePath = '..';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <link rel="stylesheet" href="<?php echo $basePath; ?>/css/style.css">
</head>
<body>
<header>
    <div class="container">
        <a href="<?php echo $basePath; ?>/dashboard.php" class="logo"><img src="<?php echo $basePath; ?>/logo.svg" alt="Eloisa lash Design" class="logo-img"></a>
        <div class="user-info">
            <span>Bem-vindo, <strong>Administrador</strong></span>
        </div>
    </div>
</header>
    <div class="layout-dashboard">
        <aside class="sidebar">
            <ul>
                <li><a href="../dashboard.php">📊 Dashboard</a></li>
                <li><a href="index.php" class="active">👥 Clientes</a></li>
                <li><a href="../servicos/index.php">🔧 Serviços</a></li>
                <li><a href="../orcamentos/index.php">📋 Orçamentos</a></li>
            </ul>
        </aside>

        <main>
            <h1>➕ Novo Cliente</h1>
            <p>Preencha os dados abaixo para criar um novo cliente.</p>

            <?php if (!empty($erro)): ?>
                <div class="alerta alerta-erro">
                    <?php echo htmlspecialchars($erro); ?>
                </div>
            <?php endif; ?>

            <div class="card">
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="nome">Nome do Cliente *</label>
                        <input 
                            type="text" 
                            id="nome" 
                            name="nome" 
                            required
                            placeholder="Digite o nome completo"
                            value="<?php echo isset($_POST['nome']) ? htmlspecialchars($_POST['nome']) : ''; ?>"
                        >
                    </div>

                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            required
                            placeholder="cliente@email.com"
                            value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                        >
                    </div>

                    <div class="form-group">
                        <label for="telefone">Telefone *</label>
                        <input 
                            type="text" 
                            id="telefone" 
                            name="telefone" 
                            required
                            placeholder="(11) 98765-4321"
                            value="<?php echo isset($_POST['telefone']) ? htmlspecialchars($_POST['telefone']) : ''; ?>"
                        >
                    </div>

                    <div class="btn-group">
                        <button type="submit" class="btn btn-principal">
                            ✅ Salvar Cliente
                        </button>
                        <a href="index.php" class="btn btn-voltar">
                            ← Voltar
                        </a>
                    </div>
                </form>
            </div>
        </main>
    </div>
    </div>
<footer>
    <div class="container">
        <p style="font-size:12px;color:#888;">Desenvolvido por: Luis Caio - Infor 2</p>
    </div>
</footer>
</body>
</html>


