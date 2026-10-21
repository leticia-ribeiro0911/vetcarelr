<?php
require_once __DIR__ . '/../includes/functions.php';

// Guarda o ID do paciente
$id = "";
$mensagem = "";
$paciente = false;

// Verifica se o formulário foi enviado
if (isset($_POST['id'])) {
    $id = $_POST['id'];
} elseif (isset($_GET['id'])) {
    $id = $_GET['id'];
}

// Verifica se o ID é válido
if ($id != "" && is_numeric($id)) {

    // Busca os dados do paciente
    $sql = "SELECT * FROM pacientes WHERE id = :id";

    $consulta = $conexao->prepare($sql);
    $consulta->bindParam(':id', $id);
    $consulta->execute();

    $paciente = $consulta->fetch(PDO::FETCH_ASSOC);

    if (!$paciente) {
        $mensagem = "Paciente não encontrado.";
    }

} else {
    $mensagem = "ID do paciente inválido.";
}

// Confirma a exclusão
if (isset($_POST['excluir']) && $paciente) {

    // Exclui o paciente
    $sql = "DELETE FROM pacientes WHERE id = :id";

    $consulta = $conexao->prepare($sql);
    $consulta->bindParam(':id', $id);
    $consulta->execute();

    header("Location: pacientes.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>VetCare LR - Excluir paciente</title>

    <link rel="stylesheet" href="../css/delete.css">
</head>

<body>

    <?php include __DIR__ . '/../includes/admheader.php'; ?>

    <main>

        <div class="cartao-exclusao">

            <h1>Excluir paciente</h1>

            <?php if ($mensagem != "") { ?>

                <p class="mensagem-erro">
                    <?php echo $mensagem; ?>
                </p>

                <a class="botao-voltar" href="pacientes.php">
                    Voltar para pacientes
                </a>

            <?php } ?>

            <?php if ($paciente) { ?>

                <p class="texto-aviso">
                    Confira os dados abaixo antes de confirmar a exclusão.
                </p>

                <div class="dados-exclusao">

                    <p>
                        <strong>ID do paciente:</strong>
                        <?php echo $paciente['id']; ?>
                    </p>

                    <p>
                        <strong>Nome:</strong>
                        <?php echo $paciente['nome']; ?>
                    </p>

                    <p>
                        <strong>Tipo de animal:</strong>
                        <?php echo $paciente['tipo_animal']; ?>
                    </p>

                </div>

                <p class="pergunta-exclusao">
                    Tem certeza de que deseja excluir este paciente?
                </p>

                <p class="aviso-exclusao">
                    Essa ação não poderá ser desfeita.
                </p>

                <form action="excluirpaciente.php" method="post">

                    <input
                        type="hidden"
                        name="id"
                        value="<?php echo $paciente['id']; ?>"
                    >

                    <div class="botoes-exclusao">

                        <a class="botao-cancelar" href="pacientes.php">
                            Cancelar
                        </a>

                        <input
                            class="botao-excluir"
                            type="submit"
                            name="excluir"
                            value="Sim, excluir paciente"
                            onclick="return confirm('Confira o nome e o ID. Deseja realmente excluir este paciente?')"
                        >

                    </div>

                </form>

            <?php } ?>

        </div>

    </main>

    <?php include __DIR__ . '/../includes/admfooter.php'; ?>

</body>

</html>