<?php
/**
 * ========================================
 * ARQUIVO: conexao.php
 * Descrição: Arquivo de conexão com banco de dados MySQL
 * Este arquivo centraliza a conexão para todo o projeto
 * ========================================
 */

// Configurações do Banco de Dados
$host = 'localhost';      // Endereço do servidor
$usuario = 'root';        // Usuário MySQL
$senha = '';              // Senha MySQL (vazio por padrão no XAMPP)
$banco = 'leste_design';  // Nome do banco de dados

// Criar conexão com MySQL
$conexao = new mysqli($host, $usuario, $senha, $banco);

// Verificar se houve erro na conexão
if ($conexao->connect_error) {
    die("Erro ao conectar com o banco de dados: " . $conexao->connect_error);
}

// Definir charset para UTF-8 (caracteres especiais como acentos)
$conexao->set_charset("utf8mb4");

?>
