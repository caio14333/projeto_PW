<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

require_once('../conexao.php');

if(isset($_GET['id'])) {
    $stmt = $conn->prepare("DELETE FROM clientes WHERE id = :id");
    $stmt->bindValue(':id', $_GET['id']);
    $stmt->execute();
    header('Location: index.php');
    exit();
}
?>