<?php
include '../../conexao/banco.php';

$id_empresa = $_GET['id']; //id da empresa

//faz uma pesquisa para pegar o id do endereço
$seleciona = "SELECT endereco_id FROM empresa WHERE id_empresa = '$id_empresa'";
$selecionado = mysqli_query($conn, $seleciona) or die( mysqli_error($conn));
$id_end = mysqli_fetch_array($selecionado);
$id_deleta = $id_end['endereco_id'];

//deleta a empresa
$del_empresa = "DELETE FROM empresa WHERE id_empresa = '$id_empresa'";
$deleta = mysqli_query($conn, $del_empresa) or die( mysqli_error($conn));

//deleta o endereço da empresa
$del_endereco = "DELETE FROM endereco WHERE id_endereco = '$id_deleta'";
$end_del = mysqli_query($conn, $del_endereco) or die( mysqli_error($conn));

mysqli_close($conn);
header('Location: ../../empresas.php');
?>
