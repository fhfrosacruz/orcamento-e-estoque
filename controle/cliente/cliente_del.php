<?php
include '../../conexao/banco.php';

$id = $_GET['id'];

$seleciona = "SELECT endereco_id FROM pessoa WHERE id_pessoa = '$id'";
$selecionado = mysqli_query($conn, $seleciona);
$id_end = mysqli_fetch_array($selecionado);
$id_deleta = $id_end['endereco_id'];
//echo $id_deleta;

$del_cliente = "DELETE FROM pessoa WHERE id_pessoa = '$id'";
$deleta = mysqli_query($conn, $del_cliente);

$del_endereco = "DELETE FROM endereco WHERE id_endereco = '".$id_deleta."'";
$end_del = mysqli_query($conn, $del_endereco);




mysqli_close($conn);
header('Location: ../../clientes.php');
?>
