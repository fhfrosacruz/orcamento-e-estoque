<?php
$title = "Relatório de Vendas";          // (1) Set the title
require './header.php';                 // (2) Include the header
require './conexao/banco.php';


 ?>

 <h2 style="text-align:center;"> Relatório de Orçamentos</h2>
 <div class="table-responsive-xl container theme-showcase" role="main">

 <form class="pesq" id="pesquisa_cliente" method="get" action="#">

     MÊS<select id="pesq_mes" name="pesq_mes">
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

     ANO<select id="mostra_ano" name="mostra_ano">
       <?php
       $sql = " SELECT DISTINCT Year(data_orca) FROM orcamento";
       $result_sql = mysqli_query($conn, $sql);

       while ($ano = mysqli_fetch_array($result_sql)) {?>
         <option value="<?php echo $ano['Year(data_orca)']; ?>"><?php echo $ano['Year(data_orca)'];  ?></option><?php
       }
       ?>
     </select>

     <button type="hide"> pesquisar </button>
 </form>
</div>

<?php
@$mes = $_GET['pesq_mes'];
@$ano = $_GET['mostra_ano'];

$sql_conclu2 = "SELECT count(status) FROM orcamento WHERE Month(data_orca) = '$mes' AND YEAR(data_orca) = '$ano' AND status LIKE 'CONCLUIDO%'";
$sql_conclu1 = mysqli_query($conn, $sql_conclu2);
$sql_conclu = mysqli_fetch_assoc($sql_conclu1);
if ($sql_conclu['count(status)'] == '') {
$sql_conclu['count(status)'] = '0';
}

$sql_aguarda2 = "SELECT count(status) FROM orcamento WHERE Month(data_orca) = '$mes' AND YEAR(data_orca) = '$ano' AND status LIKE 'AGUARDANDO%'";
$sql_aguarda1 = mysqli_query($conn, $sql_aguarda2);
$sql_aguarda = mysqli_fetch_assoc($sql_aguarda1);
if ($sql_aguarda['count(status)'] == '') {
$sql_aguarda['count(status)'] = '0';
}

$sql_cancela2 = "SELECT count(status) FROM orcamento WHERE Month(data_orca) = '$mes' AND YEAR(data_orca) = '$ano' AND status LIKE 'CANCELADO%'";
$sql_cancela1 = mysqli_query($conn, $sql_cancela2);
$sql_cancela = mysqli_fetch_assoc($sql_cancela1);
if ($sql_cancela['count(status)'] == '') {
$sql_cancela['count(status)'] = '0';
}

 ?>
<div id="piechart_3d" style="width: 900px; height: 500px;"></div>

<script>

    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ['Task', 'Hours per Day'],
        ['CONCLUIDO',     <?php echo $sql_conclu['count(status)']; ?>],
        ['AGUARDANDO',      <?php echo $sql_aguarda['count(status)']; ?>],
        ['CANCELADO',  <?php echo $sql_cancela['count(status)']; ?>]

      ]);

      var options = {
        title: 'ORÇAMENTOS PARA <?php echo $mes, - $ano; ?>',
        is3D: true,
      };

      var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
      chart.draw(data, options);
    }
  </script>
 <?php
 require "./footer.php";         // (3) Include the footer
 ?>
