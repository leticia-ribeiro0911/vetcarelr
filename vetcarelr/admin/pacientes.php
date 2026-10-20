<?php
require_once __DIR__ . '/../includes/functions.php';

// Guarda os IDs digitados nas buscas
$id_site = "";
$id_adm = "";

// Verifica a busca dos cadastros pelo site
if (isset($_GET['id_site'])) {
    $id_site = $_GET['id_site'];
}

// Verifica a busca dos cadastros presenciais
if (isset($_GET['id_adm'])) {
    $id_adm = $_GET['id_adm'];
}

// Cria as listas de pacientes
$pacientes_site = [];
$pacientes_adm = [];

// Consulta os cadastros pelo site
if (isset($conexao)) {

    $sql = "SELECT pacientes.id, pacientes.nome AS nome_paciente,
            pacientes.tipo_animal, tutores.id AS id_tutor,
            tutores.nome AS nome_tutor, tutores.telefone
            FROM pacientes
            INNER JOIN tutores ON pacientes.id_tutor = tutores.id";

    if ($id_site != "") {
        $sql = $sql . " WHERE pacientes.id = :id";
    }

    $sql = $sql . " ORDER BY pacientes.id";

    $consulta = $conexao->prepare($sql);

    if ($id_site != "") {
        $consulta->bindParam(':id', $id_site);
    }

    $consulta->execute();

    $pacientes_site = $consulta->fetchAll(PDO::FETCH_ASSOC);


    // Consulta os cadastros presenciais
    $sql = "SELECT pacientes_adm.id, pacientes_adm.nome AS nome_paciente,
            pacientes_adm.tipo_animal, tutores_adm.id AS id_tutor,
            tutores_adm.nome AS nome_tutor, tutores_adm.telefone
            FROM pacientes_adm
            INNER JOIN tutores_adm
            ON pacientes_adm.id_tutor = tutores_adm.id";

    if ($id_adm != "") {
        $sql = $sql . " WHERE pacientes_adm.id = :id";
    }

    $sql = $sql . " ORDER BY pacientes_adm.id";

    $consulta = $conexao->prepare($sql);

    if ($id_adm != "") {
        $consulta->bindParam(':id', $id_adm);
    }

    $consulta->execute();

    $pacientes_adm = $consulta->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>VetCare LR - Pacientes e Tutores</title>

    <link rel="stylesheet" href="../css/pac.css">
</head>

<body>

    <?php include __DIR__ . '/../includes/admheader.php'; ?>

    <main>

        <h1>Pacientes e tutores</h1>

        <p>Consulte os pacientes e seus tutores cadastrados no hospital.</p>

        <p>
            <a href="novopet.php">+ Cadastrar paciente e tutor</a>
        </p>

        <hr>

        <div>

            <h2>Cadastrados pelo site</h2>

            <form action="pacientes.php" method="get">

                <label for="id_site">Buscar paciente por ID:</label>

                <input
                    type="number"
                    name="id_site"
                    id="id_site"
                    placeholder="Digite o ID..."
                    value="<?php echo $id_site; ?>"
                >

                <input type="submit" value="Buscar">

            </form>

            <br>

            <?php if (count($pacientes_site) > 0) { ?>

                <?php foreach ($pacientes_site as $paciente) { ?>

                    <div>

                        <h2><?php echo $paciente['nome_paciente']; ?></h2>

                        <p>ID do paciente: <?php echo $paciente['id']; ?></p>

                        <p>Tipo de animal: <?php echo $paciente['tipo_animal']; ?></p>

                        <h3>Dados do tutor</h3>

                        <p>ID do tutor: <?php echo $paciente['id_tutor']; ?></p>

                        <p>Nome: <?php echo $paciente['nome_tutor']; ?></p>

                        <p>Telefone: <?php echo $paciente['telefone']; ?></p>

                        <hr>

                    </div>

                <?php } ?>

            <?php } else { ?>

                <p>Nenhum paciente encontrado nos cadastros pelo site.</p>

            <?php } ?>

        </div>

        <hr>

        <div>

            <h2>Cadastrados presencialmente</h2>

            <form action="pacientes.php" method="get">

                <label for="id_adm">Buscar paciente por ID:</label>

                <input
                    type="number"
                    name="id_adm"
                    id="id_adm"
                    placeholder="Digite o ID..."
                    value="<?php echo $id_adm; ?>"
                >

                <input type="submit" value="Buscar">

            </form>

            <br>

            <?php if (count($pacientes_adm) > 0) { ?>

                <?php foreach ($pacientes_adm as $paciente) { ?>

                    <div>

                        <h2><?php echo $paciente['nome_paciente']; ?></h2>

                        <p>ID do paciente: <?php echo $paciente['id']; ?></p>

                        <p>Tipo de animal: <?php echo $paciente['tipo_animal']; ?></p>

                        <h3>Dados do tutor</h3>

                        <p>ID do tutor: <?php echo $paciente['id_tutor']; ?></p>

                        <p>Nome: <?php echo $paciente['nome_tutor']; ?></p>

                        <p>Telefone: <?php echo $paciente['telefone']; ?></p>

                        <hr>

                    </div>

                <?php } ?>

            <?php } else { ?>

                <p>Nenhum paciente encontrado nos cadastros presenciais.</p>

            <?php } ?>

        </div>

    </main>

    <?php include __DIR__ . '/../includes/admfooter.php'; ?>

</body>

</html>