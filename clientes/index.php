<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

require_once('../conexao.php');

$sql = 'SELECT id, nome, email, telefone, data_criacao FROM clientes ORDER BY data_criacao DESC';
try {
    $stmt = $conn->query($sql);
    $resultado = $stmt->fetchAll();
} catch (PDOException $e) {
    die('Erro ao buscar clientes: ' . $e->getMessage());
}

$total_clientes = count($resultado);

$pageTitle = 'Clientes - Eloísa Leste Design';
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
            <h1>👥 Gerenciar Clientes</h1>
            <p>clientes a espera de eloisa lash design.😊</p>
            <div class="acao-criar">
                <a href="create.php" class="btn btn-principal">➕ Novo Cliente</a>
            </div>

            <?php if ($total_clientes > 0): ?>
                <div class="tabela-container">
                    <table>
                        <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Telefone</th>
                                <th>Data de Cadastro</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($resultado as $cliente): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($cliente['id']); ?></td>
                                    <td><?php echo htmlspecialchars($cliente['nome']); ?></td>
                                    <td><?php echo htmlspecialchars($cliente['email']); ?></td>
                                    <td><?php echo htmlspecialchars($cliente['telefone']); ?></td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($cliente['data_criacao'])); ?></td>
                                    <td>
                                        <div class="acoes">
                                            <a href="update.php?id=<?php echo $cliente['id']; ?>" class="btn btn-editar btn-pequeno">✏️ Editar</a>
                                            <a href="delete.php?id=<?php echo $cliente['id']; ?>" class="btn btn-deletar btn-pequeno" onclick="return confirm('Tem certeza que deseja deletar este cliente?');">🗑️ Deletar</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <p style="margin-top: 20px; color: #b0b0b0;"> <strong>Total de clientes:</strong> <?php echo $total_clientes; ?></p>

            <?php else: ?>
                <div class="lista-vazia">
                    <h3>Nenhum cliente cadastrado</h3>
                    <p>Comece criando o primeiro cliente clicando no botão acima.</p>
                    <a href="create.php" class="btn btn-principal">➕ Criar Primeiro Cliente</a>
                </div>

            <?php endif; ?>
        </main>
    </div>
<footer>
    <div class="container">
        <p style="font-size:12px;color:#888;">Desenvolvido por: Luis Caio - Infor 2</p>
    </div>
</footer>
</body>
</html>
