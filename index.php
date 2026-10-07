<!DOCTYPE html>
<html lang="pt-br">

<head>

<style>

    body {
        margin: 0;
    }

    .video-inicial {
        width: 100%;
        height: 400px;
        overflow: hidden;
    }

    .video-inicial video {
        width: 100%;
        height: 100%;
        object-fit: fill;
    }

</style>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>VetCare LR - Início</title>

</head>

<body>

    <?php include __DIR__ . '/includes/header.php'; ?>

    <main>

        <section class="video-inicial">

    <video autoplay muted loop playsinline>
        <source src="videos/vetcarev.mp4" type="video/mp4">
    </video>

        </section>

        <section id="sobre">

            <h1>Sobre a VetCare LR</h1>

            <p>
                A VetCare LR é um hospital veterinário criado para oferecer
                atendimento e cuidados para animais, buscando proporcionar
                conforto, segurança e bem-estar aos nossos pacientes.
            </p>

        </section>

    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>

</body>

</html>