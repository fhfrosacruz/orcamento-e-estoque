<?php
include '../../conexao/banco.php';


//tabela login

$usuario1 = mysqli_real_escape_string($conn, $_POST['usuario']);
$usuario = strtoupper($usuario1);
$senha = mysqli_real_escape_string($conn, $_POST['senha']);
$confirma = mysqli_real_escape_string($conn, $_POST['confirma']);
$nivel = mysqli_real_escape_string($conn, $_POST['nivel']);

$adiciona_cliente = "INSERT INTO pessoa (nome, cpf, data_nasc, email, telefone, endereco_id) VALUES ('$nome', '$cpf', '$nascimento', '$email', '$telefone', '$endereco_id')";
$adiciona = mysqli_query($conn, $adiciona_cliente);


mysqli_close($conn);
header('Location: ../../funcionarios.php?pesquisa=&pagina=1#');
?>
