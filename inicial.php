<?php
$title = "Ateliê dos Estofados Bem Vindo";
include 'header.php';                 // (2) Include the header
require './conexao/banco.php';

?>

<div class="table-responsive-xl container theme-showcase" role="main">

  <table align="center" class="table-sm" class="display">
    <tr>
      <th><button type="button" class="btn btn-primary view_data" onclick="window.location.href='estofados.php'">ESTOFADOS</button></th>
      <th><button type="button" class="btn btn-primary view_data" onclick="window.location.href='automoveis.php'" >AUTOMOVEIS</button></th>
    </tr>&nbsp&nbsp&nbsp
    <td>
      &nbsp&nbsp
    </td>

  </table>
</div>


<?php
include 'footer.php'
?>
