<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

require_once('../conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome_servico'])) {
    $nome_servico = $_POST['nome_servico'];
    $descricao = $_POST['descricao'] ?? '';
    $preco = isset($_POST['preco']) ? str_replace(',', '.', $_POST['preco']) : null;

    try {
        $stmt = $conn->prepare("INSERT INTO servicos (nome_servico, descricao, preco) VALUES (:nome_servico, :descricao, :preco)");
        $stmt->bindValue(':nome_servico', $nome_servico);
        $stmt->bindValue(':descricao', $descricao);
        $stmt->bindValue(':preco', $preco);
        $stmt->execute();
        header('Location: index.php');
        exit();
    } catch (PDOException $e) {
        $erro = 'Erro ao criar serviço: ' . $e->getMessage();
    }
}

?>
<?php
    $pageTitle = 'Novo Serviço - Eloísa Leste Design';
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
            <h1>➕ Novo Serviço</h1>
            <p>Preencha os dados abaixo para criar um novo serviço.</p>

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
                            placeholder="Ex: Brasileiro"
                            value="<?php echo isset($_POST['nome_servico']) ? htmlspecialchars($_POST['nome_servico']) : ''; ?>"
                        >
                    </div>

                    <div class="form-group">
                        <label for="descricao">Descrição *</label>
                        <textarea 
                            id="descricao" 
                            name="descricao" 
                            required
                            placeholder="Descreva como vai ser o cilios"
                        ><?php echo isset($_POST['descricao']) ? htmlspecialchars($_POST['descricao']) : ''; ?></textarea>
                    </div>

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
<footer>
    <div class="container">
        <p style="font-size:12px;color:#888;">Desenvolvido por: Luis Caio - Infor 2</p>
    </div>
</footer>
</body>
</html>
