<?php
require_once __DIR__ . '/../includes/functions.php';

// Guarda o ID do paciente
$id = "";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

if (isset($_POST['id'])) {
    $id = $_POST['id'];
}

// Cria as variáveis
$nome = "";
$tipo_animal = "";
$id_tutor = "";
$mensagem = "";

// Busca os dados do paciente
if ($id != "" && is_numeric($id)) {

    $sql = "SELECT * FROM pacientes WHERE id = :id";

    $consulta = $conexao->prepare($sql);
    $consulta->bindParam(':id', $id);
    $consulta->execute();

    $paciente = $consulta->fetch(PDO::FETCH_ASSOC);

    if ($paciente) {
        $nome = $paciente['nome'];
        $tipo_animal = $paciente['tipo_animal'];
        $id_tutor = $paciente['id_tutor'];
    } else {
        $mensagem = "Paciente não encontrado.";
    }

} else {
    $mensagem = "ID do paciente inválido.";
}

// Salva as alterações
if (isset($_POST['salvar']) && $mensagem == "") {

    $nome = $_POST['nome'];
    $tipo_animal = $_POST['tipo_animal'];
    $id_tutor = $_POST['id_tutor'];

    if ($nome != "" && $tipo_animal != "" && $id_tutor != "") {

        // Verifica se o tutor existe
        $sql = "SELECT id FROM tutores WHERE id = :id_tutor";

        $consulta = $conexao->prepare($sql);
        $consulta->bindParam(':id_tutor', $id_tutor);
        $consulta->execute();

        if ($consulta->fetch()) {

            // Atualiza os dados do paciente
            $sql = "UPDATE pacientes
                    SET nome = :nome,
                        tipo_animal = :tipo_animal,
                        id_tutor = :id_tutor
                    WHERE id = :id";

            $consulta = $conexao->prepare($sql);

            $consulta->bindParam(':nome', $nome);
            $consulta->bindParam(':tipo_animal', $tipo_animal);
            $consulta->bindParam(':id_tutor', $id_tutor);
            $consulta->bindParam(':id', $id);

            $consulta->execute();

            header("Location: pacientes.php");
            exit;

        } else {
            $mensagem = "O tutor selecionado não existe.";
        }

    } else {
        $mensagem = "Preencha todos os campos.";
    }
}

// Busca os tutores para mostrar no formulário
$sql = "SELECT id, nome FROM tutores ORDER BY nome";
$consulta = $conexao->prepare($sql);
$consulta->execute();

$tutores = $consulta->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>VetCare LR - Editar paciente</title>

    <link rel="stylesheet" href="../css/edit.css">
</head>

<body>

    <?php include __DIR__ . '/../includes/admheader.php'; ?>

    <main>

        <div class="cartao-edicao">

            <h1>Editar paciente</h1>

            <p class="texto-introducao">
                Altere as informações do paciente nos campos abaixo.
            </p>

            <?php if ($mensagem != "") { ?>
                <p class="mensagem-erro">
                    <?php echo $mensagem; ?>
                </p>
            <?php } ?>

            <?php if (isset($paciente) && $paciente) { ?>

                <form action="editarpaciente.php" method="post">

                    <input type="hidden" name="id" value="<?php echo $id; ?>">

                    <div class="campo-formulario">
                        <label for="nome">Nome do paciente:</label>

                        <input
                            type="text"
                            name="nome"
                            id="nome"
                            value="<?php echo $nome; ?>"
                            required
                        >
                    </div>

                    <div class="campo-formulario">
                        <label for="tipo_animal">Tipo de animal:</label>

                        <select name="tipo_animal" id="tipo_animal" required>
                            <option value="Cachorro" <?php if ($tipo_animal == "Cachorro") echo "selected"; ?>>Cachorro</option>
                            <option value="Gato" <?php if ($tipo_animal == "Gato") echo "selected"; ?>>Gato</option>
                            <option value="Bovino" <?php if ($tipo_animal == "Bovino") echo "selected"; ?>>Bovino</option>
                            <option value="Equino" <?php if ($tipo_animal == "Equino") echo "selected"; ?>>Equino</option>
                        </select>
                    </div>

                    <div class="campo-formulario">
                        <label for="id_tutor">Tutor responsável:</label>

                        <select name="id_tutor" id="id_tutor" required>

                            <?php foreach ($tutores as $tutor) { ?>

                                <option
                                    value="<?php echo $tutor['id']; ?>"
                                    <?php if ($id_tutor == $tutor['id']) echo "selected"; ?>
                                >
                                    <?php echo $tutor['nome']; ?>
                                </option>

                            <?php } ?>

                        </select>
                    </div>

                    <div class="botoes-edicao">

                        <a class="botao-cancelar" href="pacientes.php">
                            Cancelar
                        </a>

                        <input
                            class="botao-salvar"
                            type="submit"
                            name="salvar"
                            value="Salvar alterações"
                        >

                    </div>

                </form>

            <?php } ?>

        </div>

    </main>

    <?php include __DIR__ . '/../includes/admfooter.php'; ?>

</body>

</html>