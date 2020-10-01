<?php
$title = "Ateliê dos Estofados Bem Vindo";
include 'header.php';                 // (2) Include the header
require './conexao/banco.php';

?>
<style media="screen">
#sofa {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
  text-align: center;
}

</style>



<div>
  <h1 style="text-align: center;">ORÇAMENTO PARA AUTOMOVEIS</h1>
</div>

<div class="container" style="text-align: center;">

<form action="./controle/gera_orc/gera_automoveis.php" method="post">

<div style="text-align: center;">
  <table>
  <tr>
    <td>
      <div id="esconder_cli" display:none; nome="esconder_cli">
        <label class="control-label">CLIENTE:</label>
        <select name="cliente_orca" class="form-control" id="cliente_orca" onclick="Mudarestado_emp('esconder_emp')">
          <option value=""></option>
          <?php
          $sql = "SELECT * FROM pessoa p LEFT JOIN funcionario f ON f.pessoa_id = p.id_pessoa WHERE f.id_funcionario IS NULL";
          $result_sql = mysqli_query($conn, $sql);

          while ($cliente_orca = mysqli_fetch_array($result_sql)) {?>
            <option value="<?php echo $cliente_orca['nome']; ?>"><?php echo $cliente_orca['nome']; ?></option><?php
          }
          ?>
        </select>
      </div>
    </td>
   <td>
      <div id="esconder_emp" display:none; nome="esconder_emp">
        <label class="control-label">EMPRESA:</label>
        <select name="empresa_orca" class="form-control" id="empresa_orca" onclick="Mudarestado_cli('esconder_cli')">
          <option value=""></option>
          <?php
          $sql = "SELECT * FROM empresa";
          $result_sql = mysqli_query($conn, $sql);

          while ($empresa_orca = mysqli_fetch_array($result_sql)) {?>
            <option value="<?php echo $empresa_orca['razao_social']; ?>"><?php echo $empresa_orca['razao_social']; ?></option><?php
          }
          ?>
        </select>
      </div>
    </td>
    <td>

    <select hidden name="tipo_orca" class="form-control" id="tipo_orca">
      <option value="AUTOMOVEL">AUTOMOVEL</option>

    </select>
    </td>
  </tr>
  </table>

