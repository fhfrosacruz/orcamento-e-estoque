<script>
function submitar( idPagina ){
 document.getElementById('pagina').value=idPagina;
 document.getElementById('pesquisa_empresa').submit()
}
</script>
<script type="text/javascript" src="https://kryogenix.org/code/browser/sorttable/sorttable.js"></script> <!-- ordena a tabela chamada em class = 'sortable' -->
<?php
$title = "empresa";          // (1) Set the title
require './header.php';                 // (2) Include the header
require './conexao/banco.php';

/*
//consulta para exibir empresas na tabela
$consulta = "SELECT * FROM pessoa INNER JOIN endereco WHERE id_endereco = endereco_id";
$result_sql = mysqli_query($conn, $consulta);
*/

@$pesq = $_GET['pesquisa'];
if ($pesq != null) {

  //paginação tabela empresas
  $pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1;

  //Selecionar todos os empresas da tabela
  $result_empresas = "SELECT * FROM empresa WHERE razao_social LIKE '%$pesq%'";
  $resultado_empresas = mysqli_query($conn, $result_empresas);

  //Contar o total de empresas
  $total_empresas = mysqli_num_rows($resultado_empresas);

  //Seta a quantidade de empresas por pagina
  $quantidade_pg = $total_empresas;

  //calcular o número de pagina necessárias para apresentar os empresas
  @$num_pagina = ceil($total_empresas/$quantidade_pg);

  //Calcular o inicio da visualizacao
  $incio = ($quantidade_pg*$pagina)-$quantidade_pg;

  //Selecionar os empresas a serem apresentado na página
  $result_empresas = "SELECT * FROM empresa WHERE razao_social LIKE '%$pesq%' LIMIT $incio, $quantidade_pg";
  $resultado_empresas = mysqli_query($conn, $result_empresas);
//  $empresa = mysqli_num_rows($resultado_empresas);
} else {

//paginação tabela empresas
$pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1;

//Selecionar todos os empresas da tabela
$result_empresas = "SELECT * FROM empresa INNER JOIN endereco WHERE id_endereco = endereco_id";
$resultado_empresas = mysqli_query($conn, $result_empresas);

//Contar o total de empresas
$total_empresas = mysqli_num_rows($resultado_empresas);

//Seta a quantidade de empresas por pagina

$quantidade_pg = $total_empresas;

//calcular o número de pagina necessárias para apresentar os empresas
@$num_pagina = ceil($total_empresas/$quantidade_pg);

//Calcular o inicio da visualizacao
$incio = ($quantidade_pg*$pagina)-$quantidade_pg;

//Selecionar as empresas a serem apresentado na página
$result_empresas = "SELECT * FROM empresa INNER JOIN endereco ON id_endereco = endereco_id LIMIT $incio, $quantidade_pg";
$resultado_empresas = mysqli_query($conn, $result_empresas);

}
?>

<formbotao>
<button type="button" class="btn btn-primary view_data" id= "button_add" data-toggle="modal" data-target="#empresa_add_Modal">Adicionar empresa</button>
</formbotao>
<br>



