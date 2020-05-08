<?php

// inclui o arquivo de inicialização
require 'init.php';

// resgata variáveis do formulário
$usuario = isset($_POST['usuario']) ? $_POST['usuario'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
/*
if (empty($usuario) || empty($password))
{
  echo"<script type=\"text/javascript\">alert('Informe o Usuário e Senha'); window.location='form-login.php';</script>";
    exit;
}
*/
// cria o hash da senha
$passwordHash = make_hash($password);

//echo ($passwordHash);


$PDO = db_connect();

$sql = "SELECT * FROM login WHERE usuario = :usuario AND senha = :password";
$stmt = $PDO->prepare($sql);

$stmt->bindParam(':usuario', $usuario);
$stmt->bindParam(':password', $passwordHash);

$stmt->execute();

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
//var_dump($users);

if (count($users) <= 0)
{

   echo"<script type=\"text/javascript\">alert('Usuario ou senha estão errados'); window.location='../index.php';</script>";

    exit;
}

// pega o primeiro usuário
$user = $users[0];

if ($user['nivel'] == '0'){  // gerente
session_start();
$_SESSION['logged_in'] = true;
$_SESSION['user_id'] = $user['id'];
$_SESSION['user_name'] = $user['usuario'];
$_SESSION['user_nivel'] = $user['nivel'];
$_SESSION['user_funcionario_id'] = $user['funcionario_id'];

header('Location: ../inicial.php');
}else{ //funcionario
  session_start();
  $_SESSION['logged_in'] = true;
  $_SESSION['user_id'] = $user['id'];
  $_SESSION['user_name'] = $user['usuario'];
  $_SESSION['user_nivel'] = $user['nivel'];
  $_SESSION['user_funcionario_id'] = $user['funcionario_id'];
header('Location: ../inicial.php');
}
