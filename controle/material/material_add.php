<?php
include '../../conexao/banco.php';

//tabela material
$nome1 = mysqli_real_escape_string($conn, $_POST['nome_mat']);
$nome = strtoupper($nome1);

$tipo1 = mysqli_real_escape_string($conn, $_POST['tipo']);
$tipo = strtoupper($tipo1);

$uni_medida1 = mysqli_real_escape_string($conn, $_POST['uni_medida']);
$uni_medida = strtoupper($uni_medida1);

$quantidade1 = mysqli_real_escape_string($conn, $_POST['quantidade']);
$quantidade = strtoupper($quantidade1);

$adiciona_material = "INSERT INTO material (nome_mat, tipo, uni_medida, quantidade) VALUES ('$nome', '$tipo', '$uni_medida', '$quantidade')";
$adiciona_mat = mysqli_query($conn, $adiciona_material)or die( mysqli_error($conn));

//var_dump($_POST['nome']);

mysqli_close($conn);
header('Location: ../../materiais.php?pesquisa=&pagina=1#');
?>
