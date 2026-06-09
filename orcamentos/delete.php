<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

require_once('../conexao.php');

if(isset($_GET['id'])) {
    try {
        $stmt = $conn->prepare("DELETE FROM orcamentos WHERE id = :id");
        $stmt->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
        $stmt->execute();
        header('Location: index.php');
        exit();
    } catch (PDOException $e) {
        header('Location: index.php?erro=Erro ao deletar orçamento');
        exit();
    }
}

?>


