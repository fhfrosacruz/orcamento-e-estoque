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
  <h1 style="text-align: center;">ORÇAMENTO PARA ESTOFADOS</h1>
</div>

<div class="container" style="text-align: center;">

<form action="./controle/gera_orc/gera_estofados.php" method="post">

<div style="text-align: center;">
  <table>
  <tr>
    <td>
    <label class="control-label">CLIENTE:</label>
    <select name="cliente_orca" class="form-control" id="cliente_orca">
      <option value=""></option>
      <?php
      $sql = "SELECT * FROM pessoa p LEFT JOIN funcionario f ON f.pessoa_id = p.id_pessoa WHERE f.id_funcionario IS NULL";
      $result_sql = mysqli_query($conn, $sql);

      while ($cliente_orca = mysqli_fetch_array($result_sql)) {?>
        <option value="<?php echo $cliente_orca['nome']; ?>"><?php echo $cliente_orca['nome']; ?></option><?php
      }
      ?>
    </select>
    </td>
  <td>
    <label class="control-label">EMPRESA:</label>
    <select name="empresa_orca" class="form-control" id="empresa_orca">
      <option value=""></option>
      <?php
      $sql = "SELECT * FROM empresa";
      $result_sql = mysqli_query($conn, $sql);

      while ($empresa_orca = mysqli_fetch_array($result_sql)) {?>
        <option value="<?php echo $empresa_orca['razao_social']; ?>"><?php echo $empresa_orca['razao_social']; ?></option><?php
      }
      ?>
    </select>
    </td>
    <td>
    <label class="control-label">TIPO:</label>
    <select name="tipo_orca" class="form-control" id="tipo_orca">
      <option value="SOFA">SOFÁ</option>
      <option value="CADEIRA">CADEIRA</option>
      <option value="BANCO">BANCO</option>
      <option value="COLCHÃO">COLCHÃO</option>
      <option value="OUTRO">OUTRO</option>

    </select>
    </td>
  </tr>
  </table>

