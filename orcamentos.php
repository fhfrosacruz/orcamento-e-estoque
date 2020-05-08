<script>
function submitar( idPagina ){
 document.getElementById('pagina').value=idPagina;
 document.getElementById('pesquisa_orcamento').submit()
}
</script>
<script type="text/javascript" src="https://kryogenix.org/code/browser/sorttable/sorttable.js"></script> <!-- ordena a tabela chamada em class = 'sortable' -->
<?php
$title = "orcamento";          // (1) Set the title
require './header.php';                 // (2) Include the header
require './conexao/banco.php';


@$pesq = $_GET['pesquisa'];
@$pesq_cli = $_GET['nome_cli'];
if ($pesq != null) {// SE HOUVER ALGUMA PESQUISA

  //paginação tabela orcamentos
  $pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1;

  //Selecionar todos os orcamentos da tabela
  $result_orcamentos = "SELECT * FROM orcamento
  INNER JOIN pessoa ON nome = (SELECT nome FROM pessoa WHERE id_pessoa = (SELECT pessoa_id FROM funcionario WHERE id_funcionario = funcionario_id)) WHERE id_orcamento LIKE '%$pesq%'";
//  INNER JOIN orcamento_material ON id_orcamento = orcamento_id";
//  INNER JOIN material ON nome_mat = (SELECT nome_mat FROM material WHERE id_material = material_id) WHERE id_orcamento LIKE '%$pesq%'";
  $resultado_orcamentos = mysqli_query($conn, $result_orcamentos);

  //Contar o total de orcamentos
  $total_orcamentos = mysqli_num_rows($resultado_orcamentos);

  //Seta a quantidade de orcamentos por pagina
  $quantidade_pg = $total_orcamentos;

  //calcular o número de pagina necessárias para apresentar os orcamentos
  @$num_pagina = ceil($total_orcamentos/$quantidade_pg);

  //Calcular o inicio da visualizacao
  $incio = ($quantidade_pg*$pagina)-$quantidade_pg;

  //Selecionar os orcamentos a serem apresentado na página
  $result_orcamentos = "SELECT * FROM orcamento
  INNER JOIN pessoa ON nome = (SELECT nome FROM pessoa WHERE id_pessoa = (SELECT pessoa_id FROM funcionario WHERE id_funcionario = funcionario_id)) WHERE id_orcamento LIKE '%$pesq%' LIMIT $incio, $quantidade_pg";
//  INNER JOIN orcamento_material ON id_orcamento = orcamento_id";
//  INNER JOIN material ON nome_mat = (SELECT nome_mat FROM material WHERE id_material = material_id) WHERE id_orcamento LIKE '%$pesq%' LIMIT $incio, $quantidade_pg";
  $resultado_orcamentos = mysqli_query($conn, $result_orcamentos);

}elseif ($pesq_cli != null) {
  // SE HOUVER ALGUMA PESQUISA

    //paginação tabela orcamentos
    $pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1;

    //Selecionar todos os orcamentos da tabela
    $result_orcamentos = "SELECT * FROM orcamento
    INNER JOIN pessoa ON nome = (SELECT nome FROM pessoa WHERE id_pessoa = (SELECT pessoa_id FROM funcionario WHERE id_funcionario = funcionario_id)) WHERE cliente_nome LIKE '%$pesq_cli%'";
  //  INNER JOIN orcamento_material ON id_orcamento = orcamento_id";
  //  INNER JOIN material ON nome_mat = (SELECT nome_mat FROM material WHERE id_material = material_id) WHERE id_orcamento LIKE '%$pesq%'";
    $resultado_orcamentos = mysqli_query($conn, $result_orcamentos);

    //Contar o total de orcamentos
    $total_orcamentos = mysqli_num_rows($resultado_orcamentos);

    //Seta a quantidade de orcamentos por pagina
    $quantidade_pg = $total_orcamentos;

    //calcular o número de pagina necessárias para apresentar os orcamentos
    @$num_pagina = ceil($total_orcamentos/$quantidade_pg);

    //Calcular o inicio da visualizacao
    $incio = ($quantidade_pg*$pagina)-$quantidade_pg;

    //Selecionar os orcamentos a serem apresentado na página
    $result_orcamentos = "SELECT * FROM orcamento
    INNER JOIN pessoa ON nome = (SELECT nome FROM pessoa WHERE id_pessoa = (SELECT pessoa_id FROM funcionario WHERE id_funcionario = funcionario_id)) WHERE cliente_nome LIKE '%$pesq_cli%' LIMIT $incio, $quantidade_pg";
  //  INNER JOIN orcamento_material ON id_orcamento = orcamento_id";
  //  INNER JOIN material ON nome_mat = (SELECT nome_mat FROM material WHERE id_material = material_id) WHERE id_orcamento LIKE '%$pesq%' LIMIT $incio, $quantidade_pg";
    $resultado_orcamentos = mysqli_query($conn, $result_orcamentos);
}else {

//paginação tabela orcamentos
$pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1;

//Selecionar todos os orcamentos da tabela
$result_orcamentos = "SELECT * FROM orcamento
  INNER JOIN pessoa ON nome = (SELECT nome FROM pessoa WHERE id_pessoa = (SELECT pessoa_id FROM funcionario WHERE id_funcionario = funcionario_id))";
//  INNER JOIN orcamento_material ON id_orcamento = orcamento_id";
//  INNER JOIN material ON nome_mat = (SELECT nome_mat FROM material WHERE id_material = material_id)";
$resultado_orcamentos = mysqli_query($conn, $result_orcamentos);

//Contar o total de orcamentos
$total_orcamentos = mysqli_num_rows($resultado_orcamentos);

//Seta a quantidade de orcamentos por pagina
$quantidade_pg = $total_orcamentos;

//calcular o número de pagina necessárias para apresentar os orcamentos
@$num_pagina = ceil($total_orcamentos/$quantidade_pg);

//Calcular o inicio da visualizacao
$incio = ($quantidade_pg*$pagina)-$quantidade_pg;

//Selecionar os orcamentos a serem apresentado na página
$result_orcamentos = "SELECT * FROM orcamento
  INNER JOIN pessoa ON nome = (SELECT nome FROM pessoa WHERE id_pessoa = (SELECT pessoa_id FROM funcionario WHERE id_funcionario = funcionario_id)) LIMIT $incio, $quantidade_pg";
  //INNER JOIN orcamento_material ON id_orcamento = orcamento_id";
  //INNER JOIN material ON nome_mat = (SELECT nome_mat FROM material WHERE id_material = material_id) LIMIT $incio, $quantidade_pg";
$resultado_orcamentos = mysqli_query($conn, $result_orcamentos);

//$result_clientes = "SELECT * FROM pessoa p INNER JOIN endereco e ON id_endereco = endereco_id LEFT JOIN funcionario f ON f.pessoa_id = p.id_pessoa WHERE f.id_funcionario IS NULL";
//$resultado_clientes = mysqli_query($conn, $result_clientes);

}

?>
<!--
<formbotao>
<button type="button" class="btn btn-primary view_data" id= "button_add" data-toggle="modal" data-target="#orcamento_add_Modal">Adicionar orcamento</button>
</formbotao>
<br>
-->

<h2 style="text-align:center;"> ORÇAMENTOS</h2>
<div class="table-responsive-xl container theme-showcase" role="main">

  <form class="pesq" id="pesquisa_orcamento" method="get" action="#">
    PESQUISAR POR NUMERO DE IDENTIFICAÇÃO DO ORÇAMENTO:
      <input type="number" min="1" name="pesquisa" id="pesquisa" value="<?php echo $pesq; ?>"></input>
      <br>
      PESQUISAR POR NOME DO CLIENTE:
      <input type="text" autocomplete="off" name="nome_cli" id="nome_cli" value="<?php echo $pesq_cli; ?>"></input>
      <input type="hidden" name="pagina" id="pagina"></input>
      <br>
      <button type="hide" onclick="submitar(1)"> Pesquisar </button>
  </form>

  <table align="center" border="3" class="sortable table table-hover table table-sm" id="listar_clientes" class="display">
    <tr>
      <th>id Orçamento</th>
      <th>Funcionário</th>
      <th>Cliente</th>
      <th>Data do orçamento</th>
    <!--  <th>Material</th> -->
    <!--  <th>Mão de obra (R$)</th> -->
    <!--  <th>Quantidade usada</th> -->
    <!--  <th>Medida</th> -->
    <!--  <th>Total (R$)</th> -->
    <!--  <th>Observações</th> -->
      <th>Total do Orcamento (R$)</th>
      <th>Status</th>
      <th>Ação</th>
    </tr>


    <?php while ($orcamento = mysqli_fetch_array($resultado_orcamentos)) {?>
      <tr>
        <td><?php echo $orcamento['id_orcamento']; ?></td>
        <td><?php echo $orcamento['nome']; ?></td>
        <td><?php echo $orcamento['cliente_nome']; ?></td>
        <td><?php echo date ('d/m/Y', strtotime ($orcamento['data_orca'])); ?></td>
      <!--  <td><?php echo $orcamento['nome_mat']; ?></td> -->
      <!--  <td><?php echo $orcamento['mao_obra']; ?></td> -->
      <!--  <td><?php echo $orcamento['quantidade_mat']; ?></td> -->
      <!--  <td><?php echo $orcamento['uni_medida']; ?></td> -->
      <!--  <td><?php echo $orcamento['total_mat']; ?></td> -->
      <!--  <td>CLIQUE EM EDITAR PARA VER <?php $orcamento['observacao']; ?></td> -->
        <td><?php echo $orcamento['valor_total']; ?></td>
        <td><?php echo $orcamento['status']; ?></td>
        <td>

          <div class="btn-group">
          <button type="button" class="btn-xs btn-outline-dark view_data" data-toggle="modal" data-target="#orcamentoModal" data-id = "<?php echo $orcamento['id_orcamento']; ?>"
            data-nome="<?php echo $orcamento['nome']; ?>" data-data_orca="<?php echo $orcamento['data_orca']; ?>" data-nome_mat="<?php echo $orcamento['nome_mat']; ?>"
            data-mao_obra="<?php echo $orcamento['mao_obra']; ?>" data-quantidade_mat="<?php echo $orcamento['quantidade_mat']; ?>" data-uni_medida="<?php echo $orcamento['uni_medida']; ?>"
            data-total_mat="<?php echo $orcamento['total_mat']; ?>" data-observacao="<?php echo $orcamento['observacao']; ?>" data-valor_total="<?php echo $orcamento['valor_total']; ?>"
            data-estoque="<?php echo $orcamento['estoque']; ?>" data-status="<?php echo $orcamento['status']; ?>">Status</button>
          <form action="./visualiza_orc.php" method="POST">
            <button type="submit" formtarget="_blank" class="btn-xs btn-outline-primary view_data" id="visualiza_orc" value="<?php echo $orcamento['id_orcamento']; ?>" name="visualiza_orc">Visualizar</button>
          </form>
          <form action="./altera_orca.php" method="POST">
            <button type="submit" formtarget="_blank" class="btn-xs btn-outline-danger view_data" id="altera_orca" value="<?php echo $orcamento['id_orcamento']; ?>" name="altera_orca">Alterar</button>
          </form>
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


<!-- MODAL EDITAR orcamento INICIO -->
  <div class="modal fade" id="orcamentoModal" tabindex="-1" role="dialog" aria-labelledby="orcamentoModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="orcamentoModalLabel">Editar orcamento</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
            <span aria-hidden="true">&times;</span>
        </div>
        <div class="modal-body">
          <form method="POST" action="./controle/orcamento/orcamento_edit.php">
            <div class="form-group">
              <input type="text" readonly name="id" class="form-control" id="id">
            </div>
          <!--  <div class="form-group">
              <label for="recipient_observacao" class="control-label">Observações</label>
              <textarea rows="3" name="observacao" class="form-control" id="observacao"></textarea>
            </div> -->
            <div class="form-group">
              <label for="recipient_status" class="control-label">Status do Orçamento</label>
              <select name="status" class="form-control" id="status">
    						 <!--  <option value="AGUARDANDO">AGUARDANDO</option> -->
                  <option value="APROVADO">APROVADO</option>
                  <option value="CONCLUIDO <?php echo date("d/m/Y H:i") ?>">CONCLUIDO</option>
                  <option value="CANCELADO">CANCELADO</option>
              </select>
            </div>
            <div class="form-group">
              <textarea readonly style="color:red;" name="estoque" id="estoque" rows="4" cols="40"></textarea>
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
<!-- MODAL EDITAR orcamento FIM -->

<?php
require "./footer.php";         // (3) Include the footer
?>
