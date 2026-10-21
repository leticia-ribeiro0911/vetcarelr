<?php
require_once __DIR__ . '/../includes/functions.php';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css/cadastro.css">

    <title>VetCare LR - Cadastro</title>
</head>

<body>

    <?php include __DIR__ . '/../includes/header.php'; ?>

    <main class="pagina-cadastro">

        <section class="conteudo-cadastro">

            <h1>Cadastre-se</h1>

            <form action="" method="post">

                <label for="nome">Nome completo</label>
                <input type="text" name="nome" id="nome" placeholder="Digite seu nome completo">

                <label for="cpf">CPF</label>
                <input type="text" name="cpf" id="cpf" placeholder="000.000.000-00">

                <label for="telefone">Telefone</label>
                <input type="text" name="telefone" id="telefone" placeholder="(00) 00000-0000">

                <label for="senha">Senha</label>
                <input type="password" name="senha" id="senha" placeholder="Crie uma senha">

                <input type="submit" value="Criar conta" class="botao-cadastro">

            </form>

            <p>
                Já possui uma conta?
                <a href="login.php">Entrar</a>
            </p>

            <?php
            if ($_SERVER['REQUEST_METHOD'] == "POST") {

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

        </section>

    </main>

    <?php include __DIR__ . '/../includes/footer.php'; ?>

</body>
</html>