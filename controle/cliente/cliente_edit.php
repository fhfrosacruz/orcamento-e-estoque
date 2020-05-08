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

//tabela pessoa
$id = mysqli_real_escape_string($conn, $_POST['id']);

$nome1 = mysqli_real_escape_string($conn, $_POST['nome']);
$nome = strtoupper($nome1);

$cpf = mysqli_real_escape_string($conn, $_POST['cpf']);

$nascimento = mysqli_real_escape_string($conn, $_POST['nasc']);

$email1 = mysqli_real_escape_string($conn, $_POST['email']);
$email = strtoupper($email1);

$telefone = mysqli_real_escape_string($conn, $_POST['telefone']);

$endereco_id = mysqli_real_escape_string($conn, $_POST['endereco_id']); // inner join com a tabela endereço

$atualiza_endereco = "UPDATE endereco SET id_endereco='$endereco_id',rua='$rua',numero='$numero',complemento='$complemento',cep='$cep',bairro='$bairro',cidade='$cidade', estado ='$estado' WHERE id_endereco = '$endereco_id'";
$atualiza_end = mysqli_query($conn, $atualiza_endereco);

$atualiza_pessoa = "UPDATE pessoa SET id_pessoa = '$id', nome = '$nome', cpf = '$cpf', data_nasc = '$nascimento', email = '$email', telefone = '$telefone', endereco_id = '$endereco_id' WHERE id_pessoa = '$id'";
$atualiza = mysqli_query($conn, $atualiza_pessoa);

//var_dump($atualiza_pessoa);

mysqli_close($conn);
header('Location: ../../clientes.php?pesquisa=&pagina=1#');
?>
