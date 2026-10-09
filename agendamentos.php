<?php
session_start();

require_once __DIR__ . '/includes/functions.php';

if (!isset($_SESSION['id'])) {
    header("Location: login/login.php");
    exit();
}

$id_tutor = $_SESSION['id'];

$tipos_atendimento = [
    "Consulta veterinária",
    "Vacinação",
    "Exames laboratoriais",
    "Exames de imagem",
    "Cirurgia",
    "Internação",
    "Atendimento de emergência",
    "Odontologia veterinária",
    "Castração",
    "Check-up",
    "Atendimento especializado"
];

$pacientes = listarPacientesTutor($conexao, $id_tutor);

$mensagem = "";
$sucesso = false;
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <title>VetCare LR - Agendamentos</title>
</head>

<body>

    <?php include __DIR__ . '/includes/header.php'; ?>

    <main>

        <h1>Agendamentos</h1>

        <p>
            Preencha o formulário para solicitar um atendimento
            para seu animal. Nossa equipe entrará em contato
            para confirmar o agendamento.
        </p>

        <section>
            <h2>Atenção às emergências</h2>

            <p>
                Em casos de emergência veterinária, entre em contato
                diretamente com a equipe pelo telefone ou WhatsApp
                informado na página de contato. Não aguarde a resposta
                desta solicitação.
            </p>
        </section>

        <h2>Solicite seu atendimento</h2>

        <?php
        if (isset($_GET['sucesso'])) {
            echo "<p>Solicitação enviada! Aguarde a confirmação da equipe veterinária.</p>";
        }

        if (count($pacientes) > 0) {
        ?>

            <form action="" method="post">

                <label for="id_paciente">Animal</label>

                <select name="id_paciente" id="id_paciente" required>
                    <option value="">Selecione seu animal</option>

                    <?php
                    foreach ($pacientes as $paciente) {
                        echo '<option value="' . $paciente['id'] . '">';
                        echo htmlspecialchars($paciente['nome']);
                        echo ' (' . htmlspecialchars($paciente['tipo_animal']) . ')';
                        echo '</option>';
                    }
                    ?>

                </select>

                <br><br>

                <label for="tipo_atendimento">Tipo de atendimento</label>

                <select name="tipo_atendimento" id="tipo_atendimento" required>
                    <option value="">Selecione o atendimento</option>

                    <?php
                    foreach ($tipos_atendimento as $tipo) {
                        echo '<option value="' . htmlspecialchars($tipo) . '">';
                        echo htmlspecialchars($tipo);
                        echo '</option>';
                    }
                    ?>

                </select>

                <br><br>

                <label for="data">Data desejada</label>
                <input type="date" name="data" id="data"
                    min="<?= date('Y-m-d') ?>" required>

                <br><br>

                <label for="horario">Horário desejado</label>
                <input type="time" name="horario" id="horario" required>

                <br><br>

                <label for="observacoes">Observações</label>

                <textarea
                    name="observacoes"
                    id="observacoes"
                    rows="5"
                    placeholder="Escreva aqui outras informações importantes."></textarea>

                <br><br>

                <button type="submit">Solicitar agendamento</button>

            </form>

        <?php
        } else {
        ?>

            <p>
                Você ainda não possui animais cadastrados.
                Cadastre um animal antes de solicitar um atendimento.
            </p>

        <?php
        }
        ?>

    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        $id_paciente = $_POST['id_paciente'];
        $tipo_atendimento = $_POST['tipo_atendimento'];
        $data = $_POST['data'];
        $horario = $_POST['horario'];
        $observacoes = trim($_POST['observacoes']);

        $paciente_valido = false;

        foreach ($pacientes as $paciente) {
            if ($paciente['id'] == $id_paciente) {
                $paciente_valido = true;
            }
        }

        if (
            $paciente_valido &&
            in_array($tipo_atendimento, $tipos_atendimento) &&
            !empty($data) &&
            !empty($horario) &&
            $data >= date('Y-m-d')
        ) {

            $resultado = cadastrarAgendamento(
                $conexao,
                $id_tutor,
                $id_paciente,
                $tipo_atendimento,
                $data,
                $horario,
                $observacoes
            );

            if ($resultado) {
                header("Location: agendamentos.php?sucesso=1");
                exit();
            } else {
                echo "Não foi possível enviar a solicitação.";
            }

        } else {
            echo "Confira os dados preenchidos e tente novamente.";
        }
    }
    ?>

</body>
</html>