<table class="table-sm" id="sofa">

  <tr>
    <td class="table-primary">
      <label class="control-label">ASSENTOS:</label>
      <select name="assento" class="form-control" id="assento">
        <option value="">0 ASSENTO</option>
        <option value="1">1 ASSENTO</option>
        <option value="2">2 ASSENTOS</option>
        <option value="3">3 ASSENTOS</option>
        <option value="4">4 ASSENTOS</option>
        <option value="outro">OUTRO</option>
      </select>
      <div id="outros_assentos" style="display:none;">
        <label>MAIS</label>
        <input type="number" min="5" id="outros_assentos" name="outros_assentos">
      </div>
    </td>
    <td class="table-primary">
      <div id="medidas_assentos" style="text-align: right; display:none;">
      <label>MEDIDAS:</label><br>
      <label>altura:</label>
      <input style="width: 30%;" type="number" onKeyPress="return Apenas_Numeros(event);" name="altura_ace" id="altura_ace" placeholder="CENTIMETRO"><br>
      <label>largura:</label>
      <input style="width: 30%;" min="50" type="number" onKeyPress="return Apenas_Numeros(event);" name="largura_ace" id="largura_ace" placeholder="CENTIMETRO"><br>
      <label>comprimento:</label>
      <input style="width: 30%;" min="50" type="number" onKeyPress="return Apenas_Numeros(event);" name="profundidade_ace" id="profundidade_ace" placeholder="CENTIMETRO">
      </div>
    </td>
    <td class="table-primary">
      <label class="control-label">TECIDO ASSENTOS:</label>
      <select name="tecido_assento" class="form-control" id="tecido_assento">
        <option value="">SEM TECIDO</option>
        <?php
        $sql = "SELECT DISTINCT id_material, nome_mat FROM material WHERE TIPO = 'TECIDO'";
        $result_sql = mysqli_query($conn, $sql);

        while ($tecido = mysqli_fetch_array($result_sql)) {?>
          <option value="<?php echo $tecido['id_material']; ?>"><?php echo $tecido['nome_mat']; ?></option><?php
        }
        ?>
      </select>
    </td>
    <td class="table-primary" id="seguraca_assentos" style="text-align: right; display:none;">
        <label>margen de segurança:</label>
        <select name="medida_seg_ass" class="form-control" id="medida_seg_ass">
          <option value="">SEM MARGEM</option>
          <option value="0.5" selected>0,5 METROS</option>
          <option value="1">1 METRO</option>
          <option value="1.5">1,5 METRO</option>
          <option value="2">2 METROS</option>
          <option value="2.5">2,5 METROS</option>
          <option value="3">3 METROS</option>
          <option value="3.5">3,5 METROS</option>
        </select>
    </td>
    <td class="table-primary">
      <label class="control-label">ENCHIMENTO ASSENTOS:</label>
      <select name="enchimento_assento" class="form-control" id="enchimento_assento">
        <option value="">NÃO</option>
        <?php
        $sql = "SELECT DISTINCT id_material, nome_mat FROM material WHERE TIPO = 'ESPUMA' || TIPO = 'RETALHO'";
        $result_sql = mysqli_query($conn, $sql);

        while ($tecido = mysqli_fetch_array($result_sql)) {?>
          <option value="<?php echo $tecido['id_material']; ?>"><?php echo $tecido['nome_mat']; ?></option><?php
        }
        ?>
      </select>
    </td>
    <td class="table-danger">
      <button type="submit" formtarget="_blank" onclick="return verifica_dados();" name="button" id="button">GERAR ORÇAMENTO</button>

    </td>
  </tr>

  <tr>
    <td class="table-warning">
      <label class="control-label">ENCOSTO:</label>
      <select name="encosto" class="form-control" id="encosto">
        <option value="">0 ENCOSTO</option>
        <option value="1">1 ENCOSTO</option>
        <option value="2">2 ENCOSTOS</option>
        <option value="3">3 ENCOSTOS</option>
        <option value="4">4 ENCOSTOS</option>
        <option value="outro">OUTRO</option>
      </select>
      <div id="outros_encostos" style="display:none;">
        <label>MAIS</label>
        <input type="number" min="5" id="outros_encostos" name="outros_encostos">
      </div>
    </td>
    <td class="table-warning">
        <div id="medidas_encostos" style="text-align: right; display:none;">
        <label>MEDIDAS:</label><br>
        <label>altura:</label>
        <input style="width: 30%;" type="number" onKeyPress="return Apenas_Numeros(event);" name="altura_enc" id="altura_enc" placeholder="CENTIMETRO"><br>
        <label>largura:</label>
        <input style="width: 30%;" min="50" type="number" onKeyPress="return Apenas_Numeros(event);" name="largura_enc" id="largura_enc" placeholder="CENTIMETRO"><br>
        <label>comprimento:</label>
        <input style="width: 30%;" min="50" type="number" onKeyPress="return Apenas_Numeros(event);" name="profundidade_enc" id="profundidade_enc" placeholder="CENTIMETRO">
        </div>
    </td>
    <td class="table-warning">
      <label class="control-label">TECIDO ENCOSTO:</label>
      <select name="tecido_encosto" class="form-control" id="tecido_encosto">
        <option value="">SEM TECIDO</option>
        <?php
        $sql = "SELECT DISTINCT id_material, nome_mat FROM material WHERE TIPO = 'TECIDO'";
        $result_sql = mysqli_query($conn, $sql);

        while ($tecido = mysqli_fetch_array($result_sql)) {?>
          <option value="<?php echo $tecido['id_material']; ?>"><?php echo $tecido['nome_mat']; ?></option><?php
        }
        ?>
      </select>
    </td>
    <td class="table-warning" id="seguraca_encostos" style="text-align: right; display:none;">
      <div>
        <label>margen de segurança:</label>
        <select name="medida_seg_enc" class="form-control" id="medida_seg_enc">
          <option value="">SEM MARGEM</option>
          <option value="0.5" selected>0,5 METROS</option>
          <option value="1">1 METRO</option>
          <option value="1.5">1,5 METRO</option>
          <option value="2">2 METROS</option>
          <option value="2.5">2,5 METROS</option>
          <option value="3">3 METROS</option>
          <option value="3.5">3,5 METROS</option>
        </select>
        </div>
    </td>
    <td class="table-warning">
      <label class="control-label">ENCHIMENTO ENCOSTO:</label>
      <select name="enchimento_encosto" class="form-control" id="enchimento_encosto">
        <option value="">NÃO</option>
        <?php
        $sql = "SELECT DISTINCT id_material, nome_mat FROM material WHERE TIPO = 'ESPUMA' || TIPO = 'RETALHO'";
        $result_sql = mysqli_query($conn, $sql);

        while ($tecido = mysqli_fetch_array($result_sql)) {?>
          <option value="<?php echo $tecido['id_material']; ?>"><?php echo $tecido['nome_mat']; ?></option><?php
        }
        ?>
      </select>
    </td>
    <td class="table-success">
      <div style="text-align: center;">
        <label>MÃO DE OBRA:</label><br>
      R$<input required style="width: 20%;" onKeyPress="return Apenas_Numeros(event);" type="text" id="mao_obra" name="mao_obra" value="" >,00
    </div>
    </td>
  </tr>

  <tr class="table-secondary">
  <td>
    <div id="medidas_teto" style="text-align: center; width: 130%;">
    <label>MEDIDAS DO TETO:</label><br>
    <label>comprimento:</label>
    <input style="width: 30%;" type="number" min="1" max="6" onKeyPress="return Apenas_Numeros(event);" name="comprimento_teto" id="comprimento_teto" placeholder="METRO">
    <label>largura:</label>
    <input style="width: 30%;" type="number" min="1" max="6" onKeyPress="return Apenas_Numeros(event);" name="largura_teto" id="largura_teto" placeholder="METRO">
    </div>
  </td>
  <td>
    <td>

  </td>
