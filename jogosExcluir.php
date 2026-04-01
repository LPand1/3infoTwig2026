<?php
require('carregarPdo.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int) $_POST['id'] ?? false;
    if ($id) {
        $excluir = $pdo->prepare('DELETE FROM jogos WHERE id = :id');
        $excluir->bindParam(':id', $id);
        $excluir->execute();
    }
    header('location:jogos.php');
    die;
}

$id = (int) $_GET['id'] ?? false;

if (!$id) {
    header('location:jogos.php');
    die;
}

require('carregarTwig.php');

$dados = $pdo->prepare('SELECT * FROM jogos WHERE id = :id');
$dados->execute([
    ':id'=> $id,
]);

if ($dados->rowCount() != 1) {
    header('location:jogos.php');
    die;
}

$jogo = $dados->fetch(PDO::FETCH_ASSOC);

echo $twig->render('jogosExcluir.html', [
    'jogo' => $jogo,
]);