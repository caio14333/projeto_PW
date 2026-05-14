<?php
include_once("../conexao.php");
$id = $_GET['id'];
try {
    $sql = "DELETE FROM clientes WHERE id = :id";
    $stmt = $conect->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    echo "Cliente deletado com sucesso!";
} catch (PDOException $e) {
    echo "Erro ao deletar cliente: " . $e->getMessage();
}
?>