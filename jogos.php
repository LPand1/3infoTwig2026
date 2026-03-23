<?php
require("carregarTwig.php");
require("carregarPdo.php");

$jogos = $pdo->query('SELECT * FROM jogos');
$todosJogos = $jogos->fetchAll(PDO::FETCH_BOTH);
// print_r($todosJogos);

echo $twig->render('jogos.html', [
    'jogos' => $todosJogos,
]);