<?php
/**
 * ========================================
 * ARQUIVO: logout.php
 * Descrição: Destruir sessão e redirecionar para login
 * ========================================
 */

// Iniciar sessão
session_start();

// Destruir todas as variáveis de sessão
session_destroy();

// Redirecionar para a página de login
header('Location: login.php');
exit();

?>
