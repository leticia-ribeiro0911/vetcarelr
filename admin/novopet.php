<?php
require_once __DIR__ . '/../includes/functions.php';

$mensagem = "";

// Verifica se o formulário foi enviado
if (isset($_POST['cadastrar'])) {

    $nome_tutor = $_POST['nome_tutor'];
    $telefone = $_POST['telefone'];
    $cpf = $_POST['cpf'];

    $nome_paciente = $_POST['nome_paciente'];
    $tipo_animal = $_POST['tipo_animal'];

    // Cadastra o tutor
    $sql = "INSERT INTO tutores (nome, telefone, cpf, senha)
            VALUES (:nome, :telefone, NULLIF(:cpf, ''), '')
            RETURNING id";

    $consulta = $conexao->prepare($sql);

    $consulta->bindParam(':nome', $nome_tutor);
    $consulta->bindParam(':telefone', $telefone);
    $consulta->bindParam(':cpf', $cpf);

    $consulta->execute();

    // Guarda o ID do tutor cadastrado
    $id_tutor = $consulta->fetchColumn();

    // Cadastra o paciente como presencial
    $sql = "INSERT INTO pacientes
            (nome, tipo_animal, id_tutor, origem_cadastro)
            VALUES (:nome, :tipo_animal, :id_tutor, 'presencial')";

    $consulta = $conexao->prepare($sql);

    $consulta->bindParam(':nome', $nome_paciente);
    $consulta->bindParam(':tipo_animal', $tipo_animal);
    $consulta->bindParam(':id_tutor', $id_tutor);

    $consulta->execute();

    $mensagem = "Tutor e paciente cadastrados com sucesso!";
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>VetCare LR - Novo cadastro</title>

    <link rel="stylesheet" href="../css/novopet.css">
</head>

<body>

    <?php include __DIR__ . '/../includes/admheader.php'; ?>

    <main>

        <h1>Cadastrar paciente e tutor</h1>

        <p>Preencha os dados para registrar um atendimento presencial.</p>

        <?php if ($mensagem != "") { ?>

            <p><?php echo $mensagem; ?></p>

            <p>
                <a href="pacientes.php">Voltar para pacientes e tutores</a>
            </p>

        <?php } else { ?>

            <form action="" method="post">

                <h2>Dados do tutor</h2>

                <label for="nome_tutor">Nome completo:</label>
                <input type="text" name="nome_tutor" id="nome_tutor" required>

                <br><br>

                <label for="telefone">Telefone:</label>
                <input type="tel" name="telefone" id="telefone" required>

                <br><br>

                <label for="cpf">CPF (opcional):</label>
                <input type="text" name="cpf" id="cpf">

                <hr>

                <h2>Dados do paciente</h2>

                <label for="nome_paciente">Nome do animal:</label>
                <input type="text" name="nome_paciente" id="nome_paciente" required>

                <br><br>

                <label for="tipo_animal">Tipo de animal:</label>

                <select name="tipo_animal" id="tipo_animal" required>
                    <option value="">Selecione</option>
                    <option value="Cachorro">Cachorro</option>
                    <option value="Gato">Gato</option>
                    <option value="Bovino">Bovino</option>
                    <option value="Equino">Equino</option>
                </select>

                <br><br>

                <input type="submit" name="cadastrar" value="Cadastrar">

                <a href="pacientes.php">Cancelar</a>

            </form>

        <?php } ?>

    </main>

    <?php include __DIR__ . '/../includes/admfooter.php'; ?>

</body>

</html>