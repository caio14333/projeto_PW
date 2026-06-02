<?php

session_start();

// Importar arquivo de conexão
require_once '../conexao.php';

// Verificar se o admin está logado
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../login.php');
    exit();
}

// Variáveis para controlar mensagens
$erro = '';
$sucesso = '';

// Processar formulário quando POST é recebido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Receber dados do formulário
    $nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $telefone = isset($_POST['telefone']) ? trim($_POST['telefone']) : '';

    // Validar campos
    if (empty($nome)) {
        $erro = 'O nome do cliente é obrigatório!';
    } elseif (empty($email)) {
        $erro = 'O email do cliente é obrigatório!';
    } elseif (empty($telefone)) {
        $erro = 'O telefone do cliente é obrigatório!';
    } else {
        // Preparar consulta com prepared statement (segurança contra SQL Injection)
        $sql = 'INSERT INTO clientes (nome, email, telefone) VALUES (?, ?, ?)';
        $stmt = $conexao->prepare($sql);

        if ($stmt) {
            // Vincular parâmetros
            $stmt->bind_param('sss', $nome, $email, $telefone);

            // Executar inserção
            if ($stmt->execute()) {
                // Sucesso! Redirecionar para a lista
                header('Location: index.php?sucesso=Cliente criado com sucesso!');
                exit();
            } else {
                $erro = 'Erro ao criar cliente: ' . $stmt->error;
            }

            // Fechar statement
            $stmt->close();
        } else {
            $erro = 'Erro ao preparar consulta: ' . $conexao->error;
        }
    }
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Cliente - Leste Design</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <!-- HEADER -->
    <header>
        <div class="container">
            <a href="../dashboard.php" class="logo">◆ Leste Design</a>
            
            <div class="user-info">
                <span>Bem-vindo, <strong><?php echo htmlspecialchars($_SESSION['admin_nome']); ?></strong></span>
                <a href="../logout.php" class="logout-btn">Sair</a>
            </div>
        </div>
    </header>

    <!-- LAYOUT PRINCIPAL -->
    <div class="layout-dashboard">
        <!-- SIDEBAR/MENU LATERAL -->
        <aside class="sidebar">
            <ul>
                <li><a href="../dashboard.php">📊 Dashboard</a></li>
                <li><a href="index.php" class="active">👥 Clientes</a></li>
                <li><a href="../servicos/index.php">🔧 Serviços</a></li>
                <li><a href="../orcamentos/index.php">📋 Orçamentos</a></li>
            </ul>
        </aside>

        <!-- CONTEÚDO PRINCIPAL -->
        <main>
            <!-- Título -->
            <h1>➕ Novo Cliente</h1>
            <p>Preencha os dados abaixo para criar um novo cliente.</p>

            <!-- Exibir erro se houver -->
            <?php if (!empty($erro)): ?>
                <div class="alerta alerta-erro">
                    <?php echo htmlspecialchars($erro); ?>
                </div>
            <?php endif; ?>

            <!-- Formulário -->
            <div class="card">
                <form method="POST" action="">
                    <!-- Campo: Nome -->
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

                    <!-- Campo: Email -->
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

                    <!-- Campo: Telefone -->
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

                    <!-- Botões de Ação -->
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
</body>
</html>
