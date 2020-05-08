<script>
function submitar( idPagina ){
 document.getElementById('pagina').value=idPagina;
 document.getElementById('pesquisa_compra').submit()
}
</script>
<script type="text/javascript" src="https://kryogenix.org/code/browser/sorttable/sorttable.js"></script> <!-- ordena a tabela chamada em class = 'sortable' -->
<?php
$title = "compra";          // (1) Set the title
require './header.php';                 // (2) Include the header
require './conexao/banco.php';

//redireciona se não tiver nivel de acesso correto
if ($_SESSION['user_nivel'] != '0') {
header('Location: ./inicial.php');
}

@$pesq = $_GET['pesquisa'];
if ($pesq != null) {

  //paginação tabela compras
  $pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1;

  //Selecionar todos os compras da tabela
  $result_compras = "SELECT * FROM compra INNER JOIN material ON id_material = material_id WHERE nome_mat LIKE '%$pesq%'";
  $resultado_compras = mysqli_query($conn, $result_compras);

  //Contar o total de compras
  $total_compras = mysqli_num_rows($resultado_compras);

  //Seta a quantidade de compras por pagina
  $quantidade_pg = $total_compras;

  //calcular o número de pagina necessárias para apresentar os compras
  $num_pagina = ceil($total_compras/$quantidade_pg);

  //Calcular o inicio da visualizacao
  $incio = ($quantidade_pg*$pagina)-$quantidade_pg;

  //Selecionar os compras a serem apresentado na página
  $result_compras = "SELECT * FROM compra INNER JOIN material ON id_material = material_id  WHERE nome_mat LIKE '%$pesq%' LIMIT $incio, $quantidade_pg";
  $resultado_compras = mysqli_query($conn, $result_compras);

} else {

//paginação tabela compras
$pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1;

//Selecionar todos os compras da tabela
$result_compras = "SELECT * FROM compra INNER JOIN material ON id_material = material_id ";
$resultado_compras = mysqli_query($conn, $result_compras);

//Contar o total de compras
@$total_compras = mysqli_num_rows($resultado_compras);

//Seta a quantidade de compras por pagina
$quantidade_pg = $total_compras;

//calcular o número de pagina necessárias para apresentar os compras
@$num_pagina = ceil($total_compras/$quantidade_pg);

//Calcular o inicio da visualizacao
$incio = ($quantidade_pg*$pagina)-$quantidade_pg;

//Selecionar os compras a serem apresentado na página
$result_compras = "SELECT * FROM compra INNER JOIN material ON id_material = material_id  LIMIT $incio, $quantidade_pg";
$resultado_compras = mysqli_query($conn, $result_compras);

}
?>

<formbotao>
<button type="button" class="btn btn-primary view_data" id= "button_add" data-toggle="modal" data-target="#compra_add_Modal">Adicionar compra</button>
</formbotao>
<br>



<div class="table-responsive-xl container theme-showcase" role="main">

  <form class="pesq" id="pesquisa_compra" method="get" action="#">
      <input type="text" name="pesquisa" id="pesquisa" value="<?php echo $pesq; ?>"></input>
      <input type="hidden" name="pagina" id="pagina"></input>
      <button type="hide" onclick="submitar(1)"> pesquisar </button>
  </form>

  <table align="center" border="3" class="sortable table table-hover table table-sm" id="listar_clientes" class="display">
    <tr>
      <th>id</th>
      <th>Nome</th>
      <th>(R$)Total</th>
      <th>Quantidade</th>
      <th>Data da compra</th>
      <th>Observações</th>
      <th>Ação</th>
    </tr>

    <?php while ($compra = @mysqli_fetch_assoc($resultado_compras)) {?>
      <tr>
        <td><?php echo $compra['id_compra']; ?></td>
        <td><?php echo $compra['nome_mat']; ?></td>
        <td><?php echo $compra['preco_total']; ?></td>
        <td><?php echo $compra['quantidade_comp']; ?></td>
        <td><?php echo date ('d/m/Y', strtotime ($compra['data_compra'])); ?></td>
        <td><?php echo $compra['observacao']; ?></td>
        <td>
          <div class="btn-group">
          <button type="button" class="btn-xs btn-outline-dark view_data" data-toggle="modal" data-target="#compraModal" data-id = "<?php echo $compra['id_compra']; ?>"
            data-nome="<?php echo $compra['nome_mat']; ?>" data-preco_total="<?php echo $compra['preco_total']; ?>" data-data_compra="<?php echo $compra['data_compra']; ?>"
            data-quantidade="<?php echo $compra['quantidade_comp']; ?>" data-material_id="<?php echo $compra['material_id']; ?>" data-observacao="<?php echo $compra['observacao']; ?>"
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


<!-- MODAL EDITAR COMPRA INICIO -->
  <div class="modal fade" id="compraModal" tabindex="-1" role="dialog" aria-labelledby="compraModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="compraModalLabel">Editar compra</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
            <span aria-hidden="true">&times;</span>
        </div>
        <div class="modal-body">
          <form method="POST" action="./controle/compra/compra_edit.php">
            <div class="form-group">
              <input type="hidden" name="id" class="form-control" id="id">
            </div>
            <div class="form-group">
              <input type="hidden" name="material_id" class="form-control" id="material_id">
            </div>
            <div class="form-group">
              <label for="recipient_nome" class="control-label">Nome:</label>
              <input disabled="disabled" name="nome" class="form-control" id="nome">
            </div>
            <div class="form-group">
              <label for="recipient_preco_total" class="control-label">Preco total (R$):</label>
              <input name="preco_total" class="form-control" id="preco_total" onKeyUp="mascaraMoeda(this, event)" onKeyPress="return Apenas_Numeros(event);">
            </div>
            <div class="form-group">
              <label for="recipient_quantidade" class="control-label">Quantidade:</label>
              <input min="0" type="number" name="quantidade" class="form-control" id="quantidade">
            </div>
            <div class="form-groupinput-append date" data-date-format="dd-mm-yyyy">
              <label for="recipient_data_compra" class="control-label">Data da compra:</label>
              <input type="date" required name="data_compra" max="<?php echo date("Y-m-d"); ?>" class="form-control" id="data_compra">
            </div>
            <div class="form-group">
              <label for="recipient_observacao" class="control-label">Observações:</label>
              <input name="observacao" class="form-control" id="observacao">
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
<!-- MODAL EDITAR compra FIM -->

<!-- MODAL ADICIONAR compra INICIO -->
  <div class="modal fade" id="compra_add_Modal" tabindex="-1" role="dialog" aria-labelledby="compra_add_ModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="compra_add_ModalLabel">Adicionar compra</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
            <span aria-hidden="true">&times;</span>
        </div>
        <div class="modal-body">
          <form method="POST" action="./controle/compra/compra_add.php">
            <div class="form-group">
              <input type="hidden" name="id" class="form-control" id="id">
            </div>
            <div class="form-group">
              <label for="recipient_nome" class="control-label">Nome do material:</label>
              <select name="nome" class="form-control" id="nome">

                <?php
    						$sql = "SELECT DISTINCT nome_mat, id_material FROM material";
    						$result_sql = mysqli_query($conn, $sql);

    						while ($material = mysqli_fetch_array($result_sql)) {?>
    							<option value="<?php echo $material['id_material']; ?>"><?php echo $material['nome_mat']; ?></option><?php
    						}
    						?>
              </select>
            </div>
            <div class="form-group">
              <label for="recipient_preco_total" class="control-label">Preco total (R$):</label>
              <input type="text" name="preco_total" class="form-control" id="preco_total" onKeyUp="mascaraMoeda(this, event)" onKeyPress="return Apenas_Numeros(event);">
            </div>
            <div class="form-group">
              <label for="recipient_quantidade" class="control-label">Quantidade:</label>
              <input min="0" type="number" name="quantidade" class="form-control" id="quantidade">
            </div>
            <div class="form-groupinput-append date" data-date-format="dd-mm-yyyy">
              <label for="recipient_data_compra" class="control-label">Data da compra:</label>
              <input type="date" name="data_compra" max="<?php echo date("Y-m-d"); ?>" required class="form-control" id="data_compra">
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
<!-- MODAL ADICIONAR compra FIM -->

<!-- TRATATIVA PARA PREÇO CHAMANDA: onKeyUp="mascaraMoeda(this, event)" -->
<script type="text/javascript">

String.prototype.reverse = function(){
return this.split('').reverse().join('');
};

function mascaraMoeda(campo,evento){
var tecla = (!evento) ? window.event.keyCode : evento.which;
var valor  =  campo.value.replace(/[^\d]+/gi,'').reverse();
var resultado  = "";
var mascara = "########.##".reverse();
for (var x=0, y=0; x<mascara.length && y<valor.length;) {
  if (mascara.charAt(x) != '#') {
    resultado += mascara.charAt(x);
    x++;
  } else {
    resultado += valor.charAt(y);
    y++;
    x++;
  }
}
campo.value = resultado.reverse();
}


</script>

<?php
require "./footer.php";         // (3) Include the footer
?>
