<?php
require_once __DIR__ . '/../includes/functions.php';

// Guarda os IDs digitados nas buscas
$id_site = "";
$id_adm = "";

// Verifica se foi digitado um ID na busca
if (isset($_GET['id_site'])) {
    $id_site = $_GET['id_site'];
}

if (isset($_GET['id_adm'])) {
    $id_adm = $_GET['id_adm'];
}

// Guarda os pacientes encontrados
$pacientes_site = [];
$pacientes_adm = [];

// Busca os pacientes cadastrados pelo site
$sql = "SELECT pacientes.id, pacientes.nome AS nome_paciente,
        pacientes.tipo_animal, pacientes.origem_cadastro,
        pacientes.status, tutores.id AS id_tutor,
        tutores.nome AS nome_tutor, tutores.telefone
        FROM pacientes
        INNER JOIN tutores ON pacientes.id_tutor = tutores.id
        WHERE pacientes.origem_cadastro = 'site'";

if ($id_site != "") {
    $sql = $sql . " AND pacientes.id = :id";
}

$sql = $sql . " ORDER BY pacientes.id";

$consulta = $conexao->prepare($sql);

if ($id_site != "") {
    $consulta->bindParam(':id', $id_site);
}

$consulta->execute();

$pacientes_site = $consulta->fetchAll(PDO::FETCH_ASSOC);


// Busca os pacientes cadastrados presencialmente
$sql = "SELECT pacientes.id, pacientes.nome AS nome_paciente,
        pacientes.tipo_animal, pacientes.origem_cadastro,
        pacientes.status, tutores.id AS id_tutor,
        tutores.nome AS nome_tutor, tutores.telefone
        FROM pacientes
        INNER JOIN tutores ON pacientes.id_tutor = tutores.id
        WHERE pacientes.origem_cadastro = 'presencial'";

if ($id_adm != "") {
    $sql = $sql . " AND pacientes.id = :id";
}

$sql = $sql . " ORDER BY pacientes.id";

$consulta = $conexao->prepare($sql);

if ($id_adm != "") {
    $consulta->bindParam(':id', $id_adm);
}

$consulta->execute();

