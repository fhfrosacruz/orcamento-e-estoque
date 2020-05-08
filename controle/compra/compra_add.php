<?php
include '../../conexao/banco.php';

//tabela compra

$material_id =  mysqli_real_escape_string($conn, $_POST['nome']);

$preco_total = mysqli_real_escape_string($conn, $_POST['preco_total']);

$quantidade = mysqli_real_escape_string($conn, $_POST['quantidade']);

$data_compra = mysqli_real_escape_string($conn, $_POST['data_compra']);

$observacao1 = mysqli_real_escape_string($conn, $_POST['observacao']);
$observacao = strtoupper($observacao1);

$add_compra = "INSERT INTO compra (material_id, preco_total, quantidade_comp, data_compra, observacao) VALUES ('$material_id', '$preco_total', '$quantidade', '$data_compra', '$observacao')";
$adiciona_compra = mysqli_query($conn, $add_compra)or die( mysqli_error($conn));

//var_dump($add_compra);
//echo $data_compra;

mysqli_close($conn);
header('Location: ../../compras.php?pesquisa=&pagina=1#');
?>
