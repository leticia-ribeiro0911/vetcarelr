<?php
require_once 'conect.php';

$id = 7;

$sql = "SELECT * FROM alunos WHERE id = :id";

try {
$stmt = $conexao->prepare($sql);
$stmt->bindParam(":id", $id);
$stmt->execute();

$aluno = $stmt->fetch(PDO::FETCH_ASSOC);
echo "Aluno: {$aluno['nome']} <br>";
echo "Turma: {$aluno['turma']} <br>";
echo "Nascimento: {$aluno['nascimento']} <br>";
echo "Ativo: {$aluno['ativo']} <br>";

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>