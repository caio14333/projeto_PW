<?php



$host = 'localhost';      
$usuario = 'root';        
$senha = '';              
$banco = 'lash_design';  

// Criar conexão com MySQL
$conexao = new mysqli($host, $usuario, $senha, $banco);

// Verificar se houve erro na conexão
if ($conexao->connect_error) {
    die("Erro ao conectar com o banco de dados: " . $conexao->connect_error);
}

// Definir charset para UTF-8 (caracteres especiais como acentos)
$conexao->set_charset("utf8mb4");

?>