$pacientes_adm = $consulta->fetchAll(PDO::FETCH_ASSOC);
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
            <a href="novopet.php">+ Novo paciente e tutor</a>
        </p>

        <hr>

        <!-- PACIENTES CADASTRADOS PELO SITE -->

        <div class="secao-pacientes">

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

            <?php if (count($pacientes_site) > 0) { ?>

                <?php foreach ($pacientes_site as $paciente) { ?>

                    <div class="cartao-paciente">

                        <!-- DADOS DO PACIENTE E DO TUTOR -->

                        <div class="dados-paciente">

                            <h2><?php echo $paciente['nome_paciente']; ?></h2>

                            <p> <strong>ID do paciente: </strong> <?php echo $paciente['id']; ?> </p>

                            <p> <strong>Tipo de animal: </strong> <?php echo $paciente['tipo_animal']; ?> </p>

                            <p> <strong>Origem do cadastro: </strong> Site </p>

                            <h3>Dados do tutor</h3>

                            <p> <strong>ID do tutor: </strong> <?php echo $paciente['id_tutor']; ?> </p>

                            <p> <strong> Nome: </strong><?php echo $paciente['nome_tutor']; ?> </p>

                            <p> <strong> Telefone: </strong> <?php echo $paciente['telefone']; ?> </p>

                        </div>

                        <!-- STATUS NO MEIO DO CARTÃO -->

                        <div class="coluna-status">

                            <h3>Status</h3>

                            <?php if ($paciente['status'] == 'ativo') { ?>

                                <span class="status-paciente status-ativo">
                                    Ativo
                                </span>

                            <?php } else { ?>

                                <span class="status-paciente status-inativo">
                                    Inativo
                                </span>

                            <?php } ?>

                        </div>

                        <!-- AÇÕES À DIREITA -->

                        <div class="acoes-paciente">

                            <h3>Ações</h3>

                            <a
                                class="botao-editar"
                                href="editarpaciente.php?id=<?php echo $paciente['id']; ?>"
                            >
                                Editar paciente
                            </a>

                            <form action="statuspaciente.php" method="post">

                                <input
                                    type="hidden"
                                    name="id"
                                    value="<?php echo $paciente['id']; ?>"
                                >

                                <?php if ($paciente['status'] == 'ativo') { ?>

                                    <input
                                        type="hidden"
                                        name="status"
                                        value="inativo"
                                    >

                                    <input
                                        class="botao-inativar"
                                        type="submit"
                                        value="Inativar paciente"
                                        onclick="return confirm('Deseja inativar este paciente?')"
                                    >

                                <?php } else { ?>

                                    <input
                                        type="hidden"
                                        name="status"
                                        value="ativo"
                                    >

                                    <input
                                        class="botao-ativar"
                                        type="submit"
                                        value="Ativar paciente"
                                        onclick="return confirm('Deseja ativar este paciente?')"
                                    >

                                <?php } ?>

                            </form>

                            <a
                                class="botao-excluir"
                                href="excluirpaciente.php?id=<?php echo $paciente['id']; ?>"
                            >
                                Excluir paciente
                            </a>

                        </div>

                    </div>

                <?php } ?>

            <?php } else { ?>

                <p>Nenhum paciente encontrado nos cadastros pelo site.</p>

            <?php } ?>

        </div>

        <hr>

        <!-- PACIENTES CADASTRADOS PRESENCIALMENTE -->

        <div class="secao-pacientes">

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

            <?php if (count($pacientes_adm) > 0) { ?>

                <?php foreach ($pacientes_adm as $paciente) { ?>

                    <div class="cartao-paciente">

                        <!-- DADOS DO PACIENTE E DO TUTOR -->

                        <div class="dados-paciente">

                            <h2><?php echo $paciente['nome_paciente']; ?></h2>

                            <p>
                                ID do paciente:
                                <?php echo $paciente['id']; ?>
                            </p>

                            <p>
                                Tipo de animal:
                                <?php echo $paciente['tipo_animal']; ?>
                            </p>

                            <p>Origem do cadastro: Presencial</p>

                            <h3>Dados do tutor</h3>

                            <p>
                                ID do tutor:
                                <?php echo $paciente['id_tutor']; ?>
                            </p>

                            <p>
                                Nome:
                                <?php echo $paciente['nome_tutor']; ?>
                            </p>

                            <p>
                                Telefone:
                                <?php echo $paciente['telefone']; ?>
                            </p>

                        </div>

                        <!-- STATUS NO MEIO DO CARTÃO -->

                        <div class="coluna-status">

                            <h3>Status</h3>

                            <?php if ($paciente['status'] == 'ativo') { ?>

                                <span class="status-paciente status-ativo">
                                    Ativo
                                </span>

                            <?php } else { ?>

                                <span class="status-paciente status-inativo">
                                    Inativo
                                </span>

                            <?php } ?>

                        </div>

                        <!-- AÇÕES À DIREITA -->

                        <div class="acoes-paciente">

                            <h3>Ações</h3>

                            <a
                                class="botao-editar"
                                href="editarpaciente.php?id=<?php echo $paciente['id']; ?>"
                            >
                                Editar paciente
                            </a>

                            <form action="statuspaciente.php" method="post">

                                <input
                                    type="hidden"
                                    name="id"
                                    value="<?php echo $paciente['id']; ?>"
                                >

                                <?php if ($paciente['status'] == 'ativo') { ?>

                                    <input
                                        type="hidden"
                                        name="status"
                                        value="inativo"
                                    >

                                    <input
                                        class="botao-inativar"
                                        type="submit"
                                        value="Inativar paciente"
                                        onclick="return confirm('Deseja inativar este paciente?')"
                                    >

                                <?php } else { ?>

                                    <input
                                        type="hidden"
                                        name="status"
                                        value="ativo"
                                    >

                                    <input
                                        class="botao-ativar"
                                        type="submit"
                                        value="Ativar paciente"
                                        onclick="return confirm('Deseja ativar este paciente?')"
                                    >

                                <?php } ?>

                            </form>

                            <a
                                class="botao-excluir"
                                href="excluirpaciente.php?id=<?php echo $paciente['id']; ?>"
                            >
                                Excluir paciente
                            </a>

                        </div>

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