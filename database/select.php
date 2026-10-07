<?php
require_once 'conect.php';

$sql = "SELECT * FROM alunos";


try {
$stmt = $conexao->prepare($sql);
$stmt->execute();

$alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($alunos as $aluno){
    echo "ID: {$aluno['id']}<br>";
    echo "nome: {$aluno['nome']}<br>";
    echo "turma: {$aluno['turma']}<br>";
    echo "email: {$aluno['email']}<br>";
    echo "ativo: {$aluno['ativo']}<br>";
    echo"<hr>";
}
} catch (PDOException $e) {
    echo "Erro:" . $e->getMessage();
}
?>