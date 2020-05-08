<?php
include '../../conexao/banco.php';

//tabela material
$id1 = mysqli_real_escape_string($conn, $_POST['id']);
$id = strtoupper($id1);

$nome1 = mysqli_real_escape_string($conn, $_POST['nome_mat']);
$nome = strtoupper($nome1);

$tipo1 = mysqli_real_escape_string($conn, $_POST['tipo']);
$tipo = strtoupper($tipo1);

$uni_medida1 = mysqli_real_escape_string($conn, $_POST['uni_medida']);
$uni_medida = strtoupper($uni_medida1);

$quantidade1 = mysqli_real_escape_string($conn, $_POST['quantidade']);
$quantidade = strtoupper($quantidade1);

$edita_material = "UPDATE material SET nome_mat ='$nome', tipo='$tipo', uni_medida='$uni_medida', quantidade='$quantidade' WHERE id_material = '$id'";
$edita_mat = mysqli_query($conn, $edita_material)or die( mysqli_error($conn));

/*
echo $id;
var_dump($edita_material);
*/
mysqli_close($conn);
header('Location: ../../materiais.php?pesquisa=&pagina=1#');
?>
