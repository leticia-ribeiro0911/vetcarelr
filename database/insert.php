<?php
require_once 'conect.php';

$sql = "INSERT INTO alunos (nome, turma, nasc, ativo, email) VALUES (:nome, :turma, :nasc, :ativo, :email)";

try {
$stmt = $conexao->prepare($sql);
$stmt->bindValue(":nome","Kassyla");
$stmt->bindValue(":turma","I1D46A");
$stmt->bindValue(":nascimento","2009-11-08");
$stmt->bindValue(":ativo","true");
$stmt->bindValue(":email","kassylinha@gmail.com");

$stmt->execute();
echo "Aluno inserido com sucesso!";
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>