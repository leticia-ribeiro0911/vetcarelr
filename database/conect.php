<?php
$host = "localhost";
$dbname = "carevetlr_db";
$user = "vetcarelr";
$pass = "lrvetcare";

try {
    $conexao = new PDO (
        "pgsql:host=$host;
        dbname=$dbname",
        $user,
        $pass
    );
} catch (PDOException $e){
    echo "erro: " . $e->getMessage();
}
?>