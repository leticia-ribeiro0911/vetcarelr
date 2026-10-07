<?php
require_once __DIR__ . '/../includes/functions.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VetCare LR - Login</title>
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <h1>ENTRAR</h1>
    <main>
        <form action="" method="post">
            <label for="cpf">CPF</label>
            <input type="text" name="cpf" id="cpf"><br>
            <label for="senha">Senha </label>
            <input type="password" name="senha" id="senha"><br>
        <br>
            <input type="submit" value="Fazer login">
        </form>

        <p> 
            Não possui uma conta ainda?
            <a href="cadastrar.php">Cadastre-se</a>
        </p>

     <?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $cpf = str_replace(['.', '-'], '', $_POST['cpf']);

    $tutor = consultatutor($conexao, $cpf);

    if ($tutor && $tutor['cpf'] == $cpf && $tutor['senha'] == $_POST['senha']) {

        session_start();

        $_SESSION['id'] = $tutor['id'];

        header("Location: ../index.php");
        exit();

    } else {

        echo "CPF ou senha inválidos.";

    }
}
?>

    </main>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>