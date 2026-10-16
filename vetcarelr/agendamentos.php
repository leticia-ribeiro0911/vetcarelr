<?php
/*
Essa parte verifica se o formulário foi enviado e se o tutor está logado.
Depois, recebe as informações do animal e do atendimento, cadastra o animal
e registra a solicitação no banco de dados. Os dois cadastros são feitos em
uma transação, para que sejam confirmados juntos ou desfeitos caso ocorra
algum erro. Por fim, define uma mensagem de sucesso ou erro para o cliente.
*/

session_start();

require_once __DIR__ . '/includes/functions.php';

$mensagem = "";

$nome_tutor = $_SESSION['nome'] ?? "";
$telefone = $_SESSION['telefone'] ?? "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (!isset($_SESSION['id'])) {
        header("Location: login/login.php");
        exit();
    }

    $id_tutor = $_SESSION['id'];

    $nome_animal = $_POST['nome_animal'];
    $tipo_animal = $_POST['tipo_animal'];
    $tipo_atendimento = $_POST['tipo_atendimento'];
    $data = $_POST['data'];
    $horario = $_POST['horario'];
    $observacoes = $_POST['observacoes'];

    try {
        $conexao->beginTransaction();

        $id_paciente = cadastrarpaciente(
            $conexao,
            $nome_animal,
            $tipo_animal,
            $id_tutor
        );

        if ($id_paciente) {
            $resultado = solicitaragendamento(
                $conexao,
                $id_tutor,
                $id_paciente,
                $tipo_atendimento,
                $data,
                $horario,
                $observacoes
            );

            if ($resultado) {
                $conexao->commit();
                $mensagem = "sucesso";
            } else {
                $conexao->rollBack();
                $mensagem = "erro";
            }
        } else {
            $conexao->rollBack();
            $mensagem = "erro";
        }

    } catch (PDOException $e) {
        if ($conexao->inTransaction()) {
            $conexao->rollBack();
        }

        $mensagem = "erro";
    }
}

// Tipos de animais disponíveis para selecionar
$tipos_animal = [
    "Cães",
    "Gatos",
    "Bovinos",
    "Equinos"
];

// Tipos de atendimento disponíveis para selecionar
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

    <title>VetCare LR - Agendamentos</title>

    <link rel="stylesheet" href="css/agendamentos.css">
</head>

