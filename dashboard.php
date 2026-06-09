<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

require_once 'conexao.php';

$sql_clientes = 'SELECT COUNT(*) as total FROM clientes';
try {
    $total_clientes = (int) $conn->query($sql_clientes)->fetchColumn();
} catch (PDOException $e) {
    $total_clientes = 0;
}

$sql_servicos = 'SELECT COUNT(*) as total FROM servicos';
try {
    $total_servicos = (int) $conn->query($sql_servicos)->fetchColumn();
} catch (PDOException $e) {
    $total_servicos = 0;
}

$sql_orcamentos = 'SELECT COUNT(*) as total FROM orcamentos';
try {
    $total_orcamentos = (int) $conn->query($sql_orcamentos)->fetchColumn();
} catch (PDOException $e) {
    $total_orcamentos = 0;
}

$sql_valor = 'SELECT SUM(valor) as total FROM orcamentos';
try {
    $valor_total = $conn->query($sql_valor)->fetchColumn();
    $valor_total = $valor_total !== null ? $valor_total : 0;
} catch (PDOException $e) {
    $valor_total = 0;
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Eloisa lash Design</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
  
    
    <header>
        <div class="container">
            <a href="dashboard.php" class="logo"><img src="logo.svg" alt="Eloisa lash Design" class="logo-img"></a>
            
            <div class="user-info">
                <span>Bem-vindo, <strong>Administrador</strong></span>
            </div>
        </div>
    </header>

    
    <div class="layout-dashboard">
        
        <aside class="sidebar">
            <ul>
                <li><a href="dashboard.php" class="active">📊 Dashboard</a></li>
                <li><a href="clientes/index.php">👥 Clientes</a></li>
                <li><a href="servicos/index.php">🔧 Serviços</a></li>
                <li><a href="orcamentos/index.php">📋 Orçamentos</a></li>
            </ul>
        </aside>

        
        <main>
            
            <div class="dashboard-titulo">
                <h1>Dashboard</h1>
                <p>Bem-vindo ao sistema Eloisa lash Design. Aqui você pode gerenciar clientes, serviços e orçamentos.</p>
            </div>

            
            <div class="dashboard-stats">
                
                <div class="stat-card">
                    <div class="stat-numero"><?php echo $total_clientes; ?></div>
                    <div class="stat-label">Clientes Cadastrados</div>
                </div>

                
                <div class="stat-card">
                    <div class="stat-numero"><?php echo $total_servicos; ?></div>
                    <div class="stat-label">Serviços Disponíveis</div>
                </div>

                
                <div class="stat-card">
                    <div class="stat-numero"><?php echo $total_orcamentos; ?></div>
                    <div class="stat-label">Orçamentos</div>
                </div>

                
                <div class="stat-card">
                    <div class="stat-numero">R$ <?php echo number_format($valor_total, 2, ',', '.'); ?></div>
                    <div class="stat-label">Valor Total</div>
                </div>
            </div>

            
            <h2>Atalhos Rápidos</h2>

            <div class="grid-cards">
                
                <div class="card">
                    <div class="card-titulo">👥 Clientes</div>
                    <div class="card-conteudo">
                        <p>Clientes a serem gerenciados.</p>
                        <br>
                        <a href="clientes/index.php" class="btn btn-principal">Acessar</a>
                    </div>
                </div>

                
                <div class="card">
                    <div class="card-titulo">🔧 Serviços</div>
                    <div class="card-conteudo">
                        <p>serviços ofercidos pela Eloisa lash Design.</p>
                        <br>
                        <a href="servicos/index.php" class="btn btn-principal">Acessar</a>
                    </div>
                </div>

                
                <div class="card">
                    <div class="card-titulo">📋 Orçamentos</div>
                    <div class="card-conteudo">
                        <p>Crie e acompanhe os orçamentos enviados para clientes.</p>
                        <br>
                        <a href="orcamentos/index.php" class="btn btn-principal">Acessar</a>
                    </div>
                </div>
            </div>

            
            <div style="margin-top: 60px; padding-top: 20px; border-top: 1px solid #444;">
                <h3>Sobre o Sistema</h3>
                <p>Sistema de Gerenciamento Eloisa lash Design </p>
                <p style="font-size: 12px; color: #888;">
                    Desenvolvido por: Luis Caio - Infor 2
                </p>
            </div>
        </main>
    </div>
</body>
</html>


