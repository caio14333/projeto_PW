<?php
/**
 * ========================================
 * ARQUIVO: servicos/index.php
 * Descrição: Listar todos os serviços cadastrados
 * CRUD - READ (Leitura)
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

// Buscar todos os serviços no banco de dados
$sql = 'SELECT id, nome_servico, descricao, preco, data_criacao FROM servicos ORDER BY data_criacao DESC';
$resultado = $conexao->query($sql);

// Verificar se a consulta foi executada com sucesso
if (!$resultado) {
    die('Erro ao buscar serviços: ' . $conexao->error);
}

// Contar quantos serviços existem
$total_servicos = $resultado->num_rows;

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serviços - Leste Design</title>
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
            <h1>🔧 Gerenciar Serviços</h1>
            <p>Aqui você pode visualizar, adicionar, editar e remover serviços.</p>

            <!-- Botão para criar novo serviço -->
            <div class="acao-criar">
                <a href="create.php" class="btn btn-principal">
                    ➕ Novo Serviço
                </a>
            </div>

            <!-- Exibir conteúdo -->
            <?php if ($total_servicos > 0): ?>
                <!-- Há serviços cadastrados - Exibir tabela -->
                <div class="tabela-container">
                    <table>
                        <!-- Cabeçalho da tabela -->
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

                        <!-- Corpo da tabela -->
                        <tbody>
                            <?php while ($servico = $resultado->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($servico['id']); ?></td>
                                    <td><?php echo htmlspecialchars($servico['nome_servico']); ?></td>
                                    <td>
                                        <!-- Truncar descrição se muito comprida -->
                                        <?php 
                                            $descricao = htmlspecialchars($servico['descricao']);
                                            echo strlen($descricao) > 50 ? substr($descricao, 0, 50) . '...' : $descricao;
                                        ?>
                                    </td>
                                    <td>R$ <?php echo number_format($servico['preco'], 2, ',', '.'); ?></td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($servico['data_criacao'])); ?></td>
                                    <td>
                                        <div class="acoes">
                                            <!-- Botão Editar -->
                                            <a href="update.php?id=<?php echo $servico['id']; ?>" class="btn btn-editar btn-pequeno">
                                                ✏️ Editar
                                            </a>

                                            <!-- Botão Deletar -->
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

                <!-- Total de serviços -->
                <p style="margin-top: 20px; color: #b0b0b0;">
                    <strong>Total de serviços:</strong> <?php echo $total_servicos; ?>
                </p>

            <?php else: ?>
                <!-- Nenhum serviço cadastrado -->
                <div class="lista-vazia">
                    <h3>Nenhum serviço cadastrado</h3>
                    <p>Comece criando o primeiro serviço clicando no botão acima.</p>
                    <a href="create.php" class="btn btn-principal">➕ Criar Primeiro Serviço</a>
                </div>

            <?php endif; ?>
        </main>
    </div>
</body>
</html>