<div class="table-responsive-xl container theme-showcase" role="main">

  <form class="pesq" id="pesquisa_empresa" method="get" action="#">
      <input type="text" name="pesquisa" id="pesquisa" value="<?php echo $pesq; ?>"></input>
      <input type="hidden" name="pagina" id="pagina"></input>
      <button type="hide" onclick="submitar(1)"> pesquisar </button>
  </form>

  <table align="center" border="3" class="sortable table table-hover table table-sm" id="listar_clientes" class="display">
    <tr>
      <th>id</th>
      <th>razao_social</th>
      <th>nome_fantasia</th>
      <th>cnpj</th>
      <th>telefone</th>
      <th>responsavel</th>
      <th>website</th>
      <th>email</th>
      <th>Detalhes</th>
      <th>endereco</th>
      <th>Ação</th>
    </tr>

    <?php while ($empresa = mysqli_fetch_array($resultado_empresas)) {?>
      <tr>
        <td><?php echo $empresa['id_empresa']; ?></td>
        <td><?php echo $empresa['razao_social']; ?></td>
        <td><?php echo $empresa['nome_fantasia']; ?></td>
        <td><?php echo $empresa['cnpj']; ?></td>
        <td><?php echo $empresa['telefone']; ?></td>
        <td><?php echo $empresa['responsavel']; ?></td>
        <td><?php echo $empresa['website']; ?></td>
        <td><?php echo $empresa['email']; ?></td>
        <td><?php echo $empresa['detalhes']; ?></td>
        <td><?php echo $empresa['rua']; ?></td>
        <td>
          <div class="btn-group">
          <button type="button" class="btn-xs btn-outline-dark view_data" data-toggle="modal" data-target="#empresaModal" data-id = "<?php echo $empresa['id_empresa']; ?>"
            data-razao_social="<?php echo $empresa['razao_social']; ?>" data-nome_fantasia="<?php echo $empresa['nome_fantasia']; ?>" data-cnpj="<?php echo $empresa['cnpj']; ?>"
            data-telefone="<?php echo $empresa['telefone']; ?>" data-responsavel="<?php echo $empresa['responsavel']; ?>" data-website="<?php echo $empresa['website']; ?>" data-email="<?php echo $empresa['email']; ?>" data-endereco_id="<?php echo $empresa['endereco_id']; ?>"
            data-rua="<?php echo $empresa['rua']; ?>" data-numero = "<?php echo $empresa['numero']; ?>" data-complemento = "<?php echo $empresa['complemento']; ?>" data-cep = "<?php echo $empresa['cep']; ?>"
            data-bairro = "<?php echo $empresa['bairro']; ?>" data-cidade = "<?php echo $empresa['cidade']; ?>" data-estado = "<?php echo $empresa['estado']; ?>"  data-detalhes = "<?php echo $empresa['detalhes']; ?>"
            >Editar</button>
          </div>
          </td>
        </tr>
      <?php } ?>
    </table>
</div>

<?php
      //Verificar a pagina anterior e posterior
      $pagina_anterior = $pagina - 1;
      $pagina_posterior = $pagina + 1;
    ?>
    <nav class="text-center">
      <ul class="pagination">
        <li>
          <?php
          if($pagina_anterior != 0){ ?>
            <a onclick="javascript:submitar(<?php echo $pagina_anterior; ?>);" />
              <span aria-hidden="true">&laquo;</span>
            </a>
          <?php }else{ ?>
            <span aria-hidden="true">&laquo;</span>
        <?php }  ?>
        </li>
        <?php
        //Apresentar a paginacao
        for($i = 1; $i < $num_pagina + 1; $i++){ ?>
          <li><a onclick="javascript:submitar(<?php echo $i; ?>);" /><?php echo $i; ?>
        <?php } ?>

          <?php
          if($pagina_posterior <= $num_pagina){ ?>
            <a onclick="javascript:submitar(<?php echo $pagina_posterior; ?>);" />
              <span aria-hidden="true">&raquo;</span>
            </a>
          <?php }else{ ?>
            <li><span aria-hidden="true">&raquo;</span></li>
        <?php }  ?>
        </li>
      </ul>
    </nav>


<!-- MODAL EDITAR empresa INICIO -->
  <div class="modal fade" id="empresaModal" tabindex="-1" role="dialog" aria-labelledby="empresaModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="empresaModalLabel">Editar empresa</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
            <span aria-hidden="true">&times;</span>
        </div>
        <div class="modal-body">
          <form method="POST" action="./controle/empresa/empresa_edit.php">
            <div class="form-group">
              <input type="hidden" name="id" class="form-control" id="id">
            </div>
            <div class="form-group">
              <label for="recipient_razao_social" class="control-label">razao_social:<?php echo $empresa['razao_social']; ?></label>
              <input name="razao_social" class="form-control" id="razao_social" onkeypress="return letras();">
            </div>
            <div class="form-group">
              <label for="recipient_nome_fantasia" class="control-label">nome_fantasia:</label>
              <input name="nome_fantasia" class="form-control" id="nome_fantasia" onkeypress="return letras();">
            </div>
            <div class="form-group">
              <label for="recipient_cnpj" class="control-label">cnpj:</label>
              <input name="cnpj" class="form-control" id="cnpj" onkeypress="if (!isNaN(String.fromCharCode(window.event.keyCode))) return false; else return true;">
            </div>
            <div class="form-group">
              <label for="recipient_telefone" class="control-label">telefone:</label>
              <input onkeyup="mascara( this, mtel );" maxlength="15" name="telefone" class="form-control" id="telefone">
            </div>
            <div class="form-group">
              <label for="recipient_responsavel" class="control-label">responsavel:</label>
              <input name="responsavel" class="form-control" id="responsavel" onkeypress="return letras();">
            </div>
            <div class="form-group">
              <label for="recipient_website" class="control-label">website:</label>
              <input name="website" class="form-control" id="website">
            </div>
            <div class="form-group">
              <label for="recipient_email" class="control-label">email:</label>
              <input name="email" class="form-control" id="email">
            </div>
            <div class="form-group">
              <input name="endereco_id" type="hidden" class="form-control" id="endereco_id">
            </div>
            <div class="form-group">
              <label for="recipient_rua" class="control-label">rua:</label>
              <input name="rua" class="form-control" id="rua" onkeypress="return letras();">
            </div>
            <div class="form-group">
              <label for="recipient_numero" class="control-label">Numero:</label>
              <input name="numero" class="form-control" id="numero" onkeypress="if (!isNaN(String.fromCharCode(window.event.keyCode))) return false; else return true;">
            </div>
            <div class="form-group">
              <label for="recipient_complemento" class="control-label">Complemento:</label>
              <input name="complemento" class="form-control" id="complemento">
            </div>
            <div class="form-group">
              <label for="recipient_cep" class="control-label">CEP:</label>
              <input name="cep" maxlength="8" class="form-control" id="cep" onkeypress="if (!isNaN(String.fromCharCode(window.event.keyCode))) return false; else return true;">
            </div>
            <div class="form-group">
              <label for="recipient_bairro" class="control-label">Bairro:</label>
              <input name="bairro" class="form-control" id="bairro" onkeypress="return letras();">
            </div>
            <div class="form-group">
              <label for="recipient_cidade" class="control-label">Cidade:</label>
              <input name="cidade" class="form-control" id="cidade" onkeypress="return letras();">
            </div>
            <div class="form-group">
              <label for="recipient_estado" class="control-label">Estado:</label>
              <select name="estado" class="form-control" id="estado">
                      <option value="AC">Acre</option>
                      <option value="AL">Alagoas</option>
                      <option value="AP">Amapá</option>
                      <option value="AM">Amazonas</option>
                      <option value="BA">Bahia</option>
                      <option value="CE">Ceará</option>
                      <option value="DF">Distrito Federal</option>
                      <option value="ES">Espírito Santo</option>
                      <option value="GO">Goiás</option>
                      <option value="MA">Maranhão</option>
                      <option value="MT">Mato Grosso</option>
                      <option value="MS">Mato Grosso do Sul</option>
                      <option value="MG">Minas Gerais</option>
                      <option value="PA">Pará</option>
                      <option value="PB">Paraíba</option>
                      <option value="PR">Paraná</option>
                      <option value="PE">Pernambuco</option>
                      <option value="PI">Piauí</option>
                      <option value="RJ">Rio de Janeiro</option>
                      <option value="RN">Rio Grande do Norte</option>
                      <option value="RS">Rio Grande do Sul</option>
                      <option value="RO">Rondônia</option>
                      <option value="RR">Roraima</option>
                      <option value="SC">Santa Catarina</option>
                      <option value="SP">São Paulo</option>
                      <option value="SE">Sergipe</option>
                      <option value="TO">Tocantins</option>
                      <option value="EX">Estrangeiro</option>
                  </select>
            </div>
            <div class="form-group">
              <label for="recipient_detalhes" class="control-label">Detalhes e observações:</label>
              <input name="detalhes" class="form-control" id="detalhes">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-danger">Editar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
<!-- MODAL EDITAR empresa FIM -->