</td>
  <td>
    <label>TECIDO TETO:</label>
    <select name="tecido_teto" class="form-control" id="tecido_teto">
      <option value="">SEM TECIDO</option>
      <?php
      $sql = "SELECT DISTINCT id_material, nome_mat FROM material WHERE TIPO = 'TECIDO'";
      $result_sql = mysqli_query($conn, $sql);

      while ($tecido = mysqli_fetch_array($result_sql)) {?>
        <option value="<?php echo $tecido['id_material']; ?>"><?php echo $tecido['nome_mat']; ?></option><?php
      }
      ?>
    </select>
  </td>
  <td class="table-warning" id="seguranca_teto" style="text-align: right; display:none;">
    <div>
      <label>margen de segurança:</label>
      <select name="mar_seg_teto" class="form-control" id="mar_seg_teto">
        <option value="">SEM MARGEM</option>
        <option value="0.5" selected>0,5 METROS</option>
        <option value="1">1 METRO</option>
        <option value="1.5">1,5 METRO</option>
        <option value="2">2 METROS</option>
        <option value="2.5">2,5 METROS</option>
        <option value="3">3 METROS</option>
        <option value="3.5">3,5 METROS</option>
      </select>
      </div>
  </td>
  </tr>
  <tr class="table-secondary">
    <td>
      <div id="medidas_piso" style="text-align: center; width: 130%;">
      <label>MEDIDAS DO PISO:</label><br>
      <label>comprimento:</label>
      <input style="width: 30%;" type="number" min="1" max="6" onKeyPress="return Apenas_Numeros(event);" name="comprimento_piso" id="comprimento_piso" placeholder="METRO">
      <label>largura:</label>
      <input style="width: 30%;" type="number" min="1" max="6" onKeyPress="return Apenas_Numeros(event);" name="largura_piso" id="largura_piso" placeholder="METRO">
      </div>
    </td>
    <td>
    </td>
    <td>
    </td>
    <td>
      <label>TECIDO PISO:</label>
      <select name="tecido_piso" class="form-control" id="tecido_piso">
        <option value="">SEM TECIDO</option>
        <?php
        $sql = "SELECT DISTINCT id_material, nome_mat FROM material WHERE TIPO = 'TECIDO'";
        $result_sql = mysqli_query($conn, $sql);

        while ($tecido = mysqli_fetch_array($result_sql)) {?>
          <option value="<?php echo $tecido['id_material']; ?>"><?php echo $tecido['nome_mat']; ?></option><?php
        }
        ?>
      </select>
    </td>
    <td class="table-warning" id="seguranca_piso" style="text-align: right; display:none;">
      <div>
        <label>margen de segurança:</label>
        <select name="mar_seg_piso" class="form-control" id="mar_seg_piso">
          <option value="">SEM MARGEM</option>
          <option value="0.5" selected>0,5 METROS</option>
          <option value="1">1 METRO</option>
          <option value="1.5">1,5 METRO</option>
          <option value="2">2 METROS</option>
          <option value="2.5">2,5 METROS</option>
          <option value="3">3 METROS</option>
          <option value="3.5">3,5 METROS</option>
        </select>
        </div>
    </td>
  </tr>
