<?php
$id = (int) $_GET["id"] ?? false;

require('carregarTwig.php');
require('carregarPdo.php');

echo $twig->render('jogosEditar.html');