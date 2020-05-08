<?php
include '../../conexao/banco.php';

//tabela compra
$id = mysqli_real_escape_string($conn, $_POST['id']);

$material_id = mysqli_real_escape_string($conn, $_POST['material_id']);

$preco_total = mysqli_real_escape_string($conn, $_POST['preco_total']);

$quantidade = mysqli_real_escape_string($conn, $_POST['quantidade']);

$data_compra = mysqli_real_escape_string($conn, $_POST['data_compra']);

$observacao1 = mysqli_real_escape_string($conn, $_POST['observacao']);
$observacao = strtoupper($observacao1);

$edita_compra = "UPDATE compra SET id_compra ='$id', material_id='$material_id', preco_total='$preco_total', quantidade_comp='$quantidade', data_compra='$data_compra', observacao='$observacao' WHERE id_compra = '$id'";
$edita_compra = mysqli_query($conn, $edita_compra)or die( mysqli_error($conn));


echo $id;
var_dump($material_id);

mysqli_close($conn);
header('Location: ../../compras.php?pesquisa=&pagina=1#');
?>
