<?php
require_once '../includes/functions.php';

// Pega o id do funcionário pela URL
$id = $_GET['id'];

if ($id == 1) {
    header("Location: equipe.php");
    exit;
}

// Busca os dados do funcionário
$sql = "SELECT * FROM funcionarios WHERE id = :id";

$stmt = $conexao->prepare($sql);
$stmt->bindParam(":id", $id);
$stmt->execute();

$funcionario = $stmt->fetch(PDO::FETCH_ASSOC);

// Verifica se o botão foi clicado
if (isset($_POST['atualizar'])) {

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];

   // Chama a função que edita o funcionário
if (editarfunc($conexao, $id, $nome, $email, $telefone)) {
    header("Location: equipe.php");
    exit;
} else {
    echo "Não foi possível editar o funcionário.";
}
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VetCare LR - Editar funcionário</title>

    <link rel="stylesheet" href="../css/novouser.css">
</head>

<body>

    <?php require_once '../includes/admheader.php'; ?>

    <main>

        <h1>Editar funcionário</h1>

        <form method="POST">

            <p>
                <label>Nome:</label>
                <input type="text" name="nome"
                    value="<?php echo $funcionario['nome']; ?>" required>
            </p>

            <p>
                <label>E-mail:</label>
                <input type="email" name="email"
                    value="<?php echo $funcionario['email']; ?>" required>
            </p>

            <p>
                <label>Telefone:</label>
                <input type="text" name="telefone"
                    value="<?php echo $funcionario['telefone']; ?>" required>
            </p>

            <input type="submit" name="atualizar" value="Salvar alterações">

        </form>

        <p>
            <a href="equipe.php">Voltar para equipe</a>
        </p>

    </main>

</body>
</html>