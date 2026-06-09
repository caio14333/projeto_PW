<?php
session_start();

// AJUSTE: Corrigido o caminho para voltar à raiz do projeto
if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
    exit();
}

require_once('../conexao.php');

// Verifica se o ID foi passado na URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$id = intval($_GET['id']);

// Busca os dados atuais para preencher o formulário
try {
    $stmt = $conn->prepare('SELECT id, nome_servico, descricao, preco FROM servicos WHERE id = :id');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $servico = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    header('Location: index.php');
    exit();
}

if (!$servico) {
    header('Location: index.php');
    exit();
}

$erro = '';
// Processa o formulário de atualização
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome_servico'])) {
    $nome_servico = trim($_POST['nome_servico']);
    $descricao = trim($_POST['descricao'] ?? '');
    $preco = isset($_POST['preco']) ? str_replace(',', '.', $_POST['preco']) : null;

    try {
        $stmt = $conn->prepare('UPDATE servicos SET nome_servico = :nome_servico, descricao = :descricao, preco = :preco WHERE id = :id');
        $stmt->bindValue(':nome_servico', $nome_servico);
        $stmt->bindValue(':descricao', $descricao);
        $stmt->bindValue(':preco', $preco);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        header('Location: index.php');
        exit();
    } catch (PDOException $e) {
        $erro = 'Erro ao atualizar serviço: ' . $e->getMessage();
    }
}

// Preenche o formulário se for o primeiro acesso (GET)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_POST['nome_servico'] = $servico['nome_servico'];
    $_POST['descricao'] = $servico['descricao'];
    $_POST['preco'] = $servico['preco'];
}

?>
<?php
    $pageTitle = 'Editar Serviço - Eloísa Leste Design';
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
                <li><a href="../clientes/index.php">👥 Clientes</a></li>
                <li><a href="index.php" class="active">🔧 Serviços</a></li>
                <li><a href="../orcamentos/index.php">📋 Orçamentos</a></li>
            </ul>
        </aside>

        <main>
            <h1>✏️ Editar Serviço</h1>
            <p>Atualize os dados do serviço abaixo.</p>

            <?php if (!empty($erro)): ?>
                <div class="alerta alerta-erro">
                    <?php echo htmlspecialchars($erro); ?>
                </div>
            <?php endif; ?>
            <div class="card">
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="nome_servico">Nome do Serviço *</label>
                        <input 
                            type="text" 
                            id="nome_servico" 
                            name="nome_servico" 
                            required
                            value="<?php echo htmlspecialchars($_POST['nome_servico']); ?>"
                        >
                    </div>
                    <div class="form-group">
                        <label for="descricao">Descrição *</label>
                        <textarea 
                            id="descricao" 
                            name="descricao" 
                            required
                        ><?php echo htmlspecialchars($_POST['descricao']); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="preco">Preço (R$) *</label>
                        <input 
                            type="number" 
                            id="preco" 
                            name="preco" 
                            required
                            step="0.01"
                            min="0"
                            value="<?php echo htmlspecialchars($_POST['preco']); ?>"
                        >
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
<footer>
    <div class="container">
        <p style="font-size:12px;color:#888;">Desenvolvido por: Luis Caio - Infor 2</p>
    </div>
</footer>
</body>
</html>