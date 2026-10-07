<?php
require_once __DIR__ . '/../includes/functions.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VetCare LR - Cadastro</title>
</head>
<body>
    <h1>Cadastre-se</h1>
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <main>
        <form action="" method="post">
            <label for="nome">Nome completo </label>
            <input type="text" name="nome" id="nome"><br>
            <label for="cpf">CPF </label>
            <input type="text" name="cpf" id="cpf"><br>
        <br>
            <label for="telefone">Telefone </label>
            <input type="text" name="telefone" id="telefone"><br>
        <br>
            <label for="senha">Senha </label>
            <input type="password" name="senha" id="senha"><br>
        <br>
            <input type="submit" value="Criar conta">
        </form>

        <p>
            Já possui uma conta?
            <a href="login.php">Entrar</a>
        </p>

<?php 
if($_SERVER['REQUEST_METHOD'] == "POST") {

    $cpf = str_replace(['.', '-'], '', $_POST['cpf']);

    cadastratutor(
        $conexao,
        $_POST['nome'],
        $cpf,
        $_POST['telefone'],
        $_POST['senha']
    );

    header("Location: login.php");
    exit();

}
?>

    </main>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>