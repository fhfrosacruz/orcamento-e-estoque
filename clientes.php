<script>
function submitar( idPagina ){
 document.getElementById('pagina').value=idPagina;
 document.getElementById('pesquisa_cliente').submit()
}
</script>
<script type="text/javascript" src="https://kryogenix.org/code/browser/sorttable/sorttable.js"></script> <!-- ordena a tabela chamada em class = 'sortable' -->
<?php
$title = "Cliente";          // (1) Set the title
require './header.php';                 // (2) Include the header
require './conexao/banco.php';

/*
//consulta para exibir clientes na tabela
$consulta = "SELECT * FROM pessoa INNER JOIN endereco WHERE id_endereco = endereco_id";
$result_sql = mysqli_query($conn, $consulta);
*/

@$pesq = $_GET['pesquisa'];
if ($pesq != null) {

  //paginação tabela clientes
  $pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1;

  //Selecionar todos os clientes da tabela
  $result_clientes = "SELECT * FROM pessoa WHERE nome LIKE '%$pesq%'";
  $resultado_clientes = mysqli_query($conn, $result_clientes);

  //Contar o total de clientes
  $total_clientes = mysqli_num_rows($resultado_clientes);

  //Seta a quantidade de clientes por pagina
  $quantidade_pg = $total_clientes;

  //calcular o número de pagina necessárias para apresentar os clientes
  @$num_pagina = ceil($total_clientes/$quantidade_pg);

  //Calcular o inicio da visualizacao
  $incio = ($quantidade_pg*$pagina)-$quantidade_pg;

  //Selecionar os clientes a serem apresentado na página
  $result_clientes = "SELECT * FROM pessoa WHERE nome LIKE '%$pesq%' LIMIT $incio, $quantidade_pg";
  $resultado_clientes = mysqli_query($conn, $result_clientes);
//  $cliente = mysqli_num_rows($resultado_clientes);
} else {

//paginação tabela clientes
$pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1;

//Selecionar todos os clientes da tabela
$result_clientes = "SELECT * FROM pessoa INNER JOIN endereco WHERE id_endereco = endereco_id";
$resultado_clientes = mysqli_query($conn, $result_clientes);

//Contar o total de clientes
$total_clientes = mysqli_num_rows($resultado_clientes);

//Seta a quantidade de clientes por pagina

$quantidade_pg = $total_clientes;

//calcular o número de pagina necessárias para apresentar os clientes
@$num_pagina = ceil($total_clientes/$quantidade_pg);

//Calcular o inicio da visualizacao
$incio = ($quantidade_pg*$pagina)-$quantidade_pg;

//Selecionar os clientes a serem apresentado na página
$result_clientes = "SELECT * FROM pessoa p INNER JOIN endereco e ON id_endereco = endereco_id LEFT JOIN funcionario f ON f.pessoa_id = p.id_pessoa WHERE f.id_funcionario IS NULL LIMIT $incio, $quantidade_pg";
$resultado_clientes = mysqli_query($conn, $result_clientes);

}
?>

<formbotao>
<button type="button" class="btn btn-primary view_data" id= "button_add" data-toggle="modal" data-target="#cliente_add_Modal">Adicionar Cliente</button>
</formbotao>
<br>



