<?php
require_once __DIR__ . '/../includes/functions.php';

// Guarda o ID e o novo status
$id = "";
$status = "";

// Verifica se o formulário foi enviado
if (isset($_POST['id']) && isset($_POST['status'])) {

    $id = $_POST['id'];
    $status = $_POST['status'];

    // Verifica se o ID é válido e se o status foi permitido
    if (is_numeric($id) && ($status == "ativo" || $status == "inativo")) {

        // Verifica se o paciente existe
        $sql = "SELECT id FROM pacientes WHERE id = :id";

        $consulta = $conexao->prepare($sql);
        $consulta->bindParam(':id', $id);
        $consulta->execute();

        if ($consulta->fetch()) {

            // Atualiza o status do paciente
            $sql = "UPDATE pacientes SET status = :status WHERE id = :id";

            $consulta = $conexao->prepare($sql);

            $consulta->bindParam(':status', $status);
            $consulta->bindParam(':id', $id);

            $consulta->execute();

        }
    }
}

// Volta para a lista de pacientes
header("Location: pacientes.php");
exit;
?>