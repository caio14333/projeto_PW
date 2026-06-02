<?php

session_start();

// Importar arquivo de conexão
require_once '../conexao.php';

// Verificar se o admin está logado
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../login.php');
    exit();
}

// Buscar todos os orçamentos no banco de dados
$sql = 'SELECT id, nome_cliente, servico, valor, status, data_criacao FROM orcamentos ORDER BY data_criacao DESC';
$resultado = $conexao->query($sql);

// Verificar se a consulta foi executada com sucesso
if (!$resultado) {
    die('Erro ao buscar orçamentos: ' . $conexao->error);
}

// Contar quantos orçamentos existem
$total_orcamentos = $resultado->num_rows;

// Função auxiliar para colorir status
function obter_classe_status($status) {
    switch ($status) {
        case 'Aprovado':
            return 'alerta-sucesso';
        case 'Recusado':
            return 'alerta-erro';
        case 'Finalizado':
            return 'alerta-info';
        default:
            return 'alerta-aviso';
    }
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orçamentos - Leste Design</title>
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
                <li><a href="../servicos/index.php">🔧 Serviços</a></li>
                <li><a href="index.php" class="active">📋 Orçamentos</a></li>
            </ul>
        </aside>

        <!-- CONTEÚDO PRINCIPAL -->
        <main>
            <!-- Título -->
            <h1>📋 Gerenciar Orçamentos</h1>
            <p>Aqui você pode visualizar, adicionar, editar e remover orçamentos.</p>

            <!-- Botão para criar novo orçamento -->
            <div class="acao-criar">
                <a href="create.php" class="btn btn-principal">
                    ➕ Novo Orçamento
                </a>
            </div>

            <!-- Exibir conteúdo -->
            <?php if ($total_orcamentos > 0): ?>
                <!-- Há orçamentos cadastrados - Exibir tabela -->
                <div class="tabela-container">
                    <table>
                        <!-- Cabeçalho da tabela -->
                        <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Cliente</th>
                                <th>Serviço</th>
                                <th>Valor</th>
                                <th>Status</th>
                                <th>Data</th>
                                <th>Ações</th>
                            </tr>
                        </thead>

                        <!-- Corpo da tabela -->
                        <tbody>
                            <?php while ($orcamento = $resultado->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($orcamento['id']); ?></td>
                                    <td><?php echo htmlspecialchars($orcamento['nome_cliente']); ?></td>
                                    <td><?php echo htmlspecialchars($orcamento['servico']); ?></td>
                                    <td>R$ <?php echo number_format($orcamento['valor'], 2, ',', '.'); ?></td>
                                    <td>
                                        <span class="alerta <?php echo obter_classe_status($orcamento['status']); ?>" style="padding: 5px 10px; border-radius: 4px; font-size: 12px;">
                                            <?php echo htmlspecialchars($orcamento['status']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($orcamento['data_criacao'])); ?></td>
                                    <td>
                                        <div class="acoes">
                                            <!-- Botão Editar -->
                                            <a href="update.php?id=<?php echo $orcamento['id']; ?>" class="btn btn-editar btn-pequeno">
                                                ✏️ Editar
                                            </a>

                                            <!-- Botão Deletar -->
                                            <a href="delete.php?id=<?php echo $orcamento['id']; ?>" class="btn btn-deletar btn-pequeno" onclick="return confirm('Tem certeza que deseja deletar este orçamento?');">
                                                🗑️ Deletar
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Total de orçamentos -->
                <p style="margin-top: 20px; color: #b0b0b0;">
                    <strong>Total de orçamentos:</strong> <?php echo $total_orcamentos; ?>
                </p>

            <?php else: ?>
                <!-- Nenhum orçamento cadastrado -->
                <div class="lista-vazia">
                    <h3>Nenhum orçamento cadastrado</h3>
                    <p>Comece criando o primeiro orçamento clicando no botão acima.</p>
                    <a href="create.php" class="btn btn-principal">➕ Criar Primeiro Orçamento</a>
                </div>

            <?php endif; ?>
        </main>
    </div>
</body>
</html>
