<?php
function carregarEnv() {
    $env_caminho = __DIR__ . '/../.env';
    if (!file_exists($env_caminho)) {
        die('Arquivo .env não encontrado');
    }

    $linhas = file($env_caminho, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);

    foreach ($linhas as $linha) {
        // Ignora linhas que começam com # (comentários)
        if (strpos(trim($linha), '#') === 0) {
            continue;
        }

        list($chave, $valor) = explode('=', $linha, 2);
        if (!empty($chave) && !empty($valor)) {
            putenv(trim($chave) . '=' . trim($valor));
        }
    }
};