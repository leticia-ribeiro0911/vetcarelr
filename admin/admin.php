<?php
require_once __DIR__ . '/../includes/functions.php';

$erro = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $email = $_POST['email'];

    $funcionario = consultafunc($conexao, $email);

    if ($funcionario && $funcionario['email'] == $email && $funcionario['senha'] == $_POST['senha']) {

        session_start();

        $_SESSION['id'] = $funcionario['id'];

        header("Location: /vetcarelr/admin/inicio.php");
        exit();

    } else {

        $erro = "E-mail ou senha inválidos.";

    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>VetCare LR - Login Admin</title>

    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/admfo.css">
</head>

<body>

    <main class="pagina-login">

        <section class="conteudo-login">

            <div class="imagem-login">

                <img src="../imagens/admin.jpg" alt="Atendimento veterinário">

            </div>

            <div class="formulario-login">

                <h1>Bem-vindo(a)!</h1>

                <h2>Faça login para acessar o painel administrativo.</h2>

                <form action="" method="post">

                    <label for="email">E-mail</label>
                    <input type="text" name="email" id="email" placeholder="ex.: email@gmail.com" required>

                    <label for="senha">Senha</label>
                    <input type="password" name="senha" id="senha" placeholder="ex.: suasenha" required>

                    <input type="submit" value="Entrar" class="botao-login">

                </form>

                <p><strong>E-mail:</strong> adminvet@vetcarelr.com</p>
                <p><strong>Senha:</strong> luansantana</p>

                <?php
                if ($erro != "") {
                    echo "<p class='mensagem-erro'>$erro</p>";
                }
                ?>

            </div>

        </section>

    </main>

    <?php require_once __DIR__ . '/../includes/admfooter.php'; ?>

</body>

</html>