<?php
require_once __DIR__ . '/../includes/functions.php';

$mensagem = "";

// Verifica se o formulário foi enviado
if (isset($_POST['cadastrar'])) {

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $senha = $_POST['senha'];

    if (isset($conexao)) {

        $resultado = cadastrarfunc($conexao, $nome, $email, $telefone, $senha);

        if ($resultado == true) {
            $mensagem = "Funcionário cadastrado com sucesso!";
        } else {
            $mensagem = "Não foi possível cadastrar o funcionário.";
        }

    } else {
        $mensagem = "Banco de dados indisponível no momento.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>VetCare LR - Novo Usuário</title>
    <link rel="stylesheet" href="../css/novouser.css">
</head>

<body>

    <?php include __DIR__ . '/../includes/admheader.php'; ?>

    <main>

        <h1>Cadastrar novo funcionário</h1>

        <p><?php echo $mensagem; ?></p>

        <form action="" method="post">

            <p>
                <label for="nome">Nome completo:</label>
                <input type="text" name="nome" id="nome" required>
            </p>

            <p>
                <label for="email">E-mail:</label>
                <input type="email" name="email" id="email" required>
            </p>

            <p>
                <label for="telefone">Telefone:</label>
                <input type="text" name="telefone" id="telefone" required>
            </p>

            <p>
                <label for="senha">Senha:</label>
                <input type="password" name="senha" id="senha" required>
            </p>

            <input type="submit" name="cadastrar" value="Cadastrar funcionário">

        </form>

        <p>
            <a href="equipe.php">Voltar para equipe</a>
        </p>

    </main>

    <?php include __DIR__ . '/../includes/admfooter.php'; ?>

</body>

</html>