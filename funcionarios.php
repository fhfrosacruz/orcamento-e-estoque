<script type="text/javascript">

function submitar( idPagina ){
 document.getElementById('pagina').value=idPagina;
 document.getElementById('pesquisa_funcionario').submit()
}

$(document).on('change', '#nome', function () {
      var value  = $(this).val();
      var option = $(this).find("option:selected");

      var cargo  = option.data('cargo');
      
      
      $('#cargo').val(cargo);
     
   });

</script>
<script type="text/javascript" src="https://kryogenix.org/code/browser/sorttable/sorttable.js"></script> <!-- ordena a tabela chamada em class = 'sortable' -->
<?php
$title = "funcionario";          // (1) Set the title
require './header.php';                 // (2) Include the header
require './conexao/banco.php';

//redireciona se não tiver nivel de acesso correto
if ($_SESSION['user_nivel'] != '0') {
header('Location: ./inicial.php');
}

@$pesq = $_GET['pesquisa'];
if ($pesq != null) {

  //paginação tabela funcionarios
  $pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1;

  //Selecionar todos os funcionarios da tabela
  $result_funcionarios = "SELECT * FROM funcionario INNER JOIN pessoa ON id_pessoa = pessoa_id INNER JOIN endereco ON id_endereco = endereco_id WHERE nome LIKE '%$pesq%'";
  $resultado_funcionarios = mysqli_query($conn, $result_funcionarios);

  //Contar o total de funcionarios
  $total_funcionarios = mysqli_num_rows($resultado_funcionarios);

  //Seta a quantidade de funcionarios por pagina
  $quantidade_pg = $total_funcionarios;

  //calcular o número de pagina necessárias para apresentar os funcionarios
  @$num_pagina = ceil($total_funcionarios/$quantidade_pg);

  //Calcular o inicio da visualizacao
  $incio = ($quantidade_pg*$pagina)-$quantidade_pg;

  //Selecionar os funcionarios a serem apresentado na página
  $result_funcionarios = "SELECT * FROM funcionario INNER JOIN pessoa ON id_pessoa = pessoa_id INNER JOIN endereco ON id_endereco = endereco_id WHERE nome LIKE '%$pesq%' LIMIT $incio, $quantidade_pg";
  $resultado_funcionarios = mysqli_query($conn, $result_funcionarios);

} else {

//paginação tabela funcionarios
$pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1;

//Selecionar todos os funcionarios da tabela
$result_funcionarios = "SELECT * FROM funcionario INNER JOIN pessoa ON id_pessoa = pessoa_id INNER JOIN endereco ON id_endereco = endereco_id";
$resultado_funcionarios = mysqli_query($conn, $result_funcionarios);

//Contar o total de funcionarios
$total_funcionarios = mysqli_num_rows($resultado_funcionarios);

//Seta a quantidade de funcionarios por pagina
$quantidade_pg = $total_funcionarios;

//calcular o número de pagina necessárias para apresentar os funcionarios
@$num_pagina = ceil($total_funcionarios/$quantidade_pg);

//Calcular o inicio da visualizacao
$incio = ($quantidade_pg*$pagina)-$quantidade_pg;

//Selecionar os funcionarios a serem apresentado na página
$result_funcionarios = "SELECT * FROM funcionario INNER JOIN pessoa ON id_pessoa = pessoa_id INNER JOIN endereco ON id_endereco = endereco_id LIMIT $incio, $quantidade_pg";
$resultado_funcionarios = mysqli_query($conn, $result_funcionarios);

}				
    						
?>

<formbotao>
<button type="button" class="btn btn-primary view_data" id= "button_add" data-toggle="modal" data-target="#funcionario_add_Modal">Adicionar funcionario</button>
&nbsp&nbsp&nbsp&nbsp
<button type="button" class="btn btn-primary view_data" id= "button_login" data-toggle="modal" data-target="#funcionario_login_Modal">Criar login funcionario</button>
</formbotao>
<br>



