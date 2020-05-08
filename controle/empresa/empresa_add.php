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
$adiciona_end = mysqli_query($conn, $adiciona_endereco) or die( mysqli_error($conn));
$endereco_id = mysqli_insert_id($conn);//pega o id_endereco do que foi adicionado

//tabela empresa
$razao_social1 = mysqli_real_escape_string($conn, $_POST['razao_social']);
$razao_social = strtoupper($razao_social1);

$nome_fantasia1 = mysqli_real_escape_string($conn, $_POST['nome_fantasia']);
$nome_fantasia = strtoupper($nome_fantasia1);

$cnpj = mysqli_real_escape_string($conn, $_POST['cnpj']);

$telefone = mysqli_real_escape_string($conn, $_POST['telefone']);

$responsavel1 = mysqli_real_escape_string($conn, $_POST['responsavel']);
$responsavel = strtoupper($responsavel1);

$website1 = mysqli_real_escape_string($conn, $_POST['website']);
$website = strtoupper($website1);

$email1 = mysqli_real_escape_string($conn, $_POST['email']);
$email = strtoupper($email1);

$detalhes1 = mysqli_real_escape_string($conn, $_POST['detalhes']);
$detalhes = strtoupper($detalhes1);


$adiciona_empresa = "INSERT INTO empresa (razao_social, nome_fantasia, cnpj, telefone, responsavel, website, email, detalhes, endereco_id) VALUES ('$razao_social', '$nome_fantasia', '$cnpj', '$telefone', '$responsavel', '$website', '$email', '$detalhes', '$endereco_id')";
$adiciona_emp = mysqli_query($conn, $adiciona_empresa) or die( mysqli_error($conn));

mysqli_close($conn);
header('Location: ../../empresas.php?pesquisa=&pagina=1#');
?>
