<?php
include '../../conexao/banco.php';

$id_compra = $_GET['id'];

//deleta a material
$del_compra = "DELETE FROM compra WHERE id_compra = '$id_compra'";
$deleta = mysqli_query($conn, $del_compra) or die( mysqli_error($conn));

//var_dump($del_compra);
//echo $id_compra;

mysqli_close($conn);
header('Location: ../../compras.php');
?>
