<?php

function gerarChave() {
    $chave = strtoupper(
        implode('-', array_map(fn() => bin2hex(random_bytes(3)), range(1, 5)))
    );

    return $chave;
}