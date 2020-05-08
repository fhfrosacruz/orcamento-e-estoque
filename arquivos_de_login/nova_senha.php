<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Redefinição de senha</title>
  </head>
  <body>
    <h1>REDEFINA SUA SENHA</h1>
    <h4>Preencha os campos para redefinir a nova senha</h4>
    <form class="" action="./redefine_senha.php" method="post">
      <div class="form-group">
        <label class="control-label">CPF:</label>
        <br>
        <input size="11" autocomplete="off" maxlength="11" onKeyPress="return Apenas_Numeros(event);" required name="cpf" class="form-control" id="cpf">
      </div>
      <br>
      <div class="form-group">
        <label class="control-label">NOVA SENHA:</label>
        <br>
        <input type="password" required name="senha" class="form-control" id="senha">
      </div>
      <br>
      <div class="form-group">
        <label class="control-label">CONFIRMA NOVA SENHA:</label>
        <br>
        <input type="password" required name="conf_senha" class="form-control" id="conf_senha">
      </div>
      <br>
      <button type="submit" name="button">Redefinir</button>

    </form>

     <script type="text/javascript">
     function Apenas_Numeros(caracter)
     {
       var nTecla = 0;
       if (document.all) {
         nTecla = caracter.keyCode;
       } else {
         nTecla = caracter.which;
       }
       if ((nTecla> 47 && nTecla <58)
       || nTecla == 8 || nTecla == 127
       || nTecla == 0 || nTecla == 9  // 0 == Tab
       || nTecla == 13) { // 13 == Enter
         return true;
       } else {
         return false;
       }
     }
     </script>
  </body>
</html>
