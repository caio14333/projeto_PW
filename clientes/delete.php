<?php

require_once '../conexao.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$id = intval($_GET['id']);

$sql = 'DELETE FROM clientes WHERE id = ?';
$stmt = $conexao->prepare($sql);

if ($stmt) {
    
    $stmt->bind_param('i', $id);

    
    if ($stmt->execute()) {
        
        header('Location: index.php?sucesso=Cliente deletado com sucesso!');
        exit();
    } else {
        
        header('Location: index.php?erro=Erro ao deletar cliente');
        exit();
    }

    
    $stmt->close();
} else {
    
    header('Location: index.php?erro=Erro ao processar deleção');
    exit();
}

?>


