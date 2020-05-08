<script>
function submitar( idPagina ){
 document.getElementById('pagina').value=idPagina;
 document.getElementById('pesquisa_material').submit()
}
</script>
<script type="text/javascript" src="https://kryogenix.org/code/browser/sorttable/sorttable.js"></script> <!-- ordena a tabela chamada em class = 'sortable' -->
<?php
$title = "material";          // (1) Set the title
require './header.php';                 // (2) Include the header
require './conexao/banco.php';

//redireciona se não tiver nivel de acesso correto
if ($_SESSION['user_nivel'] != '0') {
header('Location: ./inicial.php');
}

@$pesq = $_GET['pesquisa'];
if ($pesq != null) {

  //paginação tabela materiais
  $pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1;

  //Selecionar todos os materiais da tabela
  $result_materiais = "SELECT * FROM material WHERE nome_mat LIKE '%$pesq%'";
  $resultado_materiais = mysqli_query($conn, $result_materiais);

  //Contar o total de materiais
  $total_materiais = mysqli_num_rows($resultado_materiais);

  //Seta a quantidade de materiais por pagina
  $quantidade_pg = $total_materiais;

  //calcular o número de pagina necessárias para apresentar os materiais
  @$num_pagina = ceil($total_materiais/$quantidade_pg);

  //Calcular o inicio da visualizacao
  $incio = ($quantidade_pg*$pagina)-$quantidade_pg;

  //Selecionar os materiais a serem apresentado na página
  $result_materiais = "SELECT * FROM material WHERE nome_mat LIKE '%$pesq%' LIMIT $incio, $quantidade_pg";
  $resultado_materiais = mysqli_query($conn, $result_materiais);

} else {

//paginação tabela materiais
$pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1;

//Selecionar todos os materiais da tabela
$result_materiais = "SELECT * FROM material";
$resultado_materiais = mysqli_query($conn, $result_materiais);

//Contar o total de materiais
$total_materiais = mysqli_num_rows($resultado_materiais);

//Seta a quantidade de materiais por pagina
$quantidade_pg = $total_materiais;

//calcular o número de pagina necessárias para apresentar os materiais
@$num_pagina = ceil($total_materiais/$quantidade_pg);

//Calcular o inicio da visualizacao
$incio = ($quantidade_pg*$pagina)-$quantidade_pg;

//Selecionar os materiais a serem apresentado na página
$result_materiais = "SELECT * FROM material LIMIT $incio, $quantidade_pg";
$resultado_materiais = mysqli_query($conn, $result_materiais);

}
?>

<formbotao>
<button type="button" class="btn btn-primary view_data" id= "button_add" data-toggle="modal" data-target="#material_add_Modal">Cadastrar material</button>
</formbotao>
<br>



<div class="table-responsive-xl container theme-showcase" role="main">

  <form class="pesq" id="pesquisa_material" method="get" action="#">
      <input type="text" name="pesquisa" id="pesquisa" value="<?php echo $pesq; ?>"></input>
      <input type="hidden" name="pagina" id="pagina"></input>
      <button type="hide" onclick="submitar(1)"> pesquisar </button>
  </form>

  <table align="center" border="3" class="sortable table table-hover table table-sm" id="listar_clientes" class="display">
    <tr>
      <th>id</th>
      <th>nome</th>
      <th>Tipo</th>
      <th>Unidade de medida</th>
      <th>Quantidade</th>
      <th>Ação</th>
    </tr>

    <?php while ($material = mysqli_fetch_array($resultado_materiais)) {?>
      <tr>
        <td><?php echo $material['id_material']; ?></td>
        <td><?php echo $material['nome_mat']; ?></td>
        <td><?php echo $material['tipo']; ?></td>
        <td><?php echo $material['uni_medida']; ?></td>
        <td><?php echo $material['quantidade']; ?></td>
        <td>
          <div class="btn-group">
          <button type="button" class="btn-xs btn-outline-dark view_data" data-toggle="modal" data-target="#materialModal" data-id = "<?php echo $material['id_material']; ?>"
            data-nome_mat="<?php echo $material['nome_mat']; ?>" data-tipo="<?php echo $material['tipo']; ?>" data-uni_medida="<?php echo $material['uni_medida']; ?>" data-quantidade="<?php echo $material['quantidade']; ?>"
            >Editar</button>
          </div>
          </td>
        </tr>
      <?php } ?>
    </table>
</div>

<!-- Modal alerta exclusão
<div class="modal fade" id="alerta_Modal" tabindex="-1" role="dialog" aria-labelledby="alertaModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">ERRO AO EXCLUIR</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        VOCE NÃO PODE EXCLUIR ESTE MATERIAL, POIS ELE ESTA INSERIDO NA
        TABELA COMPRAS, POR FAVOR, VÁ ATÉ A ABA COMPRAS E DELETE TODAS AS COMPRAS
        REFERENTES A ESTE MATERIAL, ANTES DE PODER EXCLUI-LO.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
-->
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


<!-- MODAL EDITAR MATERIAL INICIO -->
  <div class="modal fade" id="materialModal" tabindex="-1" role="dialog" aria-labelledby="materialModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="materialModalLabel">Editar Material</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
            <span aria-hidden="true">&times;</span>
        </div>
        <div class="modal-body">
          <form method="POST" action="./controle/material/material_edit.php">
            <div class="form-group">
              <input type="hidden" name="id" class="form-control" id="id">
            </div>
            <div class="form-group">
              <label for="recipient_nome_mat" class="control-label">Nome do material:</label>
              <input name="nome_mat" class="form-control" id="nome_mat">
            </div>
            <div class="form-group">
              <label for="recipient_tipo" class="control-label">Tipo:</label>
              <input name="tipo" class="form-control" id="tipo">
            </div>
          <div class="form-group">
            <label for="recipient_uni_medida" class="control-label">Unidade de medida:</label>
            <select name="uni_medida" id="uni_medida" class="form-control">
              <option value="METROS³">METROS³</option>
              <option value="METROS²">METROS²</option>
              <option value="METROS">METROS</option>
              <option value="QUILOS">QUILOS</option>
              <option value="GRAMAS">GRAMAS</option>
              <option value="UNIDADES">UNIDADES</option>
            </select>
          </div>
            <div hidden class="form-group">
              <label for="recipient_quantidade" class="control-label">Quantidade:</label>
              <input min="0" type="number" name="quantidade" class="form-control" id="quantidade">
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
<!-- MODAL EDITAR material FIM -->

<!-- MODAL ADICIONAR material INICIO -->
  <div class="modal fade" id="material_add_Modal" tabindex="-1" role="dialog" aria-labelledby="material_add_ModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="material_add_ModalLabel">Adicionar Material</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
            <span aria-hidden="true">&times;</span>
        </div>
        <div class="modal-body">
          <form method="POST" action="./controle/material/material_add.php">
            <div class="form-group">
              <input type="hidden" name="id" class="form-control" id="id">
            </div>
            <div class="form-group">
              <label for="recipient_nome_mat" class="control-label">Nome do Material:</label>
              <input name="nome_mat" class="form-control" id="nome_mat">
            </div>
            <div class="form-group">
              <label for="recipient_tipo" class="control-label">Tipo:</label>
              <input name="tipo" class="form-control" id="tipo">
            </div>
            <div class="form-group">
              <label for="recipient_uni_medida" class="control-label">Unidade de medida:</label>
              <select name="uni_medida" id="uni_medida" class="form-control">
                <option value="METROS³">METROS³</option>
                <option value="METROS²">METROS²</option>
                <option value="METROS">METROS</option>
                <option value="QUILOS">QUILOS</option>
                <option value="GRAMAS">GRAMAS</option>
                <option value="UNIDADES">UNIDADES</option>
              </select>
            </div>
            <div class="form-group">
              <label hidden for="recipient_quantidade" class="control-label">Quantidade:</label>
              <input hidden value="0" name="quantidade" class="form-control" id="quantidade">
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
<!-- MODAL ADICIONAR material FIM -->

<?php
require "./footer.php";         // (3) Include the footer
?>