<body>

    <?php include __DIR__ . '/includes/header.php'; ?>

    <main>
        <section class="introducao-agendamento">
            <h1>Agende uma consulta</h1>
            <p>
                Encontre o atendimento ideal para seu animal. <br>
                Preencha as informações e nossa equipe entrará em contato
                para conversar sobre a disponibilidade.
            </p>
        </section>

        <section class="etapas-agendamento">
            <h2>Como funciona o agendamento?</h2>

            <div class="etapas-conteudo">
                <div class="etapa">
                    <span class="numero-etapa">1</span>
                    <h3>Faça sua solicitação</h3>
                    <p>
                        Preencha o formulário com as informações do animal
                        e o atendimento desejado.
                    </p>
                </div>

                <div class="etapa">
                    <span class="numero-etapa">2</span>
                    <h3>Aguarde o contato</h3>
                    <p>
                        Nossa equipe verificará as informações e conversará
                        com você sobre a disponibilidade.
                    </p>
                </div>

                <div class="etapa">
                    <span class="numero-etapa">3</span>
                    <h3>Confirme o horário</h3>
                    <p>
                        Você receberá a confirmação da data e do horário
                        combinados com a equipe.
                    </p>
                </div>

                <div class="etapa">
                    <span class="numero-etapa">4</span>
                    <h3>Compareça ao atendimento</h3>
                    <p>
                        Com o horário confirmado, compareça ao hospital
                        veterinário na data combinada.
                    </p>
                </div>

        </section>

        <!-- Aviso de atendimento de urgência -->
        <section class="aviso-emergencia">

            <div class="conteudo-emergencia">

                <h2>
                    <i class="bi bi-exclamation-circle"></i>
                    Atendimento de urgência
                </h2>

                <p>
                    Em casos de emergência veterinária, entre em contato
                    diretamente com a equipe pelo telefone ou WhatsApp
                    informado na página de contato. Não aguarde a resposta
                    desta solicitação.
                </p>

            </div>

        </section>

        <!-- Formulário de agendamento -->
        <section class="secao-formulario">

            <div class="titulo-formulario">

                <h2>Solicite um atendimento</h2>

                <p>
                    Preencha os campos abaixo com atenção para que nossa
                    equipe possa analisar sua solicitação.
                </p>

            </div>

            <?php if (!isset($_SESSION['id'])) { ?>

            <?php } else { ?>

                <form action="" method="post">

                    <div class="campos-formulario">

                        <div class="campo">

                            <label for="nome_tutor">Nome do tutor</label>

                            <input
                                type="text"
                                name="nome_tutor"
                                id="nome_tutor"
                                value="<?php echo htmlspecialchars($nome_tutor); ?>"
                                placeholder="Seu nome completo"
                            >

                        </div>

                        <div class="campo">

                            <label for="telefone">Telefone</label>

                            <input
                                type="tel"
                                name="telefone"
                                id="telefone"
                                value="<?php echo htmlspecialchars($telefone); ?>"
                                placeholder="Seu telefone"
                            >

                        </div>

                        <div class="campo">

                            <label for="nome_animal">Nome do animal</label>

                            <input
                                type="text"
                                name="nome_animal"
                                id="nome_animal"
                                placeholder="Digite o nome do animal"
                                required
                            >

                        </div>

                        <div class="campo">

                            <label for="tipo_animal">Tipo de animal</label>

                            <select
                                name="tipo_animal"
                                id="tipo_animal"
                                required
                            >

                                <option value="">Selecione</option>

                                <?php foreach ($tipos_animal as $tipo) { ?>

                                    <option value="<?php echo htmlspecialchars($tipo); ?>">
                                        <?php echo htmlspecialchars($tipo); ?>
                                    </option>

                                <?php } ?>

                            </select>

                        </div>

                        <div class="campo">

                            <label for="tipo_atendimento">
                                Tipo de atendimento
                            </label>

                            <select
                                name="tipo_atendimento"
                                id="tipo_atendimento"
                                required
                            >

                                <option value="">Selecione</option>

                                <?php foreach ($tipos_atendimento as $tipo) { ?>

                                    <option value="<?php echo htmlspecialchars($tipo); ?>">
                                        <?php echo htmlspecialchars($tipo); ?>
                                    </option>

                                <?php } ?>

                            </select>

                        </div>

                        <div class="campo">

                            <label for="data">Data desejada</label>

                            <input
                                type="date"
                                name="data"
                                id="data"
                                min="<?php echo date('Y-m-d'); ?>"
                                required
                            >

                        </div>

                        <div class="campo">

                            <label for="horario">Horário desejado</label>

                            <input
                                type="time"
                                name="horario"
                                id="horario"
                                required
                            >

                        </div>

                        <div class="campo campo-observacoes">

                            <label for="observacoes">Observações</label>

                            <textarea
                                name="observacoes"
                                id="observacoes"
                                rows="5"
                                placeholder="Descreva brevemente o motivo do atendimento..."
                            ></textarea>

                        </div>

                    </div>

                    <button type="submit" class="botao-agendamento">
                        Solicitar atendimento
                    </button>

                </form>

            <?php } ?>

            <!-- Mensagem de sucesso -->
            <?php if ($mensagem == "sucesso") { ?>

                <div class="fundo-pop-up">

                    <div class="pop-up">

                        <i class="bi bi-check-circle icone-sucesso"></i>

                        <h2>Agendamento concluído!</h2>

                        <p>
                            Aguarde pelo retorno da nossa equipe.
                        </p>

                        <p>
                            Se precisar,
                            <a href="contato.php" class="link-contato">
                                contate-nos
                            </a>.
                        </p>

                        <a href="index.php" class="botao-inicio">
                            Voltar para a tela inicial
                        </a>

                        <div class="aviso">

                            <h3>Importante</h3>

                            <p>
                                O envio da solicitação não confirma
                                automaticamente o horário. A equipe entrará
                                em contato para confirmar o atendimento.
                            </p>

                        </div>

                    </div>

                </div>

            <?php } 
            elseif ($mensagem == "erro") 
            {
            ?>

                <div class="mensagem-erro">

                    <i class="bi bi-exclamation-triangle"></i>

                    <p>
                        Não foi possível enviar sua solicitação.
                        Verifique os dados e tente novamente.
                    </p>

                </div>

            <?php } ?>

        </section>

    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>

</body>

</html>