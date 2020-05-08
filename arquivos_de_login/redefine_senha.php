<?php
require '../conexao/banco.php';

@$cpf=$_POST['cpf'];
@$senha=$_POST['senha'];
@$conf_senha=$_POST['conf_senha'];
if ($senha != $conf_senha) {
    echo "<script type=\"text/javascript\">alert('AS SENHAS NÃO CONFEREM');</script>";
    $cpf = '';
    $senha = '';
    $conf_senha = '';
}

$veri = "SELECT id_funcionario FROM pessoa p LEFT JOIN funcionario f ON f.pessoa_id = p.id_pessoa AND p.cpf = '$cpf' WHERE f.id_funcionario IS NOT NULL";
$veri_con = mysqli_query($conn, $veri);
$users = mysqli_fetch_assoc($veri_con);

if (@count($users) != 1)
{
   echo"<script type=\"text/javascript\">alert('CPF errado ou não cadastrado'); window.location='./nova_senha.php';</script>";
   $cpf = '';
   $senha = '';
   $conf_senha = '';
}else {
  function make_hash($str)
  {
      return md5($str);

    // return sha1(md5($str)); pega o hash MD5 e criptografa novamento com o SHA-1
  }
  $password = make_hash($senha);

  $muda= "UPDATE login SET senha='$password' WHERE funcionario_id = '$users[id_funcionario]'";
  $muda_senha = mysqli_query($conn, $muda);
  $cpf = '';
  $senha = '';
  $conf_senha = '';
  echo"<script type=\"text/javascript\">alert('Senha alterada com sucesso'); window.location='../index.php';</script>";
}

//var_dump($users);
//echo $users['id_funcionario'];

 ?>