<table class="table-sm" id="sofa">

  <tr class="table-primary">
    <td>
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
    <td>
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
    <td>
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
    <td id="seguraca_assentos" style="text-align: right; display:none;">
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
    <td>
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
    <td>
      <label class="control-label">ZIPER:</label>
      <select name="assento_ziper" class="form-control" id="assento_ziper">
        <option value="">SEM ZÍPER</option>
        <?php
        $sql = "SELECT DISTINCT id_material, nome_mat FROM material WHERE TIPO = 'ZIPER' || TIPO = 'VELCRO'";
        $result_sql = mysqli_query($conn, $sql);

        while ($tecido = mysqli_fetch_array($result_sql)) {?>
          <option value="<?php echo $tecido['id_material']; ?>"><?php echo $tecido['nome_mat']; ?></option><?php
        }
        ?>
      </select>
    </td>
    <td>
      <label class="control-label">BOTÃO:</label>
      <select name="assento_botao" class="form-control" id="assento_botao">
        <option value="">SEM BOTÃO</option>
        <?php
        $sql = "SELECT DISTINCT id_material, nome_mat FROM material WHERE TIPO = 'BOTÃO'";
        $result_sql = mysqli_query($conn, $sql);

        while ($tecido = mysqli_fetch_array($result_sql)) {?>
          <option value="<?php echo $tecido['id_material']; ?>"><?php echo $tecido['nome_mat']; ?></option><?php
        }
        ?>
      </select>
      <div id="qto_assento" style="display:none;">
        <label>quantidade</label>
      <input style="width: 50%;" min="1" type="number" id="qto_botao_assento" name="qto_botao_assento">
    </div>
    </td>
  </tr>
  <br>
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
    <td class="table-warning">
      <label class="control-label">ZIPER:</label>
      <select name="encosto_ziper" class="form-control" id="encosto_ziper">
        <option value="">SEM ZÍPER</option>
        <?php
        $sql = "SELECT DISTINCT id_material, nome_mat FROM material WHERE TIPO = 'ZIPER' || TIPO = 'VELCRO'";
        $result_sql = mysqli_query($conn, $sql);

        while ($tecido = mysqli_fetch_array($result_sql)) {?>
          <option value="<?php echo $tecido['id_material']; ?>"><?php echo $tecido['nome_mat']; ?></option><?php
        }
        ?>
      </select>
    </td>
    <td class="table-warning">
      <label class="control-label">BOTÃO:</label>
      <select name="encosto_botao" class="form-control" id="encosto_botao">
        <option value="">SEM BOTÃO</option>
        <?php
        $sql = "SELECT DISTINCT id_material, nome_mat FROM material WHERE TIPO = 'BOTÃO'";
        $result_sql = mysqli_query($conn, $sql);

        while ($tecido = mysqli_fetch_array($result_sql)) {?>
          <option value="<?php echo $tecido['id_material']; ?>"><?php echo $tecido['nome_mat']; ?></option><?php
        }
        ?>
      </select>
      <div id="qto_encosto" style="display:none;">
        <label>quantidade</label>
      <input style="width: 50%;" min="1" type="number" id="qto_botao_encosto" name="qto_botao_encosto">
    </div>
    </td>
    <td class="table-danger">
      <button type="submit" formtarget="_blank" onclick="return verifica_dados();" name="button" id="button">GERAR ORÇAMENTO</button>
      <!-- <input type="checkbox" name="estoque" id="estoque"> -->
    </td>
  </tr>
  <br>
  <tr class="table-success">
    <td>
      <label class="control-label">ALMOFADA:</label>
      <select name="almofada" class="form-control" id="almofada">
        <option value="">0 ALMOFADA</option>
        <option value="1">1 ALMOFADA</option>
        <option value="2">2 ALMOFADAS</option>
        <option value="3">3 ALMOFADAS</option>
        <option value="4">4 ALMOFADAS</option>
        <option value="outro">OUTRO</option>
      </select>
      <div id="outros_almofadas" style="display:none;">
        <label>MAIS</label>
        <input type="number" min="5" id="outros_almofadas" name="outros_almofadas">
      </div>
    </td>
    <td>
      <div id="medidas_almofadas" style="text-align: right; display:none;">
      <label>MEDIDAS:</label><br>
      <label>altura:</label>
      <input style="width: 30%;" type="number" onKeyPress="return Apenas_Numeros(event);" name="altura_alm" id="altura_alm" placeholder="CENTIMETRO"><br>
      <label>largura:</label>
      <input style="width: 30%;" min="50" type="number" onKeyPress="return Apenas_Numeros(event);" name="largura_alm" id="largura_alm" placeholder="CENTIMETRO"><br>
      <label>comprimento:</label>
      <input style="width: 30%;" min="50" type="number" onKeyPress="return Apenas_Numeros(event);" name="profundidade_alm" id="profundidade_alm" placeholder="CENTIMETRO">
      </div>
    </td>
    <td>
      <label class="control-label">TECIDO ALMOFADA:</label>
      <select name="tecido_almofada" class="form-control" id="tecido_almofada">
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
    <td id="seguraca_almofadas" style="text-align: right; display:none;">

        <label>margen de segurança:</label>
        <select name="medida_seg_alm" class="form-control" id="medida_seg_alm">
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
    <td>
      <label class="control-label">ENCHIMENTO ALMOFADA:</label>
      <select name="enchimento_almofada" class="form-control" id="enchimento_almofada">
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
    <td>
      <label class="control-label">ZIPER:</label>
      <select name="almofada_ziper" class="form-control" id="almofada_ziper">
        <option value="">SEM ZÍPER</option>
        <?php
        $sql = "SELECT DISTINCT id_material, nome_mat FROM material WHERE TIPO = 'ZIPER' || TIPO = 'VELCRO'";
        $result_sql = mysqli_query($conn, $sql);

        while ($tecido = mysqli_fetch_array($result_sql)) {?>
          <option value="<?php echo $tecido['id_material']; ?>"><?php echo $tecido['nome_mat']; ?></option><?php
        }
        ?>
      </select>
    </td>
    <td>
      <label class="control-label">BOTÃO:</label>
      <select name="almofada_botao" class="form-control" id="almofada_botao">
        <option value="">SEM BOTÃO</option>
        <?php
        $sql = "SELECT DISTINCT id_material, nome_mat FROM material WHERE TIPO = 'BOTÃO'";
        $result_sql = mysqli_query($conn, $sql);

        while ($tecido = mysqli_fetch_array($result_sql)) {?>
          <option value="<?php echo $tecido['id_material']; ?>"><?php echo $tecido['nome_mat']; ?></option><?php
        }
        ?>
      </select>
      <div id="qto_almofada" style="display:none;">
        <label>quantidade</label>
      <input style="width: 50%;" min="1" type="number" id="qto_botao_almofada" name="qto_botao_almofada">
    </div>
    </td>
    <td>
      <div style="text-align: center;">
        <label>MÃO DE OBRA:</label><br>
      R$<input required style="width: 20%;" onKeyPress="return Apenas_Numeros(event);" type="text" id="mao_obra" name="mao_obra" value="" >,00
    </div>
    </td>
  </tr>
  <tr class="table-secondary">
    <td>
      <td>
        <td>
    <label class="control-label">ESTRUTURA:</label>
    <select name="estrutura" class="form-control" id="estrutura">
      <option value="">NÃO</option>
      <?php
      $sql = "SELECT DISTINCT id_material, nome_mat FROM material WHERE TIPO = 'MADEIRA' || TIPO = 'RIPA' || TIPO = 'SARRAFO'";
      $result_sql = mysqli_query($conn, $sql);

      while ($tecido = mysqli_fetch_array($result_sql)) {?>
        <option value="<?php echo $tecido['id_material']; ?>"><?php echo $tecido['nome_mat']; ?></option><?php
      }
      ?>
    </select>
  </td>
  </td>
  </td>
  <td>
    <div id="medidas_estrutura" style="text-align: right; width: 130%; display:none;">
    <label>MEDIDAS:</label><br>
    <label>comprimento:</label>
    <input style="width: 30%;" type="number" min="1" max="6" onKeyPress="return Apenas_Numeros(event);" name="comprimento_est" id="comprimento_est" placeholder="METRO">
    </div>
  </td>
  <td>
  </td>
  <td>
  </td>
  </tr>
