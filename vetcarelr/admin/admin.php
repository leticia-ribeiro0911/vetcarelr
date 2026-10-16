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

    <title>VetCare LR - Login Admin</title>
</head>

<body>

    <main class="pagina-login">

        <section class="conteudo-login">

            <h1>Bem-vindo(a)!</h1>
            <h2>Faça login para acessar o painel administrativo</h2>

            <form action="" method="post">

                <label for="email">E-mail</label>
                <input type="text" name="email" id="email" placeholder="ex.: email@gmail.com">

                <label for="senha">Senha</label>
                <input type="password" name="senha" id="senha" placeholder="ex.: suasenha">

                <input type="submit" value="Entrar" class="botao-login">

            </form>

            <?php
            if ($_SERVER['REQUEST_METHOD'] == "POST") {

                $email = $_POST['email'];

                $funcionario = consultafunc($conexao, $email);

                if ($funcionario && $funcionario['email'] == $email && $funcionario['senha'] == $_POST['senha']) {

                    session_start();

                    $_SESSION['id'] = $funcionario['id'];

                   header("Location: /vetcarelr/admin/inicio.php");
                   exit();

                } else {

                    echo "E-mail ou senha inválidos.";

                }
            }
            ?>
  <?php require_once __DIR__ . '/../includes/admfooter.php'; ?>
        </section>

    </main>

</body>
</html>