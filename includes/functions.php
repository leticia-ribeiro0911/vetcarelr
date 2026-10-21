<?php 

require_once __DIR__ . '/../database/conect.php';

// Função para o funcionário recusar a solicitação do agendamento de atendimento, e poder retornar com o motivo da recusação.
function recusar($conexao, $id, $motivo_recusa){
    $sql = "UPDATE agendamentos SET status = 'recusado',
        motivo_recusa = :motivo_recusa
    WHERE id = :id";
        try {
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            echo "Agendamento $id recusado com sucesso!";
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
}

// Função para o funcionário confirmar a solicitação do agendamento de atendimento.
function confirmar($conexao, $id){
    $sql = "UPDATE agendamentos
    SET status = 'confirmado'
    WHERE id = :id";
    
    try {
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    echo "Agendamento $id confirmado com sucesso!";
    } catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
}

// Função para cadastrar uma solicitação de agendamento de atendimento.
function solicitaragendamento($conexao, $id_tutor, $id_paciente, $tipo_atendimento, $data, $horario, $observacoes){
    $sql = "INSERT INTO agendamentos (id_tutor, id_paciente, tipo_atendimento, data, horario, observacoes, status)
            VALUES (:id_tutor, :id_paciente, :tipo_atendimento, :data, :horario, :observacoes, 'pendente')";

    try {
        $stmt = $conexao->prepare($sql);

        $stmt->bindParam(":id_tutor", $id_tutor);
        $stmt->bindParam(":id_paciente", $id_paciente);
        $stmt->bindParam(":tipo_atendimento", $tipo_atendimento);
        $stmt->bindParam(":data", $data);
        $stmt->bindParam(":horario", $horario);
        $stmt->bindParam(":observacoes", $observacoes);

        $stmt->execute();

        return true;

    } catch (PDOException $e) {
    echo "Erro ao solicitar agendamento: " . $e->getMessage();
    return false;
}
}

// Função para listar as solicitações de agendamento.
function relatorio($conexao){
    $sql = "SELECT * FROM agendamentos ORDER BY id";

    try {
    $stmt = $conexao->prepare($sql);
    $stmt->execute();

    $agendamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($agendamentos as $agendamento){
    echo "ID: {$agendamento['id']}<br>";
    echo "Tutor: {$agendamento['id_tutor']}<br>";
    echo "Paciente: {$agendamento['id_paciente']}<br>";
    echo "Tipo de atendimento: {$agendamento['tipo_atendimento']}<br>";
    echo "Data: {$agendamento['data']}<br>";
    echo "Horário: {$agendamento['horario']}<br>";
    echo "Observações: {$agendamento['observacoes']}<br>";
    echo "Status: {$agendamento['status']}<br>";
    echo "Motivo da recusa: {$agendamento['motivo_recusa']}<br>";
    echo"<hr>";
    }
    } catch (PDOException $e) {
    echo "Erro:" . $e->getMessage();
}
}

// Função para atualizar os dados de um agendamento.
function atualizar($conexao, $id, $tipo_atendimento, $data, $horario, $observacoes){
    $sql = "UPDATE agendamentos SET tipo_atendimento = :tipo_atendimento, data = :data, horario = :horario, observacoes = :observacoes WHERE id = :id";

    try {
    $stmt = $conexao->prepare($sql);

    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":tipo_atendimento", $tipo_atendimento); 
    $stmt->bindParam(":data", $data); $stmt->bindParam(":horario", $horario); 
    $stmt->bindParam(":observacoes", $observacoes);

    $stmt->execute();
    echo "Agendamento atualizado com sucesso!";
    } catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
    }
}

// Função para consultar os dados de um agendamento pelo ID.
function consultar($conexao, $id){
    $sql = "SELECT * FROM agendamentos WHERE id = :id";

    try {
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    $agendamento = $stmt->fetch(PDO::FETCH_ASSOC);

    return $agendamento;

    } catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
}

//Função para cadastrar o tutor.
function cadastratutor($conexao, $nome, $cpf, $telefone, $senha){
    $sql = "INSERT INTO tutores (nome, cpf, telefone, senha) VALUES (:nome, :cpf, :telefone, :senha)";

    try {
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(":nome", $nome);
    $stmt->bindParam(":cpf", $cpf);
    $stmt->bindParam(":telefone", $telefone);
    $stmt->bindParam(":senha", $senha);

    $stmt->execute();
    echo "Tutor cadastrado com sucesso!";
    } catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
    }
}

