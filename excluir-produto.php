<?php

require 'src/conexao-bd.php';
require 'src/Repositorio/ProdutoRepositorio.php';
require 'src/Model/Produto.php';

$repository = new ProdutoRepositorio($pdo);

$repository->deletar($_POST['id']);

header('location: admin.php');

exit;