<?php
/**
 * ========================================
 * ARQUIVO: servicos/update.php
 * Descrição: Editar serviço existente
 * CRUD - UPDATE (Atualização)
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

// Verificar se ID foi passado via GET
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php');
    exit();
}

// Receber e validar ID
$id = intval($_GET['id']);

// Buscar serviço no banco de dados
$sql = 'SELECT id, nome_servico, descricao, preco FROM servicos WHERE id = ?';
$stmt = $conexao->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$resultado = $stmt->get_result();

// Verificar se serviço existe
if ($resultado->num_rows === 0) {
    header('Location: index.php');
    exit();
}

// Obter dados do serviço
$servico = $resultado->fetch_assoc();
$stmt->close();

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
        // Converter preço para formato correto
        $preco = str_replace(',', '.', $preco);

        // Preparar consulta para atualizar
        $sql = 'UPDATE servicos SET nome_servico = ?, descricao = ?, preco = ? WHERE id = ?';
        $stmt = $conexao->prepare($sql);

        if ($stmt) {
            // Vincular parâmetros
            $stmt->bind_param('ssdi', $nome_servico, $descricao, $preco, $id);

            // Executar atualização
            if ($stmt->execute()) {
                // Sucesso! Redirecionar para a lista
                header('Location: index.php?sucesso=Serviço atualizado com sucesso!');
                exit();
            } else {
                $erro = 'Erro ao atualizar serviço: ' . $stmt->error;
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
    $_POST['nome_servico'] = $servico['nome_servico'];
    $_POST['descricao'] = $servico['descricao'];
    $_POST['preco'] = $servico['preco'];
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Serviço - Leste Design</title>
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
            <h1>✏️ Editar Serviço</h1>
            <p>Atualize os dados do serviço abaixo.</p>

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
                            value="<?php echo htmlspecialchars($_POST['nome_servico']); ?>"
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
                        ><?php echo htmlspecialchars($_POST['descricao']); ?></textarea>
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
                            value="<?php echo htmlspecialchars($_POST['preco']); ?>"
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
