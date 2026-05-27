<?php
/**
 * ========================================
 * ARQUIVO: orcamentos/delete.php
 * Descrição: Deletar orçamento existente
 * CRUD - DELETE (Deleção)
 * ========================================
 */

// Iniciar sessão
session_start();

// Importar arquivo de conexão
require_once '../conexao.php';

// Verificar se o admin está logado
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../login.php');
    exit();
}

// Verificar se ID foi passado via GET
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php');
    exit();
}

// Receber e validar ID
$id = intval($_GET['id']);

// Preparar consulta para deletar
$sql = 'DELETE FROM orcamentos WHERE id = ?';
$stmt = $conexao->prepare($sql);

if ($stmt) {
    // Vincular parâmetro
    $stmt->bind_param('i', $id);

    // Executar deleção
    if ($stmt->execute()) {
        // Sucesso! Redirecionar para a lista
        header('Location: index.php?sucesso=Orçamento deletado com sucesso!');
        exit();
    } else {
        // Erro ao deletar - redirecionar com mensagem de erro
        header('Location: index.php?erro=Erro ao deletar orçamento');
        exit();
    }

    // Fechar statement
    $stmt->close();
} else {
    // Erro ao preparar consulta
    header('Location: index.php?erro=Erro ao processar deleção');
    exit();
}

?>
