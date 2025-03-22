<?php

define('DBNAME', 'validador_de_certificado');
define('ROOT', 'mysql');
define('USER', 'root');
define('PASSWORD', 'example');

try {
    $conexao = new PDO('mysql:dbname='.DBNAME.';host='.ROOT, USER, PASSWORD);
} catch (PDOException $e) {
    echo "$e <br>" . var_dump($conexao);
}

