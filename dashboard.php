<?php
/**
 * ========================================
 * ARQUIVO: dashboard.php
 * Descrição: Página inicial do sistema (Dashboard)
 * Exibe estatísticas dos CRUDs
 * ========================================
 */

// Iniciar sessão
session_start();

// Importar arquivo de conexão
require_once 'conexao.php';

// Verificar se o admin está logado
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

// Contar clientes
$sql_clientes = 'SELECT COUNT(*) as total FROM clientes';
$resultado_clientes = $conexao->query($sql_clientes);
$dados_clientes = $resultado_clientes->fetch_assoc();
$total_clientes = $dados_clientes['total'];

// Contar serviços
$sql_servicos = 'SELECT COUNT(*) as total FROM servicos';
$resultado_servicos = $conexao->query($sql_servicos);
$dados_servicos = $resultado_servicos->fetch_assoc();
$total_servicos = $dados_servicos['total'];

// Contar orçamentos
$sql_orcamentos = 'SELECT COUNT(*) as total FROM orcamentos';
$resultado_orcamentos = $conexao->query($sql_orcamentos);
$dados_orcamentos = $resultado_orcamentos->fetch_assoc();
$total_orcamentos = $dados_orcamentos['total'];

// Calcular valor total dos orçamentos
$sql_valor = 'SELECT SUM(valor) as total FROM orcamentos';
$resultado_valor = $conexao->query($sql_valor);
$dados_valor = $resultado_valor->fetch_assoc();
$valor_total = $dados_valor['total'] ?? 0;

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Leste Design</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- HEADER -->
    <header>
        <div class="container">
            <a href="dashboard.php" class="logo">◆ Leste Design</a>
            
            <div class="user-info">
                <span>Bem-vindo, <strong><?php echo htmlspecialchars($_SESSION['admin_nome']); ?></strong></span>
                <a href="logout.php" class="logout-btn">Sair</a>
            </div>
        </div>
    </header>

    <!-- LAYOUT PRINCIPAL -->
    <div class="layout-dashboard">
        <!-- SIDEBAR/MENU LATERAL -->
        <aside class="sidebar">
            <ul>
                <li><a href="dashboard.php" class="active">📊 Dashboard</a></li>
                <li><a href="clientes/index.php">👥 Clientes</a></li>
                <li><a href="servicos/index.php">🔧 Serviços</a></li>
                <li><a href="orcamentos/index.php">📋 Orçamentos</a></li>
            </ul>
        </aside>

        <!-- CONTEÚDO PRINCIPAL -->
        <main>
            <!-- Título -->
            <div class="dashboard-titulo">
                <h1>Dashboard</h1>
                <p>Bem-vindo ao sistema Leste Design. Aqui você pode gerenciar clientes, serviços e orçamentos.</p>
            </div>

            <!-- Cards de Estatísticas -->
            <div class="dashboard-stats">
                <!-- Card: Total de Clientes -->
                <div class="stat-card">
                    <div class="stat-numero"><?php echo $total_clientes; ?></div>
                    <div class="stat-label">Clientes Cadastrados</div>
                </div>

                <!-- Card: Total de Serviços -->
                <div class="stat-card">
                    <div class="stat-numero"><?php echo $total_servicos; ?></div>
                    <div class="stat-label">Serviços Disponíveis</div>
                </div>

                <!-- Card: Total de Orçamentos -->
                <div class="stat-card">
                    <div class="stat-numero"><?php echo $total_orcamentos; ?></div>
                    <div class="stat-label">Orçamentos</div>
                </div>

                <!-- Card: Valor Total -->
                <div class="stat-card">
                    <div class="stat-numero">R$ <?php echo number_format($valor_total, 2, ',', '.'); ?></div>
                    <div class="stat-label">Valor Total</div>
                </div>
            </div>

            <!-- Seção de Atalhos -->
            <h2>Atalhos Rápidos</h2>

            <div class="grid-cards">
                <!-- Card: Clientes -->
                <div class="card">
                    <div class="card-titulo">👥 Clientes</div>
                    <div class="card-conteudo">
                        <p>Gerencie os clientes da sua empresa. Adicione, edite ou remova clientes.</p>
                        <br>
                        <a href="clientes/index.php" class="btn btn-principal">Acessar</a>
                    </div>
                </div>

                <!-- Card: Serviços -->
                <div class="card">
                    <div class="card-titulo">🔧 Serviços</div>
                    <div class="card-conteudo">
                        <p>Cadastre e administre todos os serviços oferecidos pela Leste Design.</p>
                        <br>
                        <a href="servicos/index.php" class="btn btn-principal">Acessar</a>
                    </div>
                </div>

                <!-- Card: Orçamentos -->
                <div class="card">
                    <div class="card-titulo">📋 Orçamentos</div>
                    <div class="card-conteudo">
                        <p>Crie e acompanhe os orçamentos enviados para clientes.</p>
                        <br>
                        <a href="orcamentos/index.php" class="btn btn-principal">Acessar</a>
                    </div>
                </div>
            </div>

            <!-- Informações do Sistema -->
            <div style="margin-top: 60px; padding-top: 20px; border-top: 1px solid #444;">
                <h3>Sobre o Sistema</h3>
                <p>Sistema de Gerenciamento Leste Design v1.0</p>
                <p style="font-size: 12px; color: #888;">
                    Desenvolvido com PHP puro, MySQL, HTML5 e CSS. 
                    Projeto técnico escolar para fins educacionais.
                </p>
            </div>
        </main>
    </div>
</body>
</html>
