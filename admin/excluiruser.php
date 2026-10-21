<?php
require_once '../includes/functions.php';

// Pega o id enviado pelo formulário
$id = $_POST['id'];

// Impede a exclusão do administrador principal
if ($id == 1) {
    header("Location: equipe.php");
    exit;
}

// Exclui o funcionário
$sql = "DELETE FROM funcionarios WHERE id = :id";

$stmt = $conexao->prepare($sql);
$stmt->bindParam(":id", $id);
$stmt->execute();

// Volta para a página da equipe
header("Location: equipe.php");
exit;
?>