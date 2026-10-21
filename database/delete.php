<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apagar ID</title>
</head>
<body>
    <form action="" method="post">
         <label for="id">ID: </label>
    <input type="number" name="id" id="id"> <br>
        <input type="submit" value="Apagar">
    </form>
    <?php
    if($_SERVER['REQUEST_METHOD']=="POST"){
        require_once 'conect.php';

        $sql = "DELETE FROM alunos WHERE id = :id";
        try {
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(":id", $_POST['id']);
            $stmt->execute();
            echo "Usuário $id removido com sucesso!";
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    }
    ?>
</body>
</html>