</table>
</form>
</div>

<script>

// inicio assento -->
 $("#tecido_assento").change(function() {
    $('#seguraca_assentos').hide();
    if(this.value != "")
      $('#seguraca_assentos').show();

 });
 $("#assento_botao").change(function() {
    $('#qto_assento').hide();
    if(this.value != "")
      $('#qto_assento').show();

 });
 $("#assento").change(function() {
    $('#outros_assentos').hide();
    if(this.value == "outro")
      $('#outros_assentos').show();

 });
 $("#assento").change(function() {
    $('#medidas_assentos').hide();
    if(this.value != "")
      $('#medidas_assentos').show();

 });

// fim assento 


// inicio encosto -->
$("#tecido_encosto").change(function() {
   $('#seguraca_encostos').hide();
   if(this.value != "")
     $('#seguraca_encostos').show();

});
 $("#encosto_botao").change(function() {
    $('#qto_encosto').hide();
    if(this.value != "")
      $('#qto_encosto').show();

 });
 $("#encosto").change(function() {
    $('#outros_encostos').hide();
    if(this.value == "outro")
      $('#outros_encostos').show();

 });
 $("#encosto").change(function() {
    $('#medidas_encostos').hide();
    if(this.value != "")
      $('#medidas_encostos').show();

 });

 // fim encosto -->

// inicio teto -->
 $("#tecido_teto").change(function() {
    $('#seguranca_teto').hide();
    if(this.value != "")
      $('#seguranca_teto').show();

 });

// fim teto -->

// inicio piso -->
 $("#tecido_piso").change(function() {
    $('#seguranca_piso').hide();
    if(this.value != "")
      $('#seguranca_piso').show();

 });

// fim piso

//funções para esconder um ou outro tipo de cliente, para se gerar um orçamento, por o orçamento é gerado para um cliente ou uma empresa

function Mudarestado_emp(el) { //esconde a empresa
        var x = document.getElementById('cliente_orca').value;
               
       
        if(x == "")
            document.getElementById(el).style.display = 'block';
        else
            document.getElementById(el).style.display = 'none';        
    }

    function Mudarestado_cli(el) { //esconde o cliente
        
        var y = document.getElementById('empresa_orca').value;       
        
        if(y == "")
            document.getElementById(el).style.display = 'block';
        else
            document.getElementById(el).style.display = 'none';        
    }

</script>


<?php
include 'footer.php'
?>
