<?php
require_once 'conect.php';

// exemplo //
$n_nome = 'Roberto';
$id = 4;

$sql = "UPDATE alunos SET nome = :nome WHERE id = :id";

$stmt = $conexao->prepare($sql);
$stmt->bindParam(":nome", $n_nome);
$stmt->bindParam(":id", $id);
$stmt->execute();

?>