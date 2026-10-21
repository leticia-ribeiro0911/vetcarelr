<?php
require_once __DIR__ . '/../includes/functions.php';

// Conta os agendamentos de hoje
if (isset($conexao)) {
    $quantidade = contaragendamentos($conexao);

    // Conta os pacientes cadastrados
    $consulta_pacientes = $conexao->query("SELECT COUNT(*) FROM pacientes");
    $pacientes = $consulta_pacientes->fetchColumn();

    // Conta os funcionários cadastrados
    $consulta_equipe = $conexao->query("SELECT COUNT(*) FROM funcionarios");
    $equipe = $consulta_equipe->fetchColumn();

} else {
    $quantidade = 0;
    $pacientes = 0;
    $equipe = 0;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="../css/inicio.css">

    <title>VetCare LR - Início Admin</title>
</head>

<body>

    <?php include __DIR__ . '/../includes/admheader.php'; ?>

    <main class="pagina-inicio">

        <section class="boas-vindas">
            <p class="texto-pequeno">PAINEL ADMINISTRATIVO</p>

            <h1>Olá, Administrador(a)!</h1>

            <p>
                Bem-vindo(a) ao painel administrativo do VetCare LR.
                Aqui você pode acompanhar as informações do hospital.
            </p>
        </section>

        <section class="resumo">

            <div class="cartao-resumo">
                <div class="icone-resumo">
                    <i class="bi bi-calendar-check"></i>
                </div>

                <h2>Agendamentos hoje</h2>

                <p class="numero"><?php echo $quantidade; ?></p>

                <a href="admagendamento.php">
                    Ver todos <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            <div class="cartao-resumo">
                <div class="icone-resumo">
                    <i class="bi bi-heart-pulse"></i>
                </div>

                <h2>Pacientes</h2>

                <p class="numero"><?php echo $pacientes; ?></p>

                <a href="pacientes.php">
                    Ver todos <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            <div class="cartao-resumo">
                <div class="icone-resumo">
                    <i class="bi bi-people"></i>
                </div>

                <h2>Equipe</h2>

                <p class="numero"><?php echo $equipe; ?></p>

                <a href="equipe.php">
                    Ver todos <i class="bi bi-arrow-right"></i>
                </a>
            </div>

        </section>

    </main>

    <?php include __DIR__ . '/../includes/admfooter.php'; ?>

</body>
</html>