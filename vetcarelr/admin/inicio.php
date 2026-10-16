
<?php
require_once __DIR__ . '/../includes/functions.php';

// Conta os agendamentos do dia
$quantidade = contaragendamentos($conexao);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>VetCare LR - Início Admin</title>
</head>

<body>

    <?php include __DIR__ . '/../includes/admheader.php'; ?>

    <main>

    <h1>Olá, Administrador(a)!</h1>

    <section>
        <div>
            <h2>Agendamentos hoje</h2>

            <p> <?php echo $quantidade; ?> </p>
        </div>
    </section>

    </main>

    <?php include __DIR__ . '/../includes/admfooter.php'; ?>

</body>

</html>