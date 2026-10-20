<?php
require_once __DIR__ . '/../includes/functions.php';

// Verifica se foi digitado um ID na busca
$id = "";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

// Consulta os funcionários
$funcionarios = [];

if (isset($conexao)) {

    if ($id != "") {
        $funcionario = consultarfuncionarioid($conexao, $id);

        if ($funcionario) {
            $funcionarios[] = $funcionario;
        }

    } else {
        $funcionarios = consultarfuncionarios($conexao);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css/equipe.css">

    <title>VetCare LR - Equipe</title>
</head>

<body>

    <?php include __DIR__ . '/../includes/admheader.php'; ?>

    <main>

        <h1>Equipe / usuários</h1>

        <p>Gerencie os usuários do sistema.</p>

        <!-- Formulário para buscar funcionário pelo ID -->
        <form action="" method="get">

            <label for="id">Buscar por ID:</label>

            <input
                type="number"
                name="id"
                id="id"
                placeholder="Buscar por ID..."
                value="<?php echo $id; ?>"
            >

            <input type="submit" value="Buscar">

        </form>

        <p>
            <a href="novouser.php">+ Novo usuário</a>
        </p>

        <h2>Funcionários cadastrados</h2>

        <?php if (count($funcionarios) > 0) { ?>

            <?php foreach ($funcionarios as $funcionario) { ?>

                <div>

                    <h2><?php echo $funcionario['nome']; ?></h2>

                    <p>ID: <?php echo $funcionario['id']; ?></p>

                    <p>E-mail: <?php echo $funcionario['email']; ?></p>

                    <p>Telefone: <?php echo $funcionario['telefone']; ?></p>

                    <p>
                        <a href="editaruser.php?id=<?php echo $funcionario['id']; ?>">
                            Editar
                        </a>
                    </p>

                    <form action="excluiruser.php" method="post"
                        onsubmit="return confirm('Tem certeza que deseja excluir este funcionário?');">

                        <input
                            type="hidden"
                            name="id"
                            value="<?php echo $funcionario['id']; ?>"
                        >

                        <input type="submit" value="Excluir">

                    </form>

                    <hr>

                </div>

            <?php } ?>

        <?php } else { ?>

            <p>Nenhum funcionário encontrado.</p>

        <?php } ?>

    </main>

    <?php include __DIR__ . '/../includes/admfooter.php'; ?>

</body>

</html>