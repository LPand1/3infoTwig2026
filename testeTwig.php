<?php
require('carregarTwig.php');

$nome = "Ashtar Sheran";
$disciplinas = [
    'Programação',
    'Banco de Dados',
    'Interface Web',
    'Desenvolvimento de Sistemas',
];

echo $twig->render('testeTwig.html', [
    'nome' => $nome,
    'legal' => true,
    'disciplinas' => $disciplinas,
]);