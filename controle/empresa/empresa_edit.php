<?php
include '../../conexao/banco.php';

//tabela endereço
$endereco_id = mysqli_real_escape_string($conn, $_POST['endereco_id']); // inner join com a tabela endereço

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

//tabela empresa
$id_empresa = mysqli_real_escape_string($conn, $_POST['id']);

$razao_social1 = mysqli_real_escape_string($conn, $_POST['razao_social']);
$razao_social = strtoupper($razao_social1);

$nome_fantasia1 = mysqli_real_escape_string($conn, $_POST['nome_fantasia']);
$nome_fantasia = strtoupper($nome_fantasia1);

$cnpj1 = mysqli_real_escape_string($conn, $_POST['cnpj']);


$telefone = mysqli_real_escape_string($conn, $_POST['telefone']);

$responsavel1 = mysqli_real_escape_string($conn, $_POST['responsavel']);
$responsavel = strtoupper($responsavel1);

$website1 = mysqli_real_escape_string($conn, $_POST['website']);
$website = strtoupper($website1);

$email1 = mysqli_real_escape_string($conn, $_POST['email']);
$email = strtoupper($email1);

$detalhes1 = mysqli_real_escape_string($conn, $_POST['detalhes']);
$detalhes = strtoupper($detalhes1);

$atualiza_endereco = "UPDATE endereco SET id_endereco='$endereco_id',rua='$rua',numero='$numero',complemento='$complemento',cep='$cep',bairro='$bairro',cidade='$cidade', estado ='$estado' WHERE id_endereco = '$endereco_id'";
$atualiza_end = mysqli_query($conn, $atualiza_endereco) or die( mysqli_error($conn));

$atualiza_empresa = "UPDATE empresa SET id_empresa = '$id_empresa', razao_social = '$razao_social', nome_fantasia = '$nome_fantasia', cnpj = '$cnpj', telefone = '$telefone', responsavel = '$responsavel', website = '$website', email = '$email', detalhes = '$detalhes'  WHERE id_empresa = '$id_empresa'";
$atualiza = mysqli_query($conn, $atualiza_empresa) or die( mysqli_error($conn));



mysqli_close($conn);
header('Location: ../../empresas.php?pesquisa=&pagina=1#');
?>
