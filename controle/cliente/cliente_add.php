<?php
include '../../conexao/banco.php';

//tabela endereço
$rua1 = mysqli_real_escape_string($conn, $_POST['rua']);
$rua = strtoupper($rua1);

$numero1 = mysqli_real_escape_string($conn, $_POST['numero']);
$numero = strtoupper($numero1);

$complemento1 = mysqli_real_escape_string($conn, $_POST['complemento']);
$complemento = strtoupper($complemento1);

$cep = mysqli_real_escape_string($conn, $_POST['cep']);

$bairro1 = mysqli_real_escape_string($conn, $_POST['bairro']);
$bairro = strtoupper($bairro1);

$cidade1 = mysqli_real_escape_string($conn, $_POST['cidade']);
$cidade = strtoupper($cidade1);

$estado1 = mysqli_real_escape_string($conn, $_POST['estado']);
$estado = strtoupper($estado1);

$adiciona_endereco = "INSERT INTO endereco (rua, numero, complemento, cep, bairro, cidade, estado) VALUES ('$rua', '$numero', '$complemento', '$cep', '$bairro', '$cidade', '$estado')";
$adiciona_end = mysqli_query($conn, $adiciona_endereco)or die( mysqli_error($conn));
$pega_id = mysqli_insert_id($conn);//pega o id_endereco do que foi adicionado

//tabela pessoa
$id = mysqli_real_escape_string($conn, $_POST['id']);

$nome1 = mysqli_real_escape_string($conn, $_POST['nome']);
$nome = strtoupper($nome1);

$cpf = mysqli_real_escape_string($conn, $_POST['cpf']);

$nascimento = mysqli_real_escape_string($conn, $_POST['nasc']);

$email1 = mysqli_real_escape_string($conn, $_POST['email']);
$email = strtoupper($email1);

$telefone = mysqli_real_escape_string($conn, $_POST['telefone']);

$endereco_id = mysqli_real_escape_string($conn, $pega_id); // pega o id_endereco da tabela endereço

$adiciona_cliente = "INSERT INTO pessoa (nome, cpf, data_nasc, email, telefone, endereco_id) VALUES ('$nome', '$cpf', '$nascimento', '$email', '$telefone', '$endereco_id')";
$adiciona = mysqli_query($conn, $adiciona_cliente)or die( mysqli_error($conn));

mysqli_close($conn);
header('Location: ../../clientes.php?pesquisa=&pagina=1#');
?>
