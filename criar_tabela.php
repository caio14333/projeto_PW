<?php
include 'conexao.php';

$sql = "CREATE TABLE IF NOT EXISTS clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    telefone VARCHAR(20),
    instagram VARCHAR(100),
    observacoes TEXT
)";

try {
    $conect->exec($sql);
    echo "Tabela 'clientes' criada com sucesso!";
} catch (PDOException $e) {
    echo "Erro ao criar tabela: " . $e->getMessage();
}
?>
