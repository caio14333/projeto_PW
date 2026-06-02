<?php


// Iniciar sessão
session_start();

// Importar arquivo de conexão
require_once '../conexao.php';

// Verificar se o admin está logado
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../login.php');
    exit();
}

// Verificar se ID foi passado via GET
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php');
    exit();
}

// Receber e validar ID
$id = intval($_GET['id']);

// Buscar cliente no banco de dados
$sql = 'SELECT id, nome, email, telefone FROM clientes WHERE id = ?';
$stmt = $conexao->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$resultado = $stmt->get_result();

// Verificar se cliente existe
if ($resultado->num_rows === 0) {
    header('Location: index.php');
    exit();
}

// Obter dados do cliente
$cliente = $resultado->fetch_assoc();
$stmt->close();

// Variáveis para controlar mensagens
$erro = '';

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
        // Preparar consulta para atualizar (UPDATE)
        $sql = 'UPDATE clientes SET nome = ?, email = ?, telefone = ? WHERE id = ?';
        $stmt = $conexao->prepare($sql);

        if ($stmt) {
            // Vincular parâmetros
            $stmt->bind_param('sssi', $nome, $email, $telefone, $id);

            // Executar atualização
            if ($stmt->execute()) {
                // Sucesso! Redirecionar para a lista
                header('Location: index.php?sucesso=Cliente atualizado com sucesso!');
                exit();
            } else {
                $erro = 'Erro ao atualizar cliente: ' . $stmt->error;
            }

            // Fechar statement
            $stmt->close();
        } else {
            $erro = 'Erro ao preparar consulta: ' . $conexao->error;
        }
    }
}

// Se o formulário não foi enviado, usar dados do banco
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_POST['nome'] = $cliente['nome'];
    $_POST['email'] = $cliente['email'];
    $_POST['telefone'] = $cliente['telefone'];
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente - Leste Design</title>
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
            <h1>✏️ Editar Cliente</h1>
            <p>Atualize os dados do cliente abaixo.</p>

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
                            value="<?php echo htmlspecialchars($_POST['nome']); ?>"
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
                            value="<?php echo htmlspecialchars($_POST['email']); ?>"
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
                            value="<?php echo htmlspecialchars($_POST['telefone']); ?>"
                        >
                    </div>

                    <!-- Botões de Ação -->
                    <div class="btn-group">
                        <button type="submit" class="btn btn-principal">
                            ✅ Salvar Alterações
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
