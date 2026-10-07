<?php
$host = "192.168.10.54";
$dbname = "carevetlr";
$user = "vetcarelr";
$pass = "lrvetcare";

try {
    $conexao = new PDO (
        "pgsql:host=$host;
        dbname=$dbname",
        $user,
        $pass
    );
    echo "conexão realizada com sucesso!";
} catch (PDOException $e){
    echo "erro: " . $e->getMessage();
}
?>