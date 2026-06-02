<?php

require_once '../conexao.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$id = intval($_GET['id']);

$sql = 'SELECT id, nome_cliente, servico, valor, status FROM orcamentos WHERE id = ?';
$stmt = $conexao->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    header('Location: index.php');
    exit();
}

$orcamento = $resultado->fetch_assoc();
$stmt->close();

$sql_clientes = 'SELECT nome FROM clientes ORDER BY nome ASC';
$resultado_clientes = $conexao->query($sql_clientes);

$sql_servicos = 'SELECT nome_servico, preco FROM servicos ORDER BY nome_servico ASC';
$resultado_servicos = $conexao->query($sql_servicos);

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $nome_cliente = isset($_POST['nome_cliente']) ? trim($_POST['nome_cliente']) : '';
    $servico = isset($_POST['servico']) ? trim($_POST['servico']) : '';
    $valor = isset($_POST['valor']) ? trim($_POST['valor']) : '';
    $status = isset($_POST['status']) ? trim($_POST['status']) : '';

    
    if (empty($nome_cliente)) {
        $erro = 'O nome do cliente é obrigatório!';
    } elseif (empty($servico)) {
        $erro = 'O serviço é obrigatório!';
    } elseif (empty($valor)) {
        $erro = 'O valor do orçamento é obrigatório!';
    } elseif (!is_numeric($valor) || $valor <= 0) {
        $erro = 'O valor deve ser um número válido e maior que zero!';
    } elseif (empty($status)) {
        $erro = 'O status é obrigatório!';
    } else {
        
        $valor = str_replace(',', '.', $valor);

        
        $sql = 'UPDATE orcamentos SET nome_cliente = ?, servico = ?, valor = ?, status = ? WHERE id = ?';
        $stmt = $conexao->prepare($sql);

        if ($stmt) {
            
            $stmt->bind_param('ssdsi', $nome_cliente, $servico, $valor, $status, $id);

            
            if ($stmt->execute()) {
                
                header('Location: index.php?sucesso=Orçamento atualizado com sucesso!');
                exit();
            } else {
                $erro = 'Erro ao atualizar orçamento: ' . $stmt->error;
            }

            
            $stmt->close();
        } else {
            $erro = 'Erro ao preparar consulta: ' . $conexao->error;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_POST['nome_cliente'] = $orcamento['nome_cliente'];
    $_POST['servico'] = $orcamento['servico'];
    $_POST['valor'] = $orcamento['valor'];
    $_POST['status'] = $orcamento['status'];
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Orçamento - Leste Design</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    
    <header>
        <div class="container">
            <a href="../dashboard.php" class="logo">◆ Leste Design</a>
            
            <div class="user-info">
                <span>Bem-vindo, <strong>Administrador</strong></span>
            </div>
        </div>
    </header>

    
    <div class="layout-dashboard">
        
        <aside class="sidebar">
            <ul>
                <li><a href="../dashboard.php">📊 Dashboard</a></li>
                <li><a href="../clientes/index.php">👥 Clientes</a></li>
                <li><a href="../servicos/index.php">🔧 Serviços</a></li>
                <li><a href="index.php" class="active">📋 Orçamentos</a></li>
            </ul>
        </aside>

        
        <main>
            
            <h1>✏️ Editar Orçamento</h1>
            <p>Atualize os dados do orçamento abaixo.</p>

            
            <?php if (!empty($erro)): ?>
                <div class="alerta alerta-erro">
                    <?php echo htmlspecialchars($erro); ?>
                </div>
            <?php endif; ?>

            
            <div class="card">
                <form method="POST" action="">
                    
                    <div class="form-group">
                        <label for="nome_cliente">Nome do Cliente *</label>
                        <select 
                            id="nome_cliente" 
                            name="nome_cliente" 
                            required
                        >
                            <option value="">-- Selecione um cliente --</option>
                            <?php 
                            
                            $resultado_clientes = $conexao->query($sql_clientes);
                            while ($cliente = $resultado_clientes->fetch_assoc()): 
                            ?>
                                <option 
                                    value="<?php echo htmlspecialchars($cliente['nome']); ?>"
                                    <?php echo $_POST['nome_cliente'] === $cliente['nome'] ? 'selected' : ''; ?>
                                >
                                    <?php echo htmlspecialchars($cliente['nome']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    
                    <div class="form-group">
                        <label for="servico">Serviço *</label>
                        <select 
                            id="servico" 
                            name="servico" 
                            required
                        >
                            <option value="">-- Selecione um serviço --</option>
                            <?php 
                            
                            $resultado_servicos = $conexao->query($sql_servicos);
                            while ($servico = $resultado_servicos->fetch_assoc()): 
                            ?>
                                <option 
                                    value="<?php echo htmlspecialchars($servico['nome_servico']); ?>"
                                    <?php echo $_POST['servico'] === $servico['nome_servico'] ? 'selected' : ''; ?>
                                >
                                    <?php echo htmlspecialchars($servico['nome_servico']); ?> - R$ <?php echo number_format($servico['preco'], 2, ',', '.'); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    
                    <div class="form-group">
                        <label for="valor">Valor (R$) *</label>
                        <input 
                            type="number" 
                            id="valor" 
                            name="valor" 
                            required
                            placeholder="0,00"
                            step="0.01"
                            min="0"
                            value="<?php echo htmlspecialchars($_POST['valor']); ?>"
                        >
                    </div>

                    
                    <div class="form-group">
                        <label for="status">Status *</label>
                        <select 
                            id="status" 
                            name="status" 
                            required
                        >
                            <option value="Pendente" <?php echo $_POST['status'] === 'Pendente' ? 'selected' : ''; ?>>Pendente</option>
                            <option value="Aprovado" <?php echo $_POST['status'] === 'Aprovado' ? 'selected' : ''; ?>>Aprovado</option>
                            <option value="Recusado" <?php echo $_POST['status'] === 'Recusado' ? 'selected' : ''; ?>>Recusado</option>
                            <option value="Finalizado" <?php echo $_POST['status'] === 'Finalizado' ? 'selected' : ''; ?>>Finalizado</option>
                        </select>
                    </div>

                    
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


