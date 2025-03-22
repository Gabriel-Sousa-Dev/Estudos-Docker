<?php

define('DBNAME', 'validador_de_certificado');
define('ROOT', 'estudos-docker.railway.internal');
define('USER', 'root');
define('PASSWORD', 'example');

try {
    $conexao = new PDO('mysql:dbname='.DBNAME.';host='.ROOT, USER, PASSWORD);
} catch (PDOException $e) {
    echo "<strong>erro:</strong>" . $e->getMessage();
}