<div class="table-responsive-xl container theme-showcase" role="main">

  <form class="pesq" id="pesquisa_cliente" method="get" action="#">
      <input type="text" name="pesquisa" id="pesquisa" value="<?php echo $pesq; ?>"></input>
      <input type="hidden" name="pagina" id="pagina"></input>
      <button type="hide" onclick="submitar(1)"> pesquisar </button>
  </form>

  <table align="center" border="3" class="sortable table table-hover table table-sm" id="listar_clientes" class="display">
    <tr>
      <th>id</th>
      <th>Nome</th>
      <th>CPF</th>
      <th>Nascimento</th>
      <th>E-Mail</th>
      <th>Telefone</th>
      <th>Ação</th>
    </tr>

    <?php while ($cliente = mysqli_fetch_array($resultado_clientes)) {?>
      <tr>
        <td><?php echo $cliente['id_pessoa']; ?></td>
        <td><?php echo $cliente['nome']; ?></td>
        <td><?php echo $cliente['cpf']; ?></td>
        <td><?php echo date ('d/m/Y', strtotime ($cliente['data_nasc'])); ?></td>
        <td><?php echo $cliente['email']; ?></td>
        <td><?php echo $cliente['telefone']; ?></td>
        <td>
          <div class="btn-group">
          <button type="button" class="btn-xs btn-outline-dark view_data" data-toggle="modal" data-target="#clienteModal" data-id = "<?php echo $cliente['id_pessoa']; ?>"
            data-nome="<?php echo $cliente['nome']; ?>" data-cpf="<?php echo $cliente['cpf']; ?>" data-nasc="<?php echo $cliente['data_nasc']; ?>"
            data-email="<?php echo $cliente['email']; ?>" data-telefone="<?php echo $cliente['telefone']; ?>" data-endereco_id="<?php echo $cliente['endereco_id']; ?>" data-rua="<?php echo $cliente['rua']; ?>"
            data-numero = "<?php echo $cliente['numero']; ?>" data-complemento = "<?php echo $cliente['complemento']; ?>" data-cep = "<?php echo $cliente['cep']; ?>"
            data-bairro = "<?php echo $cliente['bairro']; ?>" data-cidade = "<?php echo $cliente['cidade']; ?>" data-estado = "<?php echo $cliente['estado']; ?>"
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


<!-- MODAL EDITAR CLIENTE INICIO -->
  <div class="modal fade" id="clienteModal" tabindex="-1" role="dialog" aria-labelledby="clienteModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="clienteModalLabel">Editar Cliente</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
            <span aria-hidden="true">&times;</span>
        </div>
        <div class="modal-body">
          <form method="POST" action="./controle/cliente/cliente_edit.php">
            <div class="form-group">
              <input type="hidden" name="id" class="form-control" id="id">
            </div>
            <div class="form-group">
              <label for="recipient_nome" class="control-label">Nome:</label>
              <input name="nome" class="form-control" id="nome" onkeypress="return letras();">
            </div>
            <div class="form-group">
              <label for="recipient_cpf" class="control-label">cpf:</label>
              <input size="11" maxlength="11" onKeyPress="return Apenas_Numeros(event);" name="cpf" class="form-control" id="cpf">
            </div>
              <div class="form-groupinput-append date" data-date-format="dd-mm-yyyy">
                <label for="recipient_nasc" class="control-label">Nascimento:</label>
                <input type="date" required name="nasc" onblur="calcular_idade(this);" class="form-control" id="nasc">
              </div>
            <div class="form-group">
              <label for="recipient_email" class="control-label">E-mail:</label>
              <input type="email" name="email" class="form-control" id="email">
            </div>
            <div class="form-group">
              <label for="recipient_telefone" class="control-label">telefone:</label>
              <input onkeyup="mascara( this, mtel );" maxlength="15" name="telefone" class="form-control" id="telefone">
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
              <input maxlength="8" name="cep" class="form-control" id="cep" onkeypress="if (!isNaN(String.fromCharCode(window.event.keyCode))) return true; else return false;">
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
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-danger">Editar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
<!-- MODAL EDITAR CLIENTE FIM -->

<!-- MODAL ADICIONAR CLIENTE INICIO -->
  <div class="modal fade" id="cliente_add_Modal" tabindex="-1" role="dialog" aria-labelledby="cliente_add_ModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="cliente_add_ModalLabel">Adicionar Cliente</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
            <span aria-hidden="true">&times;</span>
        </div>
        <div class="modal-body">
          <form method="POST" action="./controle/cliente/cliente_add.php">
            <div class="form-group">
              <input type="hidden" name="id" class="form-control" id="id">
            </div>
            <div class="form-group">
              <label for="recipient_nome" class="control-label">Nome:</label>
              <input name="nome" class="form-control" id="nome" onkeypress="return letras();">
            </div>
            <div class="form-group">
              <label for="recipient_cpf" class="control-label">cpf:</label>
              <input size="11" maxlength="11" onKeyPress="return Apenas_Numeros(event);" onBlur="validaCPF(this);" name="cpf" class="form-control" id="cpf">
            </div>
              <div class="form-groupinput-append date" data-date-format="dd-mm-yyyy">
                <label for="recipient_nasc" class="control-label">Nascimento:</label>
                <input type="date" required name="nasc" onblur="calcular_idade(this);" class="form-control" id="nasc">
              </div>
            <div class="form-group">
              <label for="recipient_email" class="control-label">E-mail:</label>
              <input name="email" class="form-control" id="email">
            </div>
            <div class="form-group">
              <label for="recipient_telefone" class="control-label">telefone:</label>
              <input onkeyup="mascara( this, mtel );" maxlength="15" name="telefone" class="form-control" id="telefone">
            </div>
            <div class="form-group">
              <input name="endereco_id" type="hidden" class="form-control" id="endereco_id">
            </div>
            <div class="form-group">
              <label for="recipient_rua" class="control-label">rua:</label>
              <input name="rua" class="form-control" id="rua">
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
              <input name="cep" maxlength="8" class="form-control" id="cep" onkeypress="if (!isNaN(String.fromCharCode(window.event.keyCode))) return true; else return false;">
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
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-danger">Adicionar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
<!-- MODAL ADICIONAR CLIENTE FIM -->

<script type="text/javascript">
function letras(){
tecla = event.keyCode;
if (tecla >= 48 && tecla <= 57){
return false;
}else{
return true;
}
}


function calcular_idade() {
  if ($('#nasc').val() != '') {
    var dataInput = new Date($("#nasc").val());
    if (!isNaN(dataInput)) {
      var dataAtual = new Date();
      var diferenca = dataAtual.getFullYear() -
                      dataInput.getFullYear();

        if (diferenca < 18) {
            alert('Menor de idade ou Data inválida');
            document.getElementById('nasc').value = '00-00-000';
        }

      }
  }

}

</script>

<?php
require "./footer.php";         // (3) Include the footer
?>
