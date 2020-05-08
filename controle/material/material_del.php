<?php
include '../../conexao/banco.php';

$id_material = $_GET['id']; //id da material

//deleta a material
$del_material = "DELETE FROM material WHERE id_material = '$id_material'";
$deleta = mysqli_query($conn, $del_material) or die( mysqli_error($conn));


mysqli_close($conn);
header('Location: ../../materiais.php');
?>
