<?php
session_start();

// AJUSTE: Adicionado o '../' para voltar à pasta principal e achar o arquivo de login
if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
    exit();
}

require_once('../conexao.php');

if(isset($_GET['id'])) {
    try {
        $stmt = $conn->prepare("DELETE FROM servicos WHERE id = :id");
        $stmt->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
        $stmt->execute();
        
        header('Location: index.php');
        exit();
    } catch (PDOException $e) {
        header('Location: index.php?erro=Erro ao deletar serviço');
        exit();
    }
} else {
    // AJUSTE: Se acessarem a página sem um ID, volta para a listagem
    header('Location: index.php');
    exit();
}
?>