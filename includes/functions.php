<?php 

require_once __DIR__ . '/../database/conect.php';

function cadastrar($conexao, $nome, $cpf, $telefone, $senha){
$sql = "INSERT INTO tutores (nome, cpf, telefone, senha) VALUES (:nome, :cpf, :telefone, :senha)";

try {
$stmt = $conexao->prepare($sql);
$stmt->bindParam(":nome", $nome);
$stmt->bindParam(":cpf", $cpf);
$stmt->bindParam(":telefone", $telefone);
$stmt->bindParam(":senha", $senha);

$stmt->execute();
echo "Tutor cadastrado com sucesso!";
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
    }
}

function apagar($conexao, $id){
    $sql = "DELETE FROM alunos WHERE id = :id";
        try {
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            echo "Usuário $id removido com sucesso!";
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
}

function relatorio($conexao){
    $sql = "SELECT * FROM alunos ORDER BY id";

try {
$stmt = $conexao->prepare($sql);
$stmt->execute();

$alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($alunos as $aluno){
    echo "ID: {$aluno['id']}<br>";
    echo "nome: {$aluno['nome']}<br>";
    echo "turma: {$aluno['turma']}<br>";
    echo "nasc: {$aluno['nascimento']}<br>";
    echo "email: {$aluno['email']}<br>";
    echo "ativo: {$aluno['ativo']}<br>";
    echo"<hr>";
}
} catch (PDOException $e) {
    echo "Erro:" . $e->getMessage();
}
}

function atualizar($conexao, $id, $nome, $turma, $nasc, $ativo, $email){
$sql = "UPDATE alunos SET nome = :nome , turma = :turma , nascimento = :nasc , ativo = :ativo , email = :email WHERE id = :id";

try {
$stmt = $conexao->prepare($sql);
$stmt->bindParam(":id", $id);
$stmt->bindParam(":nome", $nome);
$stmt->bindParam(":turma", $turma);
$stmt->bindParam(":nasc", $nasc);
$stmt->bindParam(":ativo", $ativo);
$stmt->bindParam(":email", $email);

$stmt->execute();
echo "Aluno atualizado com sucesso!";
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
    }
}

function consultar($conexao, $id){
    $sql = "SELECT nome, turma, email, nascimento, ativo FROM alunos WHERE id = :id";

try {
$stmt = $conexao->prepare($sql);
$stmt->bindParam(":id", $id);
$stmt->execute();

$aluno = $stmt->fetch(PDO::FETCH_ASSOC);
echo "Aluno: {$aluno['nome']} <br>";
echo "Turma: {$aluno['turma']} <br>";
echo "Email: {$aluno['email']} <br>";
echo "Nascimento: {$aluno['nascimento']} <br>";
echo "Ativo: {$aluno['ativo']} <br>";

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
}

//Funções para login:
function cadastratutor($conexao, $nome, $cpf, $telefone, $senha){
$sql = "INSERT INTO tutores (nome, cpf, telefone, senha) VALUES (:nome, :cpf, :telefone, :senha)";

try {
$stmt = $conexao->prepare($sql);
$stmt->bindParam(":nome", $nome);
$stmt->bindParam(":cpf", $cpf);
$stmt->bindParam(":telefone", $telefone);
$stmt->bindParam(":senha", $senha);

$stmt->execute();
echo "Tutor cadastrado com sucesso!";
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
    }
}

function consultatutor($conexao, $cpf){
    $sql = "SELECT id, nome, cpf, telefone, senha FROM tutores WHERE cpf = :cpf";

try {
$stmt = $conexao->prepare($sql);
$stmt->bindParam(":cpf", $cpf);
$stmt->execute();

$tutor = $stmt->fetch(PDO::FETCH_ASSOC);
return $tutor;

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
}
?>