<div class="table-responsive-xl container theme-showcase" role="main">

  <form class="pesq" id="pesquisa_funcionario" method="get" action="#">
      <input type="text" name="pesquisa" id="pesquisa" value="<?php echo $pesq; ?>"></input>
      <input type="hidden" name="pagina" id="pagina"></input>
      <button type="hide" onclick="submitar(1)"> pesquisar </button>
  </form>

  <table align="center" border="3" class="sortable table table-hover table table-sm" id="listar_clientes" class="display">
    <tr>
      <th>id</th>
      <th>Nome</th>
      <th>Cargo</th>
      <th>Data de admissão</th>
      <th>Data de saida</th>
      <th>Ação</th>
    </tr>

    <?php while ($funcionario = mysqli_fetch_array($resultado_funcionarios)) {?>
      <tr>
        <td><?php echo $funcionario['id_funcionario']; ?></td>
        <td><?php echo $funcionario['nome']; ?></td>
        <td><?php echo $funcionario['cargo']; ?></td>
        <td><?php echo date ('d/m/Y', strtotime ($funcionario['data_adm'])); ?></td>
        <td><?php if (date ('d/m/Y', strtotime ($funcionario['data_saida']))=="01/01/1970" || "30/11/-0001") {
          echo "";
        }else {
          echo date ('d/m/Y', strtotime ($funcionario['data_saida']));
        } ?></td>
        <td>
          <div class="btn-group">
          <button type="button" class="btn-xs btn-outline-dark view_data" data-toggle="modal" data-target="#funcionarioModal" data-id = "<?php echo $funcionario['id_funcionario']; ?>"
            data-nome="<?php echo $funcionario['nome']; ?>" data-cargo="<?php echo $funcionario['cargo']; ?>" data-adm="<?php echo $funcionario['data_adm']; ?>" data-saida="<?php echo $funcionario['data_saida']; ?>"
            data-cpf="<?php echo $funcionario['cpf']; ?>" data-nasc="<?php echo $funcionario['data_nasc']; ?>" data-pessoa_id = "<?php echo $funcionario['pessoa_id']; ?>"
            data-email="<?php echo $funcionario['email']; ?>" data-telefone="<?php echo $funcionario['telefone']; ?>" data-endereco_id="<?php echo $funcionario['endereco_id']; ?>" data-rua="<?php echo $funcionario['rua']; ?>"
            data-numero = "<?php echo $funcionario['numero']; ?>" data-complemento = "<?php echo $funcionario['complemento']; ?>" data-cep = "<?php echo $funcionario['cep']; ?>"
            data-bairro = "<?php echo $funcionario['bairro']; ?>" data-cidade = "<?php echo $funcionario['cidade']; ?>" data-estado = "<?php echo $funcionario['estado']; ?>"
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


<!-- MODAL EDITAR funcionario INICIO -->
  <div class="modal fade" id="funcionarioModal" tabindex="-1" role="dialog" aria-labelledby="funcionarioModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="funcionarioModalLabel">Editar funcionario</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
            <span aria-hidden="true">&times;</span>
        </div>
        <div class="modal-body">
          <form method="POST" action="./controle/funcionario/funcionario_edit.php">
            <div class="form-group">
              <input type="hidden" name="id" class="form-control" id="id">
            </div>
            <div class="form-group">
              <input type="hidden" name="pessoa_id" class="form-control" id="pessoa_id">
            </div>
            <div class="form-group">
              <label for="recipient_nome" class="control-label">Nome:</label>
              <input name="nome" class="form-control" id="nome" onkeypress="return letras();">
            </div>
            <div class="form-group">
            <label for="recipient_cargo" class="control-label">Cargo:</label>
            <select name="cargo" class="form-control" id="cargo">
              <option value="FUNCIONARIO" selected>FUNCIONARIO</option>
              <option value="GERENTE">GERENTE</option>
            </select>
          </div>
            <div class="form-groupinput-append date" data-date-format="dd-mm-yyyy">
              <label for="recipient_adm" class="control-label">Data de admissão:</label>
              <input type="date" name="adm" class="form-control" id="adm">
            </div>
            <div class="form-groupinput-append date" data-date-format="dd-mm-yyyy">
              <label for="recipient_saida" class="control-label">Data de saida:</label>
              <input type="date" name="saida" class="form-control" id="saida">
            </div>
            <div class="form-group">
              <label for="recipient_cpf" class="control-label">cpf:</label>
              <input name="cpf" class="form-control" id="cpf" onKeyPress="return Apenas_Numeros(event);" maxlength = "11">
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
<!-- MODAL EDITAR funcionario FIM -->

<!-- MODAL ADICIONAR funcionario INICIO -->
  <div class="modal fade" id="funcionario_add_Modal" tabindex="-1" role="dialog" aria-labelledby="funcionario_add_ModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="funcionario_add_ModalLabel">Adicionar funcionario</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
            <span aria-hidden="true">&times;</span>
        </div>
        <div class="modal-body">
          <form method="POST" action="./controle/funcionario/funcionario_add.php">
            <div class="form-group">
              <input type="hidden" name="id" class="form-control" id="id">
            </div>
            <div class="form-group">
              <label for="recipient_nome" class="control-label">Nome:</label>
              <input required name="nome" class="form-control" id="nome" onkeypress="return letras();">
            </div>
            <div class="form-group">
              <label for="recipient_cargo" class="control-label">Cargo:</label>
              <select name="cargo" class="form-control" id="cargo">
                <option value="FUNCIONARIO" selected>FUNCIONARIO</option>
                <option value="GERENTE">GERENTE</option>
              </select>
            </div>
            <div class="form-groupinput-append date" data-date-format="dd-mm-yyyy">
              <label for="recipient_adm" class="control-label">Data de admissão:</label>
              <input type="date" name="adm" class="form-control" id="adm">
            </div>
            <div class="form-groupinput-append date" data-date-format="dd-mm-yyyy">
              <label for="recipient_saida" class="control-label">Data de saida:</label>
              <input type="date" name="saida" class="form-control" id="saida">
            </div>
            <div class="form-group">
              <label for="recipient_cpf" class="control-label">cpf:</label>
              <input required size="11" maxlength="11" onKeyPress="return Apenas_Numeros(event);" name="cpf" class="form-control" id="cpf">
            </div>
              <div class="form-groupinput-append date" data-date-format="dd-mm-yyyy">
                <label for="recipient_nasc" class="control-label">Nascimento:</label>
                <input type="date" required name="nasc" onblur="calcular_idade(this);" class="form-control" id="nasc">
              </div>
            <div class="form-group">
              <label for="recipient_email" class="control-label" >E-mail:</label>
              <input required name="email" class="form-control" id="email" >
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
<!-- MODAL ADICIONAR funcionario FIM -->

<!-- MODAL CRIA LOGIN funcionario INICIO -->
  <div class="modal fade" id="funcionario_login_Modal" tabindex="-1" role="dialog" aria-labelledby="funcionario_login_ModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="funcionario_login_ModalLabel">Criar login de funcionario</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
            <span aria-hidden="true">&times;</span>
        </div>
        <div class="modal-body">
          <form method="POST" action="./arquivos_de_login/cria_login.php">
            <div class="form-group">
              <label for="recipient_nome" class="control-label">Nome:</label>
                <select name="nome" type="text" class="form-control" id="nome">
                  <option>SELECIONE O FUNCIONARIO</option>
                  <?php
                  $sql = "SELECT nome, cargo, id_funcionario FROM funcionario f INNER JOIN pessoa p ON p.id_pessoa = f.pessoa_id LEFT JOIN login l ON l.funcionario_id = f.id_funcionario WHERE l.funcionario_id IS NULL";
                  $result_sql = mysqli_query($conn, $sql);

                  while ($nome_func = mysqli_fetch_array($result_sql)) {?>
                    <option value="<?php echo $nome_func['id_funcionario']; ?>" data-cargo="gerente"><?php echo $nome_func['nome']; ?></option><?php
                  }
                  ?>
                </select>
            </div>             
              <div class="form-group">
                <label for="recipient_usuario" class="control-label">Usuário:</label>
                <input name="usuario" class="form-control" id="usuario">
              </div>
            <div class="form-group">
              <label for="recipient_senha" class="control-label">Senha:</label>
              <input type="password" name="senha" class="form-control" id="senha">
            </div>
            <div class="form-group">
              <label for="recipient_conf_senha" class="control-label">Confirmar Senha:</label>
              <input type="password" name="conf_senha" class="form-control" id="conf_senha">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-danger">Criar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
<!-- MODAL CRIA LOGIN funcionario FIM -->

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
