<?php

$host = 'localhost';      
$usuario = 'root';        
$senha = '';              
$banco = 'lash_design';  

$conexao = new mysqli($host, $usuario, $senha, $banco);

if ($conexao->connect_error) {
    die("Erro ao conectar com o banco de dados: " . $conexao->connect_error);
}

$conexao->set_charset("utf8mb4");

?>


