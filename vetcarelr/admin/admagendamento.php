<?php
require_once __DIR__ . '/../includes/functions.php';

// Guarda a mensagem que aparece na tela
$mensagem = "";

// Verifica se foi clicado em confirmar ou recusar
if (isset($_POST['acao']) && isset($conexao)) {

    $id = $_POST['id'];

    if ($_POST['acao'] == "confirmar") {

        $sql = "UPDATE agendamentos
                SET status = 'confirmado'
                WHERE id = :id";

        $consulta = $conexao->prepare($sql);
        $consulta->bindParam(":id", $id);
        $consulta->execute();

        $mensagem = "Agendamento confirmado com sucesso!";

    } elseif ($_POST['acao'] == "recusar") {

        $sql = "UPDATE agendamentos
                SET status = 'recusado'
                WHERE id = :id";

        $consulta = $conexao->prepare($sql);
        $consulta->bindParam(":id", $id);
        $consulta->execute();

        $mensagem = "Agendamento recusado com sucesso!";
    }
}

// Guarda os agendamentos encontrados
$agendamentos = [];

// Consulta os agendamentos e os dados do tutor e do paciente
if (isset($conexao)) {

    $sql = "SELECT agendamentos.*,
                   tutores.nome AS nome_tutor,
                   tutores.telefone AS telefone_tutor,
                   pacientes.nome AS nome_paciente,
                   pacientes.tipo_animal
            FROM agendamentos
            INNER JOIN tutores
            ON agendamentos.id_tutor = tutores.id
            INNER JOIN pacientes
            ON agendamentos.id_paciente = pacientes.id
            ORDER BY agendamentos.id";

    $consulta = $conexao->prepare($sql);
    $consulta->execute();

    $agendamentos = $consulta->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>VetCare LR - Agendamentos</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css/adma.css">
</head>

<body>

    <?php include __DIR__ . '/../includes/admheader.php'; ?>

    <main>

        <h1>Agendamentos</h1>

        <p>Consulte as solicitações e gerencie os agendamentos dos pacientes.</p>

        <?php if ($mensagem != "") { ?>
            <p><?php echo $mensagem; ?></p>
        <?php } ?>

        <h2>Solicitações recebidas</h2>

        <?php if (count($agendamentos) > 0) { ?>

            <?php foreach ($agendamentos as $agendamento) { ?>

                <div>

                    <h3>Agendamento nº <?php echo $agendamento['id']; ?></h3>

                    <p>
                        <strong>Tutor:</strong>
                        <?php echo $agendamento['nome_tutor']; ?>
                    </p>

                    <p>
                        <strong>Telefone do tutor:</strong>
                        <?php echo $agendamento['telefone_tutor']; ?>
                    </p>

                    <p>
                        <strong>Paciente:</strong>
                        <?php echo $agendamento['nome_paciente']; ?>
                    </p>

                    <p>
                        <strong>Tipo de animal:</strong>
                        <?php echo $agendamento['tipo_animal']; ?>
                    </p>

                    <p>
                        <strong>Tipo de atendimento:</strong>
                        <?php echo $agendamento['tipo_atendimento']; ?>
                    </p>

                    <p>
                        <strong>Data:</strong>
                        <?php echo $agendamento['data']; ?>
                    </p>

                    <p>
                        <strong>Horário:</strong>
                        <?php echo $agendamento['horario']; ?>
                    </p>

                    <p>
                        <strong>Observações:</strong>
                        <?php
                        if ($agendamento['observacoes'] != "") {
                            echo $agendamento['observacoes'];
                        } else {
                            echo "Nenhuma observação.";
                        }
                        ?>
                    </p>

                    <p>
                        <strong>Status:</strong>
                        <?php echo $agendamento['status']; ?>
                    </p>

                    <?php if ($agendamento['status'] == "pendente") { ?>

                        <form action="" method="post">

                            <input type="hidden" name="id" value="<?php echo $agendamento['id']; ?>">

                            <input type="hidden" name="acao" value="confirmar">

                            <input type="submit" value="Confirmar agendamento">

                        </form>

                        <form action="" method="post">

                            <input type="hidden" name="id" value="<?php echo $agendamento['id']; ?>">

                            <input type="hidden" name="acao" value="recusar">

                            <input type="submit" value="Recusar agendamento">

                        </form>

                    <?php } ?>

                    <hr>

                </div>

            <?php } ?>

        <?php } else { ?>

            <p>Nenhum agendamento encontrado.</p>

        <?php } ?>

    </main>

    <?php include __DIR__ . '/../includes/admfooter.php'; ?>

</body>

</html>