<?php
require('carregarPdo.php');
require('carregarTwig.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int) $_POST['id'] ?? false;
    $nome = $_POST['nome'] ?? false;
    $estilo = $_POST['estilo'] ?? false;

    if (!$_FILES['capa']['error']) {
        // Descobre nome do arquivo anterior
        $dados = $pdo->prepare('SELECT capa FROM jogos WHERE id = :id');
        $dados->execute([':id' => $id]);
        $capaVelha = $dados->fetch(PDO::FETCH_ASSOC)['capa'];
        // Apagar a capa
        $capaVelha = __DIR__ . '/img/' . $capaVelha;
        if (file_exists($capaVelha)) {
            unlink($capaVelha);
        }

        // Gravar a capa
        $ext = pathinfo($_FILES['capa']['name'], PATHINFO_EXTENSION);
        $capa = uniqid() . '.' . $ext;
        move_uploaded_file($_FILES['capa']['tmp_name'], "img/{$capa}");
    }

    $sql = 'UPDATE jogos SET nome = :nome, estilo = :estilo' . (isset($capa) ? ', capa = :capa' : '') . 'WHERE id = :id';
    $params = [
        ':id' => $id,
        ':nome' => $nome,
        ':estilo' => $estilo,
    ];
    $dados = $pdo->prepare($sql);
    if (isset($capa)) { $params[':capa'] = $capa; }
    $dados->execute($params);
    
    header('location:jogos.php');
    die;
}

$id = (int) $_GET['id'] ?? false;

if (!$id) {
    header('location:jogos.php');
    die;
}

$dados = $pdo->prepare('SELECT * FROM jogos WHERE id = :id');
$dados->execute([
    ':id' => $id,
]);

if ($dados->rowCount() != 1) {
    header('location:jogos.php');
    die;
}

$jogo = $dados->fetch(PDO::FETCH_ASSOC);

echo $twig->render('jogosEditar.html', [
    'jogo' => $jogo,
]);