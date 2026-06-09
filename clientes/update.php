<?php
require_once '../conexao.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$id = intval($_GET['id']);

$sql = 'SELECT id, nome, email, telefone FROM clientes WHERE id = ?';
$stmt = $conexao->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    header('Location: index.php');
    exit();
}

$cliente = $resultado->fetch_assoc();
$stmt->close();

$erro = '';
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
        $sql = 'UPDATE clientes SET nome = ?, email = ?, telefone = ? WHERE id = ?';
        $stmt = $conexao->prepare($sql);

        if ($stmt) {
            $stmt->bind_param('sssi', $nome, $email, $telefone, $id);

            if ($stmt->execute()) {
                header('Location: index.php?sucesso=Cliente atualizado com sucesso!');
                exit();
            } else {
                $erro = 'Erro ao atualizar cliente: ' . $stmt->error;
            }

            $stmt->close();
        } else {
            $erro = 'Erro ao preparar consulta: ' . $conexao->error;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_POST['nome'] = $cliente['nome'];
    $_POST['email'] = $cliente['email'];
    $_POST['telefone'] = $cliente['telefone'];
}

?>
<?php
    $pageTitle = 'Editar Cliente - Eloísa Leste Design';
    $basePath = '..';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<<<<<<< HEAD
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <link rel="stylesheet" href="<?php echo $basePath; ?>/css/style.css">
</head>
<body>
<header>
    <div class="container">
        <a href="<?php echo $basePath; ?>/dashboard.php" class="logo"><img src="<?php echo $basePath; ?>/logo.svg" alt="Eloisa lash Design" class="logo-img"></a>
        <div class="user-info">
            <span>Bem-vindo, <strong>Administrador</strong></span>
=======
    <title>Editar Cliente - Eloisa Lash Design</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    
    <header>
        <div class="container">
            <a href="../dashboard.php" class="logo">◆ Eloisa Lash Design</a>
            
            <div class="user-info">
                <span>Bem-vindo, <strong>Administrador</strong></span>
            </div>
>>>>>>> 767c5212c80f2d7ca2965d7441a2e645527a06c4
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
            <h1>✏️ Editar Cliente</h1>
            <p>Atualize os dados do cliente abaixo.</p>

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
                            value="<?php echo htmlspecialchars($_POST['nome']); ?>"
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
                            value="<?php echo htmlspecialchars($_POST['email']); ?>"
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
                            value="<?php echo htmlspecialchars($_POST['telefone']); ?>"
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
    </div>
<footer>
    <div class="container">
        <p style="font-size:12px;color:#888;">Desenvolvido por: Luis Caio - Infor 2</p>
    </div>
</footer>
</body>
</html>


