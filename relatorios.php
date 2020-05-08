<script>
function submitar( idPagina ){
 document.getElementById('pagina').value=idPagina;
 document.getElementById('pesquisa_orcamento').submit()
}
</script>
<script type="text/javascript" src="https://kryogenix.org/code/browser/sorttable/sorttable.js"></script> <!-- ordena a tabela chamada em class = 'sortable' -->
<?php
$title = "Relatório de Vendas";          // (1) Set the title
require './header.php';                 // (2) Include the header
require './conexao/banco.php';


@$pesq = $_GET['pesquisa'];
@$pesq_mes1 = $_GET['pesq_mes'];
if ($pesq_mes1 == '') {
  $pesq_mes = 12;
}else {
  $pesq_mes = $pesq_mes1;
}
//echo $pesq_mes;
@$pesq_ano = $_GET['mostra_ano'];
if ($pesq_mes != null || $pesq_ano != null || $pesq != null) {// SE HOUVER ALGUMA PESQUISA

  //paginação tabela orcamentos
  $pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1;

  //Selecionar todos os orcamentos da tabela
  $result_orcamentos = "SELECT data_orca, nome_mat, SUM(quantidade_mat), SUM(total_mat) FROM orcamento_material INNER JOIN material RIGHT JOIN orcamento ON material_id = id_material AND id_orcamento = orcamento_id AND month(data_orca) BETWEEN '01' AND '$pesq_mes' AND Year(data_orca) = '$pesq_ano' AND nome_mat LIKE '%$pesq%' GROUP BY nome_mat  ";
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
  $result_orcamentos = "SELECT data_orca, nome_mat, SUM(quantidade_mat), SUM(total_mat) FROM orcamento_material INNER JOIN material RIGHT JOIN orcamento ON material_id = id_material AND id_orcamento = orcamento_id AND month(data_orca) BETWEEN '01' AND '$pesq_mes' AND Year(data_orca) = '$pesq_ano' AND nome_mat LIKE '%$pesq%' GROUP BY nome_mat LIMIT $incio, $quantidade_pg";
  $resultado_orcamentos = mysqli_query($conn, $result_orcamentos);

}else {

//paginação tabela orcamentos
$pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1;

//Selecionar todos os orcamentos da tabela
$result_orcamentos = "SELECT data_orca, nome_mat, SUM(quantidade_mat), SUM(total_mat) FROM orcamento_material INNER JOIN material RIGHT JOIN orcamento ON material_id = id_material AND id_orcamento = orcamento_id GROUP BY nome_mat";
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
$result_orcamentos = "SELECT data_orca, nome_mat, SUM(quantidade_mat), SUM(total_mat) FROM orcamento_material INNER JOIN material RIGHT JOIN orcamento ON material_id = id_material AND id_orcamento = orcamento_id GROUP BY nome_mat LIMIT $incio, $quantidade_pg";
  //INNER JOIN orcamento_material ON id_orcamento = orcamento_id";
  //INNER JOIN material ON nome_mat = (SELECT nome_mat FROM material WHERE id_material = material_id) LIMIT $incio, $quantidade_pg";
$resultado_orcamentos = mysqli_query($conn, $result_orcamentos);

}

?>



<h2 style="text-align:center;"> Relatório de Vendas</h2>
<div class="table-responsive-xl container theme-showcase" role="main">

<a href="./relatorio_orca.php">
<button href="relatorio_orca.php" class="btn btn-primary">RELATÓRIO DE ORCAMENTOS</button>
</a>

  <form class="pesq" id="pesquisa_cliente" method="get" action="#">
    MATERIAL &nbsp<input type="text" name="pesquisa" id="pesquisa" value="<?php echo $pesq; ?>"></input> &nbsp

      <select id="pesq_mes" name="pesq_mes">
      <option value=""></option>
      <option value="01">JANEIRO</option>
      <option value="02">FEVEREIRO</option>
      <option value="03">MARÇO</option>
      <option value="04">ABRIL</option>
      <option value="05">MAIO</option>
      <option value="06">JUNHO</option>
      <option value="07">JULHO</option>
      <option value="08">AGOSTO</option>
      <option value="09">SETEMBRO</option>
      <option value="10">OUTUBRO</option>
      <option value="11">NOVEMBRO</option>
      <option value="12">DEZEMBRO</option>
      </select>

      <select id="mostra_ano" name="mostra_ano">
        <?php
        $sql = " SELECT DISTINCT Year(data_orca) FROM orcamento";
        $result_sql = mysqli_query($conn, $sql);

        while ($ano = mysqli_fetch_array($result_sql)) {?>
          <option value="<?php echo $ano['Year(data_orca)']; ?>"><?php echo $ano['Year(data_orca)'];  ?></option><?php
        }
        ?>
      </select>
      <input type="hidden" name="pagina" id="pagina"></input>
      <button type="hide" onclick="submitar(1)"> pesquisar </button>
  </form>


  <table align="center" border="3" class="sortable table table-hover table table-sm" id="listar_clientes" class="display">
    <tr>
      <th>Material</th>
      <th>Quantidade</th>
      <th>TOTAL(R$)</th>
    </tr>


    <?php while ($orcamento = mysqli_fetch_array($resultado_orcamentos)) {?>
      <tr>
        <td><?php echo $orcamento['nome_mat']; ?></td>
        <td><?php echo $orcamento['SUM(quantidade_mat)']; ?></td>
        <td><?php echo $orcamento['SUM(total_mat)']; ?></td>
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




<script>
function Mudarestado(el) {
  var display = document.getElementById(el).style.display;
  if (display == "none")
    document.getElementById(el).style.display = 'block';
  else
    document.getElementById(el).style.display = 'none';
}
      </script>
<?php
require "./footer.php";         // (3) Include the footer
?>