// Função para consultar os dados do tutor pelo CPF para poder verificar o seu cadastro durante o login.
function consultatutor($conexao, $cpf){
    $sql = "SELECT id, nome, cpf, telefone, senha FROM tutores WHERE cpf = :cpf";

    try {
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(":cpf", $cpf);
    $stmt->execute();

    $tutor = $stmt->fetch(PDO::FETCH_ASSOC);
    return $tutor;

    } catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
}

// Função para cadastrar o animal do tutor durante a solicitação de agendamento.
function cadastrarpaciente($conexao, $nome, $tipo_animal, $id_tutor) {
    $sql = "INSERT INTO pacientes (nome, tipo_animal, id_tutor, origem_cadastro) VALUES (:nome,  :tipo_animal, :id_tutor, 'site') RETURNING id";

    try {
        $stmt = $conexao->prepare($sql);

        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":tipo_animal", $tipo_animal);
        $stmt->bindParam(":id_tutor", $id_tutor);

        $stmt->execute();

        return $stmt->fetchColumn();
    } catch (PDOException $e) {
        echo "Erro ao cadastrar animal: " . $e->getMessage();
        return false;
}
}

// Função para consultar os dados do funcionário pelo e-mail durante login administrativo.
function consultafunc($conexao, $email){
    $sql = "SELECT id, nome, email, telefone, senha FROM funcionarios WHERE email = :email";

    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        $funcionario = $stmt->fetch(PDO::FETCH_ASSOC);
        return $funcionario;
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

// Função para cadastrar um funcionário no painel administrativo.
function cadastrarfunc($conexao, $nome, $email, $telefone, $senha){
    $sql = "INSERT INTO funcionarios (nome, email, telefone, senha) VALUES (:nome, :email, :telefone, :senha)";

    try {
        $stmt = $conexao->prepare($sql);

        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":telefone", $telefone);
        $stmt->bindParam(":senha", $senha);

        $stmt->execute();

        return true;
    } catch (PDOexception $e) {
        echo "Erro: " . $e->getMessage();
    }
}

// Função para contar os agendamentos do dia.
function contaragendamentos($conexao) {
    $data = date('Y-m-d');

    $sql = "SELECT COUNT(*) FROM agendamentos WHERE data = :data";

    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":data", $data);
        $stmt->execute();

        $quantidade = $stmt->fetchColumn();

        return $quantidade;

    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
} 

// Função para contar os pacientes cadastrados.
function contarpacientes($conexao) {
    $sql = "SELECT COUNT(*) FROM pacientes";

    try {
        $stmt = $conexao->prepare($sql);
        $stmt->execute();

        $quantidade = $stmt->fetchColumn();

        return $quantidade;

    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

// Função para contar os funcionários cadastrados; Tela de início.
function contarfunc($conexao) {
    $sql = "SELECT COUNT(*) FROM funcionarios";

    try {
        $stmt = $conexao->prepare($sql);
        $stmt->execute();

        $quantidade = $stmt->fetchColumn();

        return $quantidade;

    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}


// Função para consultar todos os funcionários cadastrados; Tela de início.
function consultarfuncionarios($conexao) {
    $sql = "SELECT id, nome, email, telefone
            FROM funcionarios
            ORDER BY id";

    try {
        $stmt = $conexao->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        echo "Erro ao consultar funcionários: " . $e->getMessage();
        return [];
    }
}

// Função para consultar um funcionário pelo ID; Tela de início.
function consultarfuncionarioid($conexao, $id) {
    $sql = "SELECT id, nome, email, telefone
            FROM funcionarios
            WHERE id = :id";

    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        echo "Erro ao consultar funcionário: " . $e->getMessage();
        return false;
    }
}

// Função para editar os dados de um funcionário.
function editarfunc($conexao, $id, $nome, $email, $telefone) {
    $sql = "UPDATE funcionarios
            SET nome = :nome,
                email = :email,
                telefone = :telefone
            WHERE id = :id";

    try {
        $stmt = $conexao->prepare($sql);

        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":telefone", $telefone);

        $stmt->execute();

        return true;

    } catch (PDOException $e) {
        echo "Erro ao editar funcionário: " . $e->getMessage();
        return false;
    }
}

// Função para excluir um funcionário.
function excluirfunc($conexao, $id) {
    $sql = "DELETE FROM funcionarios
            WHERE id = :id";

    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        return true;

    } catch (PDOException $e) {
        echo "Erro ao excluir funcionário: " . $e->getMessage();
        return false;
    }
}