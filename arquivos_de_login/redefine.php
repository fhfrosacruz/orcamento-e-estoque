<?php
require_once('class.phpmailer.php'); //chama a classe de onde você a colocou.
require_once('class.smtp.php');
require 'init.php';


$email = $_POST['email'];


$PDO = db_connect();

$sql = "SELECT email FROM pessoa WHERE email = :email";
$stmt = $PDO->prepare($sql);

$stmt->bindParam(':email', $email);

$stmt->execute();

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($users) > 0){

$mail = new PHPMailer(); // instancia a classe PHPMailer

$mail->IsSMTP();

//configuração do gmail
$mail->Port = '465'; //porta usada pelo gmail.
$mail->Host = 'smtp.gmail.com';
$mail->IsHTML(true);
$mail->Mailer = 'smtp';
$mail->SMTPSecure = 'ssl';

//configuração do usuário do gmail
$mail->SMTPAuth = true;
$mail->Username = ''; // usuario gmail, seu e-mail.
$mail->Password = ''; // senha do email.

$mail->SingleTo = true;

// configuração do email a ver enviado.
$mail->CharSet = "UTF-8";
$mail->From = "Link para redefinir a senha.";
$mail->FromName = "Ateliê dos estofados.";

$mail->addAddress($email); // email do destinatario.

$mail->Subject = "Redefinição de senha";
$mail->Body = "<a href=http://localhost/tcc/arquivos_de_login/nova_senha.php> Clique aqui para redefinir a senha</a>";

if(!$mail->Send()){
    echo "Erro ao enviar Email:" . $mail->ErrorInfo;
}else {
    echo "<script type=\"text/javascript\">alert('EMAIL ENVIADO COM SUCESSO'); window.location='../index.php';</script>";
}
}else {
  echo "<script type=\"text/javascript\">alert('email não cadastrado'); window.location='../index.php';</script>";
}
?>
