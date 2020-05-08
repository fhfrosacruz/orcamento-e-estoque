<?php
include '../../conexao/banco.php';

$id_func = $_GET['id'];

//pegando o id pessoa do funcionario
$pessoa_func = "SELECT pessoa_id FROM funcionario WHERE id_funcionario = '$id_func'";
$pessoa_sql = mysqli_query($conn, $pessoa_func) or die( mysqli_error($conn));
$pessoa_fetch = mysqli_fetch_array($pessoa_sql);
$id_pes_func = $pessoa_fetch['pessoa_id'];

//faz uma pesquisa para pegar o id do endereço
$seleciona = "SELECT endereco_id FROM pessoa WHERE id_pessoa = '$id_pes_func'";
$selecionado = mysqli_query($conn, $seleciona) or die( mysqli_error($conn));
$id_end = mysqli_fetch_array($selecionado);
$id_deleta = $id_end['endereco_id'];

//deleta o funcionarios
$del_funcionario = "DELETE FROM funcionario WHERE id_funcionario = '".$id_func."'";
$func_del = mysqli_query($conn, $del_funcionario) or die( mysqli_error($conn));

//deleta a pessoa
$del_cliente = "DELETE FROM pessoa WHERE id_pessoa = '$id_pes_func'";
$deleta = mysqli_query($conn, $del_cliente) or die( mysqli_error($conn));

//deleta o endereço
$del_endereco = "DELETE FROM endereco WHERE id_endereco = '".$id_deleta."'";
$end_del = mysqli_query($conn, $del_endereco) or die( mysqli_error($conn));

mysqli_close($conn);
header('Location: ../../funcionarios.php');
?>
