<?php


require_once '../conexao.php';

$sql = 'SELECT id, nome_servico, descricao, preco, data_criacao FROM servicos ORDER BY data_criacao DESC';
$resultado = $conexao->query($sql);


if (!$resultado) {
    die('Erro ao buscar serviços: ' . $conexao->error);
}

$total_servicos = $resultado->num_rows;

?>
<?php
    $pageTitle = 'Serviços - Eloísa Leste Design';
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
            <h1>🔧 Gerenciar Serviços</h1>
            <p>Aqui você pode visualizar, adicionar, editar e remover serviços.</p>

            <div class="acao-criar">
                <a href="create.php" class="btn btn-principal">
                    ➕ Novo Serviço
                </a>
            </div>
            <?php if ($total_servicos > 0): ?>
                <div class="tabela-container">
                    <table>
                        <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Nome do Serviço</th>
                                <th>Descrição</th>
                                <th>Preço</th>
                                <th>Data de Cadastro</th>
                                <th>Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php while ($servico = $resultado->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($servico['id']); ?></td>
                                    <td><?php echo htmlspecialchars($servico['nome_servico']); ?></td>
                                    <td>
                                        <?php 
                                            $descricao = htmlspecialchars($servico['descricao']);
                                            echo strlen($descricao) > 50 ? substr($descricao, 0, 50) . '...' : $descricao;
                                        ?>
                                    </td>
                                    <td>R$ <?php echo number_format($servico['preco'], 2, ',', '.'); ?></td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($servico['data_criacao'])); ?></td>
                                    <td>
                                        <div class="acoes">
                                            <a href="update.php?id=<?php echo $servico['id']; ?>" class="btn btn-editar btn-pequeno">
                                                ✏️ Editar
                                            </a>

                                            <a href="delete.php?id=<?php echo $servico['id']; ?>" class="btn btn-deletar btn-pequeno" onclick="return confirm('Tem certeza que deseja deletar este serviço?');">
                                                🗑️ Deletar
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <p style="margin-top: 20px; color: #b0b0b0;">
                    <strong>Total de serviços:</strong> <?php echo $total_servicos; ?>
                </p>

            <?php else: ?>
                <div class="lista-vazia">
                    <h3>Nenhum serviço cadastrado</h3>
                    <p>Comece criando o primeiro serviço clicando no botão acima.</p>
                    <a href="create.php" class="btn btn-principal">➕ Criar Primeiro Serviço</a>
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
