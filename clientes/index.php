<?php

// Iniciar sessão
session_start();

// Importar arquivo de conexão
require_once '../conexao.php';

// Verificar se o admin está logado
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../login.php');
    exit();
}

// Buscar todos os clientes no banco de dados
$sql = 'SELECT id, nome, email, telefone, data_criacao FROM clientes ORDER BY data_criacao DESC';
$resultado = $conexao->query($sql);

// Verificar se a consulta foi executada com sucesso
if (!$resultado) {
    die('Erro ao buscar clientes: ' . $conexao->error);
}

// Contar quantos clientes existem
$total_clientes = $resultado->num_rows;

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes - Leste Design</title>
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
                <li><a href="index.php" class="active">👥 Clientes</a></li>
                <li><a href="../servicos/index.php">🔧 Serviços</a></li>
                <li><a href="../orcamentos/index.php">📋 Orçamentos</a></li>
            </ul>
        </aside>

        <!-- CONTEÚDO PRINCIPAL -->
        <main>
            <!-- Título -->
            <h1>👥 Gerenciar Clientes</h1>
            <p>Aqui você pode visualizar, adicionar, editar e remover clientes.</p>

            <!-- Botão para criar novo cliente -->
            <div class="acao-criar">
                <a href="create.php" class="btn btn-principal">
                    ➕ Novo Cliente
                </a>
            </div>

            <!-- Exibir conteúdo -->
            <?php if ($total_clientes > 0): ?>
                <!-- Há clientes cadastrados - Exibir tabela -->
                <div class="tabela-container">
                    <table>
                        <!-- Cabeçalho da tabela -->
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

                        <!-- Corpo da tabela -->
                        <tbody>
                            <?php while ($cliente = $resultado->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($cliente['id']); ?></td>
                                    <td><?php echo htmlspecialchars($cliente['nome']); ?></td>
                                    <td><?php echo htmlspecialchars($cliente['email']); ?></td>
                                    <td><?php echo htmlspecialchars($cliente['telefone']); ?></td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($cliente['data_criacao'])); ?></td>
                                    <td>
                                        <div class="acoes">
                                            <!-- Botão Editar -->
                                            <a href="update.php?id=<?php echo $cliente['id']; ?>" class="btn btn-editar btn-pequeno">
                                                ✏️ Editar
                                            </a>

                                            <!-- Botão Deletar -->
                                            <a href="delete.php?id=<?php echo $cliente['id']; ?>" class="btn btn-deletar btn-pequeno" onclick="return confirm('Tem certeza que deseja deletar este cliente?');">
                                                🗑️ Deletar
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Total de clientes -->
                <p style="margin-top: 20px; color: #b0b0b0;">
                    <strong>Total de clientes:</strong> <?php echo $total_clientes; ?>
                </p>

            <?php else: ?>
                <!-- Nenhum cliente cadastrado -->
                <div class="lista-vazia">
                    <h3>Nenhum cliente cadastrado</h3>
                    <p>Comece criando o primeiro cliente clicando no botão acima.</p>
                    <a href="create.php" class="btn btn-principal">➕ Criar Primeiro Cliente</a>
                </div>

            <?php endif; ?>
        </main>
    </div>
</body>
</html>
