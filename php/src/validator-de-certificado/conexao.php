<?php

include_once(__DIR__ . "\utils\carregarEnv.php");
carregarEnv();

try {
    $conexao = new PDO('mysql:dbname='.getenv('DB_NAME').';host='.getenv('DB_HOST'), getenv('DB_USER'), getenv('DB_PASSWORD'));
} catch (PDOException $e) {
    echo "<strong>Erro: </strong>" . $e->getMessage();
}