<!-- MODAL ADICIONAR empresa INICIO -->
  <div class="modal fade" id="empresa_add_Modal" tabindex="-1" role="dialog" aria-labelledby="empresa_add_ModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="empresa_add_ModalLabel">Adicionar empresa</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
            <span aria-hidden="true">&times;</span>
        </div>
        <div class="modal-body">
          <form method="POST" action="./controle/empresa/empresa_add.php">
            <div class="form-group">
              <input type="hidden" name="id" class="form-control" id="id">
            </div>
            <div class="form-group">
              <label for="recipient_razao_social" class="control-label">razao_social:<?php echo $empresa['razao_social']; ?></label>
              <input name="razao_social" class="form-control" id="razao_social" onkeypress="return letras();">
            </div>
            <div class="form-group">
              <label for="recipient_nome_fantasia" class="control-label">nome_fantasia:</label>
              <input name="nome_fantasia" class="form-control" id="nome_fantasia" onkeypress="return letras();">
            </div>
            <div class="form-group">
              <label for="recipient_cnpj" class="control-label">cnpj:</label>
              <input name="cnpj" class="form-control" id="cnpj" onkeypress="return numeros();">
            </div>
            <div class="form-group">
              <label for="recipient_telefone" class="control-label">telefone:</label>
              <input onkeyup="mascara( this, mtel );" maxlength="15" name="telefone" class="form-control" id="telefone">
            </div>
            <div class="form-group">
              <label for="recipient_responsavel" class="control-label">responsavel:</label>
              <input name="responsavel" class="form-control" id="responsavel" onkeypress="return letras();">
            </div>
            <div class="form-group">
              <label for="recipient_website" class="control-label">website:</label>
              <input name="website" class="form-control" id="website">
            </div>
            <div class="form-group">
              <label for="recipient_email" class="control-label">email:</label>
              <input name="email" class="form-control" id="email">
            </div>
            <div class="form-group">
              <input name="endereco_id" type="hidden" class="form-control" id="endereco_id">
            </div>
            <div class="form-group">
              <label for="recipient_rua" class="control-label">rua:</label>
              <input name="rua" class="form-control" id="rua" onkeypress="return letras();">
            </div>
            <div class="form-group">
              <label for="recipient_numero" class="control-label">Numero:</label>
              <input name="numero" class="form-control" id="numero" onkeypress="if (!isNaN(String.fromCharCode(window.event.keyCode))) return true; else return false;">
            </div>
            <div class="form-group">
              <label for="recipient_complemento" class="control-label">Complemento:</label>
              <input name="complemento" class="form-control" id="complemento">
            </div>
            <div class="form-group">
              <label for="recipient_cep" class="control-label">CEP:</label>
              <input name="cep" class="form-control" id="cep" onkeypress="if (!isNaN(String.fromCharCode(window.event.keyCode))) return true; else return false;">
            </div>
            <div class="form-group">
              <label for="recipient_bairro" class="control-label">Bairro:</label>
              <input name="bairro" class="form-control" id="bairro" onkeypress="return letras();">
            </div>
            <div class="form-group">
              <label for="recipient_cidade" class="control-label">Cidade:</label>
              <input name="cidade" class="form-control" id="cidade" onkeypress="return letras();">
            </div>
            <div class="form-group">
              <label for="recipient_estado" class="control-label">Estado:</label>
              <select name="estado" class="form-control" id="estado">
                      <option value="AC">Acre</option>
                      <option value="AL">Alagoas</option>
                      <option value="AP">Amapá</option>
                      <option value="AM">Amazonas</option>
                      <option value="BA">Bahia</option>
                      <option value="CE">Ceará</option>
                      <option value="DF">Distrito Federal</option>
                      <option value="ES">Espírito Santo</option>
                      <option value="GO">Goiás</option>
                      <option value="MA">Maranhão</option>
                      <option value="MT">Mato Grosso</option>
                      <option value="MS">Mato Grosso do Sul</option>
                      <option value="MG">Minas Gerais</option>
                      <option value="PA">Pará</option>
                      <option value="PB">Paraíba</option>
                      <option value="PR">Paraná</option>
                      <option value="PE">Pernambuco</option>
                      <option value="PI">Piauí</option>
                      <option value="RJ">Rio de Janeiro</option>
                      <option value="RN">Rio Grande do Norte</option>
                      <option value="RS">Rio Grande do Sul</option>
                      <option value="RO">Rondônia</option>
                      <option value="RR">Roraima</option>
                      <option value="SC">Santa Catarina</option>
                      <option selected value="SP">São Paulo</option>
                      <option value="SE">Sergipe</option>
                      <option value="TO">Tocantins</option>
                      <option value="EX">Estrangeiro</option>
                  </select>
            </div>
            <div class="form-group">
              <label for="recipient_detalhes" class="control-label">Detalhes e observações:</label>
              <input name="detalhes" class="form-control" id="detalhes">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-danger">Adicionar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
<!-- MODAL ADICIONAR EMPRESA FIM -->

<script type="text/javascript">
function letras(){
tecla = event.keyCode;
if (tecla >= 48 && tecla <= 57){
return false;
}else{
return true;
}
}

function numeros(){
tecla = event.keyCode;
if (tecla >= 48 && tecla <= 57){
return true;
}else{
return false;
}
}
</script>

<?php
require "./footer.php";         // (3) Include the footer
?>
