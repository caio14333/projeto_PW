<?php
/**
 * ========================================
 * ARQUIVO: index.php
 * Descrição: Página inicial do projeto
 * Redireciona para dashboard se logado, senão para login
 * ========================================
 */

// Iniciar sessão
session_start();

// Se o admin está logado, ir para dashboard
if (isset($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
} else {
    // Se não está logado, ir para login
    header('Location: login.php');
}

exit();

?>
