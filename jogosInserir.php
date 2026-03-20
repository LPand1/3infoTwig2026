<?php
$erro = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'] ?? false;
    $estilo = $_POST['estilo'] ?? false;

    if (!$nome || !$estilo) {
        $erro = 'Preencha todos os campos imediatamente ou morra';
    } else {
                
    }
}

require("carregarTwig.php");

echo $twig->render('jogosInserir.html', [
    'erro' => $erro,
]);