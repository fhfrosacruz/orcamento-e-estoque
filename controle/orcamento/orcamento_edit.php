<?php
include '../../conexao/banco.php';


//tabela material
$id = mysqli_real_escape_string($conn, $_POST['id']);

$status = mysqli_real_escape_string($conn, $_POST['status']);
if ($status == '') {
  $status = 'AGUARDANDO';
}

if ($status == 'APROVADO') {

  $selc_count1 = "SELECT count FROM orcamento WHERE id_orcamento = '$id'";
  $selc_count = mysqli_query($conn, $selc_count1)or die( mysqli_error($conn));
  $resul_count = mysqli_fetch_assoc($selc_count);

          if ($resul_count['count'] == '0') {

          $aprov = "SELECT * FROM orcamento_material WHERE orcamento_id = '$id'";
          $faz = mysqli_query($conn, $aprov)or die( mysqli_error($conn));

            while ($atualiza = mysqli_fetch_assoc($faz)) {

              $selc_quant1 = "SELECT quantidade FROM material WHERE id_material = '$atualiza[material_id]'";
              $selc_quant = mysqli_query($conn, $selc_quant1)or die( mysqli_error($conn));
              $resul_quant = mysqli_fetch_assoc($selc_quant);

              $final = $resul_quant['quantidade'] - $atualiza['quantidade_mat'];


              $up = "UPDATE material SET quantidade = '$final'  WHERE id_material = '$atualiza[material_id]'";
              $ok = mysqli_query($conn, $up)or die( mysqli_error($conn));

              }


            $count1 = "UPDATE orcamento SET count = '1' WHERE id_orcamento = '$id'";
            $count = mysqli_query($conn, $count1)or die( mysqli_error($conn));
          }

 }

 if ($status == 'CANCELADO') {

   $selc_count1 = "SELECT count FROM orcamento WHERE id_orcamento = '$id'";
   $selc_count = mysqli_query($conn, $selc_count1)or die( mysqli_error($conn));
   $resul_count = mysqli_fetch_assoc($selc_count);

           if ($resul_count['count'] == '1') {

           $aprov = "SELECT * FROM orcamento_material WHERE orcamento_id = '$id'";
           $faz = mysqli_query($conn, $aprov)or die( mysqli_error($conn));

             while ($atualiza = mysqli_fetch_assoc($faz)) {

               $selc_quant1 = "SELECT quantidade FROM material WHERE id_material = '$atualiza[material_id]'";
               $selc_quant = mysqli_query($conn, $selc_quant1)or die( mysqli_error($conn));
               $resul_quant = mysqli_fetch_assoc($selc_quant);

               $final = $resul_quant['quantidade'] + $atualiza['quantidade_mat'];


               $up = "UPDATE material SET quantidade = '$final'  WHERE id_material = '$atualiza[material_id]'";
               $ok = mysqli_query($conn, $up)or die( mysqli_error($conn));

               }


             $count1 = "UPDATE orcamento SET count = '0' WHERE id_orcamento = '$id'";
             $count = mysqli_query($conn, $count1)or die( mysqli_error($conn));
           }


 }

$edita_material = "UPDATE orcamento SET status ='$status' WHERE id_orcamento = '$id'";
$edita_mat = mysqli_query($conn, $edita_material)or die( mysqli_error($conn));

/*
echo $id;
var_dump($edita_material);  ../../orcamentos.php?pesquisa=&pagina=1#
*/
mysqli_close($conn);
header('Location: ../../orcamentos.php');

?>