</table>
</form>
</div>

<script>
// inicio almofada
 $("#almofada_botao").change(function() {//id select
    $('#qto_almofada').hide(); // id da div
    if(this.value != "") //value do select
      $('#qto_almofada').show(); // id do div

 });
 $("#almofada").change(function() {
    $('#outros_almofadas').hide();
    if(this.value == "outro")
      $('#outros_almofadas').show();

 });
 $("#almofada").change(function() {
    $('#medidas_almofadas').hide();
    if(this.value != "")
      $('#medidas_almofadas').show();

 });
 $("#tecido_almofada").change(function() {
    $('#seguraca_almofadas').hide();
    if(this.value != "")
      $('#seguraca_almofadas').show();

 });
// fim almofada 


// inicio assento 
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


// inicio encosto
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

// fim encosto 

// inicio estrutura 
 $("#estrutura").change(function() {
    $('#medidas_estrutura').hide();
    if(this.value != "")
      $('#medidas_estrutura').show();

 });

 // fim estrutura 


function verifica_dados() {
  var x = document.getElementById('cliente_orca').value;
  var y = document.getElementById('empresa_orca').value;
  //var z = document.getElementById('estoque').value;

    if (x == "" && y == "" || x != "" && y != "") {
         alert("VOCE DEVE GERAR UM ORÇAMENTO PRA UM CLIENTE OU EMPRESA, NÃO PARA OS DOIS");
        // alert(z);
        return false;
      }else {

            //$("#estoque").is(':checked');
      }
    }

</script>


<?php
include 'footer.php'
?>
