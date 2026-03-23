<?php
$erro = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'] ?? false;
    $estilo = $_POST['estilo'] ?? false;

    if (!$nome || !$estilo) {
        $erro = 'Preencha todos os campos imediatamente ou morra';
    } else {
        // Tudo certo - gravar dados
        $ext = pathinfo($_FILES['capa']['name'], PATHINFO_EXTENSION); //pega extensão do arquivo
        $capa = uniqid().'.'.$ext; // cria nome do arquivo

        move_uploaded_file($_FILES['capa'] ['tmp_name'], "img/{$capa}"); // move arquivo para pasta

        require('carregarPdo.php');
        $dados = $pdo->prepare('INSERT INTO jogos (nome, estilo, capa)
        VALUES (?, ?, ?)');
        $dados->bindParam(1, $nome);
        $dados->bindParam(2, $estilo);
        $dados->bindParam(3, $capa);

        $dados->execute();

        header('location:jogos.php');
        die;
    }
}

require("carregarTwig.php");

echo $twig->render('jogosInserir.html', [
    'erro' => $erro,
]);