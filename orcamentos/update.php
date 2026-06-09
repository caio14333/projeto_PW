<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

require_once('../conexao.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$id = intval($_GET['id']);

try {
    $stmt = $conn->prepare('SELECT * FROM orcamentos WHERE id = :id');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $orcamento = $stmt->fetch();
} catch (PDOException $e) {
    header('Location: index.php');
    exit();
}

if (!$orcamento) {
    header('Location: index.php');
    exit();
}

$sql_clientes = 'SELECT nome FROM clientes ORDER BY nome ASC';
$sql_servicos = 'SELECT nome_servico, preco FROM servicos ORDER BY nome_servico ASC';
try {
    $resultado_clientes = $conn->query($sql_clientes)->fetchAll();
    $resultado_servicos = $conn->query($sql_servicos)->fetchAll();
} catch (PDOException $e) {
    $resultado_clientes = [];
    $resultado_servicos = [];
}

$erro = '';
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    try {
        $stmt = $conn->prepare("UPDATE orcamentos SET nome_cliente = :nome_cliente, servico = :servico, valor = :valor, status = :status WHERE id = :id");
        $stmt->bindValue(':nome_cliente', $_POST['nome_cliente']);
        $stmt->bindValue(':servico', $_POST['servico']);
        $stmt->bindValue(':valor', str_replace(',', '.', $_POST['valor']));
        $stmt->bindValue(':status', $_POST['status']);
        $stmt->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
        $stmt->execute();
        header('Location: index.php');
        exit();
    } catch (PDOException $e) {
        $erro = 'Erro ao atualizar orçamento: ' . $e->getMessage();
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
    <title>Editar Orçamento - Eloisa lash Design</title>
    <link rel="stylesheet" href="../css/style.css">
    </head>
<body>
    <header>
        <div class="container">
            <a href="../dashboard.php" class="logo"><img src="../logo.svg" alt="Eloisa lash Design" class="logo-img"></a>
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
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                    <div class="form-group">
                        <label for="nome_cliente">Nome do Cliente *</label>
                        <select id="nome_cliente" name="nome_cliente" required>
                            <option value="">-- Selecione um cliente --</option>
                            <?php foreach ($resultado_clientes as $cliente): ?>
                                <option value="<?php echo htmlspecialchars($cliente['nome']); ?>" <?php echo $_POST['nome_cliente'] === $cliente['nome'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($cliente['nome']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="servico">Serviço *</label>
                        <select id="servico" name="servico" required>
                            <option value="">-- Selecione um serviço --</option>
                            <?php foreach ($resultado_servicos as $servico): ?>
                                <option value="<?php echo htmlspecialchars($servico['nome_servico']); ?>" <?php echo $_POST['servico'] === $servico['nome_servico'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($servico['nome_servico']); ?> - R$ <?php echo number_format($servico['preco'], 2, ',', '.'); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="valor">Valor (R$) *</label>
                        <input type="number" id="valor" name="valor" required step="0.01" min="0" value="<?php echo htmlspecialchars($_POST['valor']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="status">Status *</label>
                        <select id="status" name="status" required>
                            <option value="Pendente" <?php echo $_POST['status'] === 'Pendente' ? 'selected' : ''; ?>>Pendente</option>
                            <option value="Aprovado" <?php echo $_POST['status'] === 'Aprovado' ? 'selected' : ''; ?>>Aprovado</option>
                            <option value="Recusado" <?php echo $_POST['status'] === 'Recusado' ? 'selected' : ''; ?>>Recusado</option>
                            <option value="Finalizado" <?php echo $_POST['status'] === 'Finalizado' ? 'selected' : ''; ?>>Finalizado</option>
                        </select>
                    </div>
                    <div class="btn-group">
                        <button type="submit" class="btn btn-principal">✅ Salvar Alterações</button>
                        <a href="index.php" class="btn btn-voltar">← Voltar</a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>