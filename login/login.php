<?php
require_once __DIR__ . '/../includes/functions.php';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css/login.css">

    <title>VetCare LR - Login</title>
</head>

<body>

    <?php include __DIR__ . '/../includes/header.php'; ?>

    <main class="pagina-login">

        <section class="conteudo-login">

            <h1>ENTRAR</h1>

            <form action="" method="post">

                <label for="cpf">CPF</label>
                <input type="text" name="cpf" id="cpf" placeholder="000.000.000-00">

                <label for="senha">Senha</label>
                <input type="password" name="senha" id="senha" placeholder="Digite sua senha">

                <input type="submit" value="Fazer login" class="botao-login">

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

        </section>

    </main>

    <?php include __DIR__ . '/../includes/footer.php'; ?>

</body>
</html>