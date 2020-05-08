<?php unset($_COOKIE); ?>
<script>
function validarSenha(){
   NovaSenha = document.getElementById('senha').value;
   CNovaSenha = document.getElementById('conf_senha').value;
   if (NovaSenha != CNovaSenha) {
      alert("SENHAS DIFERENTES!\nFAVOR DIGITAR SENHAS IGUAIS");
      return false;
   }else{
      document.FormSenha.submit();

   }
}
</script>

<!doctype html>
<html>
    <head>
      <meta charset="utf-8">
      <title>Login | Ateliê dos estofados</title>
  		<!--<meta http-equiv="X-Frame-Options" content="deny"> -->
  		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
  		<meta name="description" content="TAPECARIA" />
  	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

    </head>

    <body width="789" border="0" align="center" cellpadding="0" cellspacing="0">

        <h1> Login</h1>

        <form class="well" action="./arquivos_de_login/login.php" method="post">
            <label for="user">usuario: </label>
            <br>
            <input type="text" style="text-transform:uppercase" name="usuario" id="usuario" required>

            <br><br>

            <label for="password">Senha: </label>
            <br>
            <input type="password" name="password" id="password" required>

            <br><br>

            <input type="submit" class="btn btn-info btn-lg" value="Entrar">
			      <br><br>


        <div class="container">
  <!-- Trigger the modal with a button -->
  <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#redefine_login_Modal">Esqueci a Senha</button>
  </form>



  <!-- MODAL CRIA LOGIN funcionario INICIO -->
    <div class="modal fade" id="redefine_login_Modal" tabindex="-1" role="dialog" aria-labelledby="redefine_login_ModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="redefine_login_ModalLabel">LINK PARA REDEFINIR SENHA</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
              <span aria-hidden="true">&times;</span>
          </div>
          <div class="modal-body">
            <form method="POST" action="./arquivos_de_login/redefine.php">

              <div class="form-group">
                <label class="control-label">E-MAIL:</label>
                <input name="email" style="text-transform:uppercase" class="form-control" id="email">
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger" onclick="return validarSenha()">ENVIAR LINK</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  <!-- MODAL CRIA LOGIN funcionario FIM -->
    </body>
</html>
