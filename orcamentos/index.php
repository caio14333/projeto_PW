<?php

require_once '../conexao.php';

$sql = 'SELECT id, nome_cliente, servico, valor, status, data_criacao FROM orcamentos ORDER BY data_criacao DESC';
$resultado = $conexao->query($sql);

if (!$resultado) {
    die('Erro ao buscar orçamentos: ' . $conexao->error);
}

$total_orcamentos = $resultado->num_rows;

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
            
            <h1>📋 Gerenciar Orçamentos</h1>
            <p>Aqui você pode visualizar, adicionar, editar e remover orçamentos.</p>

            
            <div class="acao-criar">
                <a href="create.php" class="btn btn-principal">
                    ➕ Novo Orçamento
                </a>
            </div>

            
            <?php if ($total_orcamentos > 0): ?>
                
                <div class="tabela-container">
                    <table>
                        
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
                                            
                                            <a href="update.php?id=<?php echo $orcamento['id']; ?>" class="btn btn-editar btn-pequeno">
                                                ✏️ Editar
                                            </a>

                                            
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

                
                <p style="margin-top: 20px; color: #b0b0b0;">
                    <strong>Total de orçamentos:</strong> <?php echo $total_orcamentos; ?>
                </p>

            <?php else: ?>
                
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


