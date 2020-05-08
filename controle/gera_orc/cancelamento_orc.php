<?php
include '../../conexao/banco.php';

$id=$_GET['id'];

$del_orc1 = "DELETE FROM `orcamento` WHERE id_orcamento = '$id'";
$del_orc = mysqli_query($conn, $del_orc1);

header('Location: ../../inicial.php?pesquisa=&pagina=1#');

 ?>
