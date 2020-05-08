<?php
session_start();
require_once 'init.php';
require_once 'functions.php';
require_once 'check_login.php';

$nome = $_POST['nome'];
$nivel = $_POST['cargo_log'];
$usuario1 = $_POST['usuario'];
$usuario = strtoupper($usuario1);
$senha = $_POST['senha'];
$confirma = $_POST['conf_senha'];


if ($senha == $confirma){

  $PDO = db_connect();

  $sql = "SELECT usuario FROM login WHERE usuario = :usuario ";
  $stmt = $PDO->prepare($sql);
  $stmt->bindParam(':usuario', $usuario);
  $stmt->execute();
  $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if (count($users) == 0)
  {
    // cria o hash da senha
    $passwordHash = make_hash($senha);

    $PDO = db_connect();
    $sql = "INSERT INTO `login`(`usuario`, `senha`, `nivel`, `funcionario_id`) VALUES ('$usuario', '$passwordHash', '$nivel', '$nome') ";
    $stmt = $PDO->prepare($sql);
    $stmt->execute();
    //echo $sql;

    echo"<script type=\"text/javascript\">alert('Seu Usuario foi criado com sucesso'); window.location='../funcionarios.php';</script>";
  }else{

    echo"<script type=\"text/javascript\">alert('Usuario ja existe, crie um diferente'); window.location='../funcionarios.php';</script>";
      exit;
    }

  }else {

    echo"<script type=\"text/javascript\">alert('As senhas não são iguais'); window.location='../funcionarios.php';</script>";
  }

  ?>
