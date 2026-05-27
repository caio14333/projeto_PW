<?php
/**
 * ========================================
 * ARQUIVO: servicos/create.php
 * Descrição: Criar novo serviço
 * CRUD - CREATE (Criação)
 * ========================================
 */

// Iniciar sessão
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

// Processar formulário quando POST é recebido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Receber dados do formulário
    $nome_servico = isset($_POST['nome_servico']) ? trim($_POST['nome_servico']) : '';
    $descricao = isset($_POST['descricao']) ? trim($_POST['descricao']) : '';
    $preco = isset($_POST['preco']) ? trim($_POST['preco']) : '';

    // Validar campos
    if (empty($nome_servico)) {
        $erro = 'O nome do serviço é obrigatório!';
    } elseif (empty($descricao)) {
        $erro = 'A descrição do serviço é obrigatória!';
    } elseif (empty($preco)) {
        $erro = 'O preço do serviço é obrigatório!';
    } elseif (!is_numeric($preco) || $preco <= 0) {
        $erro = 'O preço deve ser um número válido e maior que zero!';
    } else {
        // Converter preço para formato correto (ponto como separador decimal)
        $preco = str_replace(',', '.', $preco);

        // Preparar consulta com prepared statement
        $sql = 'INSERT INTO servicos (nome_servico, descricao, preco) VALUES (?, ?, ?)';
        $stmt = $conexao->prepare($sql);

        if ($stmt) {
            // Vincular parâmetros
            $stmt->bind_param('ssd', $nome_servico, $descricao, $preco);

            // Executar inserção
            if ($stmt->execute()) {
                // Sucesso! Redirecionar para a lista
                header('Location: index.php?sucesso=Serviço criado com sucesso!');
                exit();
            } else {
                $erro = 'Erro ao criar serviço: ' . $stmt->error;
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
    <title>Novo Serviço - Leste Design</title>
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
                <li><a href="../clientes/index.php">👥 Clientes</a></li>
                <li><a href="index.php" class="active">🔧 Serviços</a></li>
                <li><a href="../orcamentos/index.php">📋 Orçamentos</a></li>
            </ul>
        </aside>

        <!-- CONTEÚDO PRINCIPAL -->
        <main>
            <!-- Título -->
            <h1>➕ Novo Serviço</h1>
            <p>Preencha os dados abaixo para criar um novo serviço.</p>

            <!-- Exibir erro se houver -->
            <?php if (!empty($erro)): ?>
                <div class="alerta alerta-erro">
                    <?php echo htmlspecialchars($erro); ?>
                </div>
            <?php endif; ?>

            <!-- Formulário -->
            <div class="card">
                <form method="POST" action="">
                    <!-- Campo: Nome do Serviço -->
                    <div class="form-group">
                        <label for="nome_servico">Nome do Serviço *</label>
                        <input 
                            type="text" 
                            id="nome_servico" 
                            name="nome_servico" 
                            required
                            placeholder="Ex: Design de Logo"
                            value="<?php echo isset($_POST['nome_servico']) ? htmlspecialchars($_POST['nome_servico']) : ''; ?>"
                        >
                    </div>

                    <!-- Campo: Descrição -->
                    <div class="form-group">
                        <label for="descricao">Descrição *</label>
                        <textarea 
                            id="descricao" 
                            name="descricao" 
                            required
                            placeholder="Descreva os detalhes do serviço"
                        ><?php echo isset($_POST['descricao']) ? htmlspecialchars($_POST['descricao']) : ''; ?></textarea>
                    </div>

                    <!-- Campo: Preço -->
                    <div class="form-group">
                        <label for="preco">Preço (R$) *</label>
                        <input 
                            type="number" 
                            id="preco" 
                            name="preco" 
                            required
                            placeholder="0,00"
                            step="0.01"
                            min="0"
                            value="<?php echo isset($_POST['preco']) ? htmlspecialchars($_POST['preco']) : ''; ?>"
                        >
                    </div>

                    <!-- Botões de Ação -->
                    <div class="btn-group">
                        <button type="submit" class="btn btn-principal">
                            ✅ Salvar Serviço
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
