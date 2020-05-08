<?php
//referenciar o DomPDF com namespace
use Dompdf\Dompdf;

// include autoloader
require_once '../../dompdf/autoload.inc.php';
include '../../conexao/banco.php';

session_start();

$funcionario_id= $_SESSION['user_funcionario_id'];
$func1 = "SELECT DISTINCT nome FROM funcionario f LEFT JOIN pessoa p ON f.pessoa_id = p.id_pessoa WHERE f.id_funcionario = '$funcionario_id'";
$func = mysqli_query($conn, $func1)or die( mysqli_error($conn));
$nome_funcionario = mysqli_fetch_assoc($func);
$data_orca= date("Y-m-d");
$mao_obra = $_POST['mao_obra'];
$status = 'AGUARDANDO';
$cria = 0.00;
$cliente_id1 = $_POST['cliente_orca'];
$empresa_id1 = $_POST['empresa_orca'];
$tipo1 = $_POST['tipo_orca'];
$tipo = strtoupper($tipo1);
$count = 0;


if ($cliente_id1 == '') {
  $cliente_id = $empresa_id1;
}else {
  $cliente_id = $cliente_id1;
}

$add = "INSERT INTO orcamento (data_orca, funcionario_id, cliente_nome, mao_obra, tipo_orca, observacao, valor_total, estoque, status, count)
VALUES ('$data_orca', '$funcionario_id', '$cliente_id', '$mao_obra', '$tipo', 'teste', '$cria', '', '$status', '0')";
$add_orca = mysqli_query($conn, $add)or die( mysqli_error($conn));
$orcamento_id = mysqli_insert_id($conn);//pega o id_orcamnto do que foi adicionado

//$query_id_orcamento = "SHOW TABLE STATUS LIKE 'orcamento'";
//$pega_id_orca = mysqli_query($conn, $query_id_orcamento)or die( mysqli_error($conn));
//$id_orc = mysqli_fetch_assoc($pega_id_orca);
//$orcamento_id = $id_orc['Auto_increment'];

//ASSENTOS
$assento = $_POST['assento'];
if ($assento > '4') {
$assento = $_POST['outros_assentos'];
}

if ($assento != '') {

$margem_ass = $_POST['medida_seg_ass'];


$assento_altura = $_POST['altura_ace'];
$conv_alt_ace = $assento_altura;
//$conv_tot_alt_ace = $conv_alt_ace * $assento;


$assento_largura = $_POST['largura_ace'];
$conv_lar_ace = $assento_largura / 100;
//$conv_tot_lar_ace = $conv_lar_ace * $assento;

$assento_profundidade = $_POST['profundidade_ace'];
$conv_pro_ace = $assento_profundidade / 100;
//$conv_tot_pro_ace = $conv_pro_ace * $assento;

$observacao_ace1 = "ASSENTO:  LARGURA: $assento_largura CM - ALTURA: $assento_altura CM - PROFUNDIDADE: $assento_profundidade CM";
$observacao_ace = strtoupper($observacao_ace1);

}else {
  $observacao_ace = '';

}

$assento_tecido = $_POST['tecido_assento'];
if ($assento_tecido != '') {



  $query = "SELECT SUM(preco_total) FROM compra WHERE material_id = '$assento_tecido'";
  $val1 = mysqli_query($conn, $query)or die( mysqli_error($conn));
  $val = mysqli_fetch_assoc($val1);

  $query2 = "SELECT * FROM material WHERE id_material = '$assento_tecido'";
  $qto1 = mysqli_query($conn, $query2)or die( mysqli_error($conn));
  $qto_tecido_ass = mysqli_fetch_assoc($qto1);

  $query3 = "SELECT SUM(quantidade_comp) FROM compra WHERE material_id = '$assento_tecido'";
  $qto2 = mysqli_query($conn, $query3)or die( mysqli_error($conn));
  $qto_tecido_ass1 = mysqli_fetch_assoc($qto2);

  if ($margem_ass == "") {
    $metro_quadrado = $conv_lar_ace * $conv_pro_ace;  //mertro quadrado sem margem de seguraça
    $tecido_ass = $metro_quadrado * $assento;
  }else {
    $metro_quadrado = (($conv_lar_ace * $conv_pro_ace) + $margem_ass);   //mertro quadrado
    $inteiro_div_ass = intdiv(($metro_quadrado * 10), 10);
    $tecido_ass = $inteiro_div_ass * $assento;
  }

  @$val_tot_tecido_ace = round((($val['SUM(preco_total)'] / $qto_tecido_ass1['SUM(quantidade_comp)']) * $tecido_ass), 2);// faz a conta e mostra so dois digitos depois da virgula ou ponto

   if (($qto_tecido_ass['quantidade'] - $tecido_ass) < 0) {
     $obs_estoc_tec_ass = "{$qto_tecido_ass1['SUM(quantidade_comp)']}  {$qto_tecido_ass['uni_medida']} DE {$qto_tecido_ass['nome_mat']} NO ESTOQUE, E O ORÇAMENTO É DE  {$tecido_ass}  {$qto_tecido_ass['uni_medida']} DE {$qto_tecido_ass['nome_mat']}";
     $count=+1;
 }else {
  $obs_estoc_tec_ass ='';
 }


  $add_orca_mat_prep = "INSERT INTO orcamento_material (orcamento_id, material_id, quantidade_mat, total_mat)
  VALUES ('$orcamento_id', '$assento_tecido', '$tecido_ass', '$val_tot_tecido_ace')";
  $add_orca_mat = mysqli_query($conn, $add_orca_mat_prep)or die( mysqli_error($conn));


}else {
  $val_tot_tecido_ace = 0;
}

$assento_enchimento = $_POST['enchimento_assento'];
if ($assento_enchimento != '') {



  $query = "SELECT SUM(preco_total) FROM compra WHERE material_id = '$assento_enchimento'";
  $val1 = mysqli_query($conn, $query)or die( mysqli_error($conn));
  $val = mysqli_fetch_assoc($val1);

  $query2 = "SELECT * FROM material WHERE id_material = '$assento_enchimento'";
  $qto1 = mysqli_query($conn, $query2)or die( mysqli_error($conn));
  $qto = mysqli_fetch_assoc($qto1);

  $query3 = "SELECT SUM(quantidade_comp) FROM compra WHERE material_id = '$assento_enchimento'";
  $qto4 = mysqli_query($conn, $query3)or die( mysqli_error($conn));
  $qto3 = mysqli_fetch_assoc($qto4);

  $espuma_ass1 = ($conv_lar_ace * $conv_pro_ace) * $conv_alt_ace; //metro cubico
  $espuma_ass = ($espuma_ass1 / 100) * $assento; //kilos por metro cubico

  @$val_tot_enchimento_ace = round((($val['SUM(preco_total)'] / $qto['SUM(quantidade_comp)']) * $espuma_ass) * $assento, 2);// faz a conta e mostra so dois digitos depois da virgula ou ponto

   if (($qto['quantidade'] - $espuma_ass) < 0) {
     $obs_estoc_esp_ass = "{$qto3['SUM(quantidade_comp)']}  {$qto['uni_medida']} DE {$qto['nome_mat']} NO ESTOQUE, E O ORÇAMENTO É DE  {$espuma_ass}  {$qto['uni_medida']} DE {$qto['nome_mat']}";
     $count=+1;
 }else {
  $obs_estoc_esp_ass ='';
 }


  $add_orca_mat_prep = "INSERT INTO orcamento_material (orcamento_id, material_id, quantidade_mat, total_mat)
  VALUES ('$orcamento_id', '$assento_enchimento', '$espuma_ass', '$val_tot_enchimento_ace')";
  $add_orca_mat = mysqli_query($conn, $add_orca_mat_prep)or die( mysqli_error($conn));

}else {
  $val_tot_enchimento_ace = 0;
}

$assento_ziper1 = mysqli_real_escape_string($conn, $_POST['assento_ziper']);
if ($assento_ziper1 != '') {

  $assento_ziper = strtoupper($assento_ziper1);

  $query = "SELECT SUM(preco_total) FROM compra WHERE material_id = '$assento_ziper'";
  $val1 = mysqli_query($conn, $query)or die( mysqli_error($conn));
  $val = mysqli_fetch_assoc($val1);

  $query2 = "SELECT * FROM material WHERE id_material = '$assento_ziper'";
  $qto1 = mysqli_query($conn, $query2)or die( mysqli_error($conn));
  $qto = mysqli_fetch_assoc($qto1);

  $query3 = "SELECT SUM(quantidade_comp) FROM compra WHERE material_id = '$assento_ziper'";
  $qto4 = mysqli_query($conn, $query3)or die( mysqli_error($conn));
  $qto3 = mysqli_fetch_assoc($qto4);

  @$val_tot_ziper_ace = round(((($val['SUM(preco_total)'] / $qto['quantidade']) * $conv_lar_ace) * $assento), 2);// faz a conta e mostra so dois digitos depois da virgula ou ponto
  $conv_lar_ace1 = $conv_lar_ace * $assento;

  if (($qto['quantidade'] - $conv_lar_ace1) < 0) {
    $obs_estoc_zip_ass = "{$qto['quantidade']}  {$qto['uni_medida']} DE {$qto['nome_mat']} NO ESTOQUE, E O ORÇAMENTO É DE  {$conv_lar_ace1}  {$qto['uni_medida']} DE {$qto['nome_mat']}";
    $count=+1;
}else {
 $obs_estoc_zip_ass ='';
}

  $add_orca_mat_prep = "INSERT INTO orcamento_material (orcamento_id, material_id, quantidade_mat, total_mat)
  VALUES ('$orcamento_id', '$assento_ziper', '$conv_lar_ace1', '$val_tot_ziper_ace')";
  $add_orca_mat = mysqli_query($conn, $add_orca_mat_prep)or die( mysqli_error($conn));

}else {
  $val_tot_ziper_ace = 0;
}

    $assento_botao1 = $_POST['assento_botao'];
    if ($assento_botao1 != '') {

    $assento_botao_qto = $_POST['qto_botao_assento'];
    $assento_botao = strtoupper($assento_botao1);

    $query = "SELECT SUM(preco_total) FROM compra WHERE material_id = '$assento_botao'";
    $val1 = mysqli_query($conn, $query)or die( mysqli_error($conn));
    $val = mysqli_fetch_assoc($val1);

    $query2 = "SELECT SUM(quantidade_comp) FROM compra WHERE material_id = '$assento_botao'";
    $qto1 = mysqli_query($conn, $query2)or die( mysqli_error($conn));
    $qto = mysqli_fetch_assoc($qto1);

    $query3 = "SELECT * FROM material WHERE id_material = '$assento_botao'";
    $qto2 = mysqli_query($conn, $query3)or die( mysqli_error($conn));
    $qto3 = mysqli_fetch_assoc($qto2);

    @$val_tot_botao_ace = round((($val['SUM(preco_total)'] / $qto['SUM(quantidade_comp)']) * $assento_botao_qto) * $assento, 2);
    $assento_botao_qto1 = $assento_botao_qto * $assento;

    if (($qto['quantidade'] - $assento_botao_qto1) < 0) {
      $obs_estoc_bot_ass = "{$qto['SUM(quantidade_comp)']}  {$qto3['uni_medida']} DE {$qto3['nome_mat']} NO ESTOQUE, E O ORÇAMENTO É DE  {$assento_botao_qto1}  {$qto3['uni_medida']} DE {$qto3['nome_mat']}";
      $count=+1;
  }else {
   $obs_estoc_bot_ass ='';
  }

    $add_orca_mat_prep = "INSERT INTO orcamento_material (orcamento_id, material_id, quantidade_mat, total_mat)
    VALUES ('$orcamento_id', '$assento_botao', '$assento_botao_qto1', '$val_tot_botao_ace')";
    $add_orca_mat = mysqli_query($conn, $add_orca_mat_prep)or die( mysqli_error($conn));

}else {
  $val_tot_botao_ace = 0;
}


// ENCOSTO
$encosto = $_POST['encosto'];
if ($encosto > '4') {
$encosto = $_POST['outros_encostos'];
}

if ($encosto != '') {

$margem_enc = $_POST['medida_seg_enc'];

$encosto_altura = $_POST['altura_enc'];
$conv_alt_enc = $encosto_altura;


$encosto_largura = $_POST['largura_enc'];
$conv_lar_enc = $encosto_largura / 100;


$encosto_profundidade = $_POST['profundidade_enc'];
$conv_pro_enc = $encosto_profundidade / 100;


$observacao_enc1 = "ENCOSTO:  LARGURA: $encosto_largura CM - ALTURA: $encosto_altura CM - PROFUNDIDADE: $encosto_profundidade CM";
$observacao_enc = strtoupper($observacao_enc1);
}else {
  $observacao_enc = '';
}

$encosto_tecido = $_POST['tecido_encosto'];
if ($encosto_tecido != '') {



  $query = "SELECT SUM(preco_total) FROM compra WHERE material_id = '$encosto_tecido'";
  $val1 = mysqli_query($conn, $query)or die( mysqli_error($conn));
  $val = mysqli_fetch_assoc($val1);

  $query2 = "SELECT * FROM material WHERE id_material = '$encosto_tecido'";
  $qto1 = mysqli_query($conn, $query2)or die( mysqli_error($conn));
  $qto = mysqli_fetch_assoc($qto1);

  $query3 = "SELECT SUM(quantidade_comp) FROM compra WHERE material_id = '$encosto_tecido'";
  $qto2 = mysqli_query($conn, $query3)or die( mysqli_error($conn));
  $qto4 = mysqli_fetch_assoc($qto2);

  if ($margem_enc == "") {
    $metro_quadrado = $conv_lar_enc * $conv_pro_enc;  //mertro quadrado sem margem de seguraça
    $tecido_enc = $metro_quadrado * $encosto;
  }else {
    $metro_quadrado_enc = (($conv_lar_enc * $conv_pro_enc) + $margem_enc);   //mertro quadrado
    $inteiro_div_enc = intdiv(($metro_quadrado_enc * 10), 10);
    $tecido_enc = $inteiro_div_enc * $encosto;
  }

  //$tecido_enc = $conv_tot_lar_enc * $conv_tot_pro_enc; //mertro quadrado

  @$val_tot_tecido_enc = round((($val['SUM(preco_total)'] / $qto4['SUM(quantidade_comp)']) * $tecido_enc), 2);// faz a conta e mostra so dois digitos depois da virgula ou ponto

  if (($qto['quantidade'] - $tecido_enc) < 0) {
    $obs_estoc_tec_enc = "{$qto4['SUM(quantidade_comp)']}  {$qto['uni_medida']} DE {$qto['nome_mat']} NO ESTOQUE, E O ORÇAMENTO É DE  {$tecido_enc}  {$qto['uni_medida']} DE {$qto['nome_mat']}";
    $count=+1;
}else {
 $obs_estoc_tec_enc ='';
}

  $add_orca_mat_prep = "INSERT INTO orcamento_material (orcamento_id, material_id, quantidade_mat, total_mat)
  VALUES ('$orcamento_id', '$encosto_tecido', '$tecido_enc', '$val_tot_tecido_enc')";
  $add_orca_mat = mysqli_query($conn, $add_orca_mat_prep)or die( mysqli_error($conn));

}else {
  $val_tot_tecido_enc = 0;
}

$encosto_enchimento1 = $_POST['enchimento_encosto'];
if ($encosto_enchimento1 != '') {

  $encosto_enchimento = strtoupper($encosto_enchimento1);

  $query = "SELECT SUM(preco_total) FROM compra WHERE material_id = '$encosto_enchimento'";
  $val1 = mysqli_query($conn, $query)or die( mysqli_error($conn));
  $val = mysqli_fetch_assoc($val1);

  $query2 = "SELECT * FROM material WHERE id_material = '$encosto_enchimento'";
  $qto1 = mysqli_query($conn, $query2)or die( mysqli_error($conn));
  $qto = mysqli_fetch_assoc($qto1);

  $query3 = "SELECT SUM(quantidade_comp) FROM compra WHERE material_id = '$encosto_enchimento'";
  $qto2 = mysqli_query($conn, $query3)or die( mysqli_error($conn));
  $qto4 = mysqli_fetch_assoc($qto2);

  $espuma_enc1 = ($conv_lar_enc * $conv_pro_enc) * $conv_alt_enc; //merto cubico
  $espuma_enc = ($espuma_enc1 / 100) * $encosto; //kilos por metro cubico

  @$val_tot_enchimento_enc = round((($val['SUM(preco_total)'] / $qto4['SUM(quantidade_comp)']) * $espuma_enc) * $encosto, 2);// faz a conta e mostra so dois digitos depois da virgula ou ponto

  if (($qto['quantidade'] - $espuma_enc) < 0) {
    $obs_estoc_esp_enc = "{$qto4['SUM(quantidade_comp)']}  {$qto['uni_medida']} DE {$qto['nome_mat']} NO ESTOQUE, E O ORÇAMENTO É DE  {$espuma_enc}  {$qto['uni_medida']} DE {$qto['nome_mat']}";
    $count=+1;
}else {
 $obs_estoc_esp_enc ='';
}

  $add_orca_mat_prep = "INSERT INTO orcamento_material (orcamento_id, material_id, quantidade_mat, total_mat)
  VALUES ('$orcamento_id', '$encosto_enchimento', '$espuma_enc', '$val_tot_enchimento_enc')";
  $add_orca_mat = mysqli_query($conn, $add_orca_mat_prep)or die( mysqli_error($conn));

}else {
  $val_tot_enchimento_enc = 0;
}


$encosto_ziper1 = $_POST['encosto_ziper'];
if ($encosto_ziper1 != '') {

  $encosto_ziper = strtoupper($encosto_ziper1);

  $query = "SELECT SUM(preco_total) FROM compra WHERE material_id = '$encosto_ziper'";
  $val1 = mysqli_query($conn, $query)or die( mysqli_error($conn));
  $val = mysqli_fetch_assoc($val1);

  $query2 = "SELECT * FROM material WHERE id_material = '$encosto_ziper'";
  $qto1 = mysqli_query($conn, $query2)or die( mysqli_error($conn));
  $qto = mysqli_fetch_assoc($qto1);

  $query3 = "SELECT SUM(quantidade_comp) FROM compra WHERE material_id = '$encosto_ziper'";
  $qto2 = mysqli_query($conn, $query3)or die( mysqli_error($conn));
  $qto4 = mysqli_fetch_assoc($qto2);

  $val_tot_ziper_enc = round(((($val['SUM(preco_total)'] / $qto4['SUM(quantidade_comp)']) * $conv_lar_enc) * $encosto), 2);// faz a conta e mostra so dois digitos depois da virgula ou ponto
  $conv_lar_enc1 = $conv_lar_enc * $encosto;

  if (($qto['quantidade'] - $conv_lar_enc1) < 0) {
    $obs_estoc_zip_enc = "{$qto4['SUM(quantidade_comp)']}  {$qto['uni_medida']} DE {$qto['nome_mat']} NO ESTOQUE, E O ORÇAMENTO É DE  {$conv_lar_enc1}  {$qto['uni_medida']} DE {$qto['nome_mat']}";
}else {
 $obs_estoc_zip_enc ='';
}

  $add_orca_mat_prep = "INSERT INTO orcamento_material (orcamento_id, material_id, quantidade_mat, total_mat)
  VALUES ('$orcamento_id', '$encosto_ziper', '$conv_lar_enc1', '$val_tot_ziper_enc')";
  $add_orca_mat = mysqli_query($conn, $add_orca_mat_prep)or die( mysqli_error($conn));

}else {
  $val_tot_ziper_enc = 0;
}

    $encosto_botao1 = $_POST['encosto_botao'];
    if ($encosto_botao1 != '') {

    $encosto_botao_qto = $_POST['qto_botao_encosto'];
    $encosto_botao = strtoupper($encosto_botao1);

    $query = "SELECT SUM(preco_total) FROM compra WHERE material_id = '$encosto_botao'";
    $val1 = mysqli_query($conn, $query)or die( mysqli_error($conn));
    $val = mysqli_fetch_assoc($val1);

    $query2 = "SELECT * FROM material WHERE id_material = '$encosto_botao'";
    $qto1 = mysqli_query($conn, $query2)or die( mysqli_error($conn));
    $qto = mysqli_fetch_assoc($qto1);

    $query3 = "SELECT SUM(quantidade_comp) FROM compra WHERE material_id = '$encosto_botao'";
    $qto2 = mysqli_query($conn, $query3)or die( mysqli_error($conn));
    $qto4 = mysqli_fetch_assoc($qto2);

    @$val_tot_botao_enc = round((($val['SUM(preco_total)'] / $qto4['SUM(quantidade_comp)']) * $encosto_botao_qto) * $encosto, 2);
    $encosto_botao_qto1 = $encosto_botao_qto * $encosto;

    if (($qto['quantidade'] - $encosto_botao_qto1) < 0) {
      $obs_estoc_bot_enc = "{$qto4['SUM(quantidade_comp)']}  {$qto['uni_medida']} DE {$qto['nome_mat']} NO ESTOQUE, E O ORÇAMENTO É DE  {$encosto_botao_qto1}  {$qto['uni_medida']} DE {$qto['nome_mat']}";
      $count=+1;
  }else {
   $obs_estoc_bot_enc ='';
  }

    $add_orca_mat_prep = "INSERT INTO orcamento_material (orcamento_id, material_id, quantidade_mat, total_mat)
    VALUES ('$orcamento_id', '$encosto_botao', '$encosto_botao_qto1', '$val_tot_botao_enc')";
    $add_orca_mat = mysqli_query($conn, $add_orca_mat_prep)or die( mysqli_error($conn));

}else {
  $val_tot_botao_enc = 0;
}


//ALMOFADA
$almofada = $_POST['almofada'];
if ($almofada > '4') {
$almofada = $_POST['outros_almofadas'];
}

if ($almofada != '') {

$margem_alm = $_POST['medida_seg_alm'];

$almofada_altura = $_POST['altura_alm'];
$conv_alt_alm = $almofada_altura;


$almofada_largura = $_POST['largura_alm'];
$conv_lar_alm = $almofada_largura / 100;


$almofada_profundidade = $_POST['profundidade_alm'];
$conv_pro_alm = $almofada_profundidade / 100;



$observacao_alm1 = "ALMOFADA:  LARGURA: $almofada_largura CM - ALTURA: $almofada_altura CM - PROFUNDIDADE: $almofada_profundidade CM";
$observacao_alm = strtoupper($observacao_alm1);
}else {
  $observacao_alm = '';
}

$almofada_tecido = $_POST['tecido_almofada'];
if ($almofada_tecido != '') {

//  $almofada_tecido = strtoupper($almofada_tecido1);

  $query = "SELECT SUM(preco_total) FROM compra WHERE material_id = '$almofada_tecido'";
  $val1 = mysqli_query($conn, $query)or die( mysqli_error($conn));
  $val = mysqli_fetch_assoc($val1);

  $query2 = "SELECT * FROM material WHERE id_material = '$almofada_tecido'";
  $qto1 = mysqli_query($conn, $query2)or die( mysqli_error($conn));
  $qto = mysqli_fetch_assoc($qto1);

  $query3 = "SELECT SUM(preco_total) FROM compra WHERE material_id = '$almofada_tecido'";
  $qto2 = mysqli_query($conn, $query3)or die( mysqli_error($conn));
  $qto4 = mysqli_fetch_assoc($qto2);

  if ($margem_alm == "") {
    $metro_quadrado_alm = $conv_lar_alm * $conv_pro_alm;  //mertro quadrado sem margem de seguraça
    $tecido_alm = $metro_quadrado_alm * $almofada;
  }else {
    $metro_quadrado_alm = (($conv_lar_alm * $conv_pro_alm) + $margem_alm);   //mertro quadrado
    $inteiro_div_alm = intdiv(($metro_quadrado_alm * 10), 10);
    $tecido_alm = $inteiro_div_alm * $almofada;
  }

  //$tecido_alm = $conv_tot_lar_alm * $conv_tot_pro_alm; // metro quadrado

  @$val_tot_tecido_alm = round((($val['SUM(preco_total)'] / $qto4['SUM(preco_total)']) * $tecido_alm), 2);// faz a conta e mostra so dois digitos depois da virgula ou ponto

  if (($qto['quantidade'] - $tecido_alm) < 0) {
    $obs_estoc_tec_alm = "{$qto4['SUM(preco_total)']}  {$qto['uni_medida']} DE {$qto['nome_mat']} NO ESTOQUE, E O ORÇAMENTO É DE  {$tecido_alm}  {$qto['uni_medida']} DE {$qto['nome_mat']}";
    $count=+1;
}else {
 $obs_estoc_tec_alm ='';
}


  $add_orca_mat_prep = "INSERT INTO orcamento_material (orcamento_id, material_id, quantidade_mat, total_mat)
  VALUES ('$orcamento_id', '$almofada_tecido', '$tecido_alm', '$val_tot_tecido_alm')";
  $add_orca_mat = mysqli_query($conn, $add_orca_mat_prep)or die( mysqli_error($conn));

}else {
  $val_tot_tecido_alm = 0;
}

$almofada_enchimento1 = $_POST['enchimento_almofada'];
if ($almofada_enchimento1 != '') {

  $almofada_enchimento = strtoupper($almofada_enchimento1);

  $query = "SELECT SUM(preco_total) FROM compra WHERE material_id = '$almofada_enchimento'";
  $val1 = mysqli_query($conn, $query)or die( mysqli_error($conn));
  $val = mysqli_fetch_assoc($val1);

  $query2 = "SELECT * FROM material WHERE id_material = '$almofada_enchimento'";
  $qto1 = mysqli_query($conn, $query2)or die( mysqli_error($conn));
  $qto = mysqli_fetch_assoc($qto1);

  $query3 = "SELECT SUM(quantidade_comp) FROM compra WHERE material_id = '$almofada_enchimento'";
  $qto2 = mysqli_query($conn, $query3)or die( mysqli_error($conn));
  $qto4 = mysqli_fetch_assoc($qto2);

  $espuma_alm1 = ($conv_lar_alm * $conv_pro_alm) * $conv_alt_alm; //metro cubico
  $espuma_alm = ($espuma_alm1 / 100) * $almofada; //kilos por metro cubico

  @$val_tot_enchimento_alm = round((($val['SUM(preco_total)'] / $qto4['SUM(quantidade_comp)']) * $espuma_alm) * $almofada, 2);// faz a conta e mostra so dois digitos depois da virgula ou ponto

  if (($qto['quantidade'] - $espuma_alm) < 0) {
    $obs_estoc_esp_alm = "{$qto4['SUM(quantidade_comp)']}  {$qto['uni_medida']} DE {$qto['nome_mat']} NO ESTOQUE, E O ORÇAMENTO É DE  {$espuma_alm}  {$qto['uni_medida']} DE {$qto['nome_mat']}";
    $count=+1;
}else {
 $obs_estoc_esp_alm ='';
}


  $add_orca_mat_prep = "INSERT INTO orcamento_material (orcamento_id, material_id, quantidade_mat, total_mat)
  VALUES ('$orcamento_id', '$almofada_enchimento', '$espuma_alm', '$val_tot_enchimento_alm')";
  $add_orca_mat = mysqli_query($conn, $add_orca_mat_prep)or die( mysqli_error($conn));

}else {
  $val_tot_enchimento_alm = 0;
}

$almofada_ziper1 = $_POST['almofada_ziper'];
if ($almofada_ziper1 != '') {

  $almofada_ziper = strtoupper($almofada_ziper1);

  $query = "SELECT SUM(preco_total) FROM compra WHERE material_id = '$almofada_ziper'";
  $val1 = mysqli_query($conn, $query)or die( mysqli_error($conn));
  $val = mysqli_fetch_assoc($val1);

  $query2 = "SELECT * FROM material WHERE id_material = '$almofada_ziper'";
  $qto1 = mysqli_query($conn, $query2)or die( mysqli_error($conn));
  $qto = mysqli_fetch_assoc($qto1);

  $query3 = "SELECT SUM(quantidade_comp) FROM compra WHERE material_id = '$almofada_ziper'";
  $qto2 = mysqli_query($conn, $query3)or die( mysqli_error($conn));
  $qto4 = mysqli_fetch_assoc($qto2);

  @$val_tot_ziper_alm = round(((($val['SUM(preco_total)'] / $qto4['SUM(quantidade_comp)']) * $conv_lar_alm) * $almofada), 2);// faz a conta e mostra so dois digitos depois da virgula ou ponto
  $conv_lar_alm1 = $conv_lar_alm * $almofada;

  if (($qto['quantidade'] - $conv_lar_alm1) < 0) {
    $obs_estoc_zip_alm = "{$qto4['SUM(quantidade_comp)']}  {$qto['uni_medida']} DE {$qto['nome_mat']} NO ESTOQUE, E O ORÇAMENTO É DE  {$conv_lar_alm1}  {$qto['uni_medida']} DE {$qto['nome_mat']}";
    $count=+1;
}else {
 $obs_estoc_zip_alm ='';
}

  $add_orca_mat_prep = "INSERT INTO orcamento_material (orcamento_id, material_id, quantidade_mat, total_mat)
  VALUES ('$orcamento_id', '$almofada_ziper', '$conv_lar_alm1', '$val_tot_ziper_alm')";
  $add_orca_mat = mysqli_query($conn, $add_orca_mat_prep)or die( mysqli_error($conn));

}else {
  $val_tot_ziper_alm = 0;
}

    $almofada_botao1 = $_POST['almofada_botao'];
    if ($almofada_botao1 != '') {

    $almofada_botao_qto = $_POST['qto_botao_almofada'];
    $almofada_botao = strtoupper($almofada_botao1);

    $query = "SELECT SUM(preco_total) FROM compra WHERE material_id = '$almofada_botao'";
    $val1 = mysqli_query($conn, $query)or die( mysqli_error($conn));
    $val = mysqli_fetch_assoc($val1);

    $query2 = "SELECT * FROM material WHERE id_material = '$almofada_botao'";
    $qto1 = mysqli_query($conn, $query2)or die( mysqli_error($conn));
    $qto = mysqli_fetch_assoc($qto1);

    $query3 = "SELECT SUM(quantidade_comp) FROM compra WHERE material_id = '$almofada_botao'";
    $qto2 = mysqli_query($conn, $query3)or die( mysqli_error($conn));
    $qto4 = mysqli_fetch_assoc($qto2);

    @$val_tot_botao_alm = round((($val['SUM(preco_total)'] / $qto4['SUM(quantidade_comp)']) * $almofada_botao_qto) * $almofada, 2);
    $almofada_botao_qto1 = $almofada_botao_qto * $almofada;

    if (($qto['quantidade'] - $almofada_botao_qto1) < 0) {
      $obs_estoc_bot_alm = "{$qto4['SUM(quantidade_comp)']}  {$qto['uni_medida']} DE {$qto['nome_mat']} NO ESTOQUE, E O ORÇAMENTO É DE {$almofada_botao_qto1}  {$qto['uni_medida']} DE {$qto['nome_mat']}";
      $count=+1;
  }else {
   $obs_estoc_bot_alm ='';
  }

    $add_orca_mat_prep = "INSERT INTO orcamento_material (orcamento_id, material_id, quantidade_mat, total_mat)
    VALUES ('$orcamento_id', '$almofada_botao', '$almofada_botao_qto1', '$val_tot_botao_alm')";
    $add_orca_mat = mysqli_query($conn, $add_orca_mat_prep)or die( mysqli_error($conn));

}else {
  $val_tot_botao_alm = 0;
}


//ESTRUTURA
$estrutura1 = $_POST['estrutura'];
if ($estrutura1 != '') {

  $estrutura = strtoupper($estrutura1);

  //$estrutura_largura = $_POST['largura_est'];

  $estrutura_comprimento = $_POST['comprimento_est'];

  $observacao_est = "ESTRUTURA  COMPRIMENTO: $estrutura_comprimento METROS";

  $query = "SELECT SUM(preco_total) FROM compra WHERE material_id = '$estrutura'";
  $val1 = mysqli_query($conn, $query)or die( mysqli_error($conn));
  $val = mysqli_fetch_assoc($val1);

  $query2 = "SELECT * FROM material WHERE id_material = '$estrutura'";
  $qto1 = mysqli_query($conn, $query2)or die( mysqli_error($conn));
  $qto = mysqli_fetch_assoc($qto1);

  $query3 = "SELECT SUM(quantidade_comp) FROM compra WHERE material_id = '$estrutura'";
  $qto2 = mysqli_query($conn, $query3)or die( mysqli_error($conn));
  $qto4 = mysqli_fetch_assoc($qto2);

  @$val_tot_est = round(($val['SUM(preco_total)'] / $qto4['SUM(quantidade_comp)']) * $estrutura_comprimento, 2);

  if (($qto['quantidade'] - $estrutura_comprimento) < 0) {
    $obs_estoc_est = "{$qto4['SUM(quantidade_comp)']}  {$qto['uni_medida']} DE {$qto['nome_mat']} NO ESTOQUE, E O ORÇAMENTO É DE {$estrutura_comprimento}  {$qto['uni_medida']} DE {$qto['nome_mat']}";
    $count=+1;
}else {
 $obs_estoc_est ='';
}

  $add_orca_mat_prep = "INSERT INTO orcamento_material (orcamento_id, material_id, quantidade_mat, total_mat)
  VALUES ('$orcamento_id', '$estrutura', '$estrutura_comprimento', '$val_tot_est')";
  $add_orca_mat = mysqli_query($conn, $add_orca_mat_prep)or die( mysqli_error($conn));

}else {
  $estrutura = '';
  $observacao_est = '';
  $val_tot_est = 0;
}


//TOTAL DO orcamento

$valor_total = $mao_obra + $val_tot_tecido_ace + $val_tot_enchimento_ace + $val_tot_ziper_ace + $val_tot_botao_ace + $val_tot_tecido_enc + $val_tot_enchimento_enc + $val_tot_ziper_enc + $val_tot_botao_enc + $val_tot_tecido_alm + $val_tot_enchimento_alm + $val_tot_ziper_alm + $val_tot_botao_alm + $val_tot_est;

$observacao = "$observacao_ace <br>  $observacao_enc   $observacao_alm   $observacao_est";

if ($count == 0) {
@$observacao_estoque = '';

}else {

@$observacao_estoque = "ESTOQUE INSUFICIENTE VOCE POSSUI: {$obs_estoc_tec_ass} {$obs_estoc_esp_ass} {$obs_estoc_zip_ass} {$obs_estoc_bot_ass} {$obs_estoc_tec_enc} {$obs_estoc_esp_enc} {$obs_estoc_zip_enc} {$obs_estoc_bot_enc} {$obs_estoc_tec_alm} {$obs_estoc_esp_alm} {$obs_estoc_zip_alm} {$obs_estoc_bot_alm} {$obs_estoc_est}";
//echo $observacao_estoque;
}

$add_update = "UPDATE orcamento SET id_orcamento = '$orcamento_id', data_orca = '$data_orca', funcionario_id = '$funcionario_id', cliente_nome = '$cliente_id', mao_obra = '$mao_obra', tipo_orca = '$tipo', observacao = '$observacao', valor_total = '$valor_total', estoque = '$observacao_estoque', status = '$status', count = '0' WHERE id_orcamento = '$orcamento_id'";
$add_orca_update = mysqli_query($conn, $add_update)or die( mysqli_error($conn));
//$orcamento_id = mysqli_insert_id($conn);//pega o id_orcamnto do que foi adicionado


$result_orcamentos = "SELECT * FROM orcamento
  INNER JOIN pessoa ON nome = (SELECT nome FROM pessoa WHERE id_pessoa = (SELECT pessoa_id FROM funcionario WHERE id_funcionario = funcionario_id))
  INNER JOIN orcamento_material ON id_orcamento = orcamento_id
  INNER JOIN material ON nome_mat = (SELECT nome_mat FROM material WHERE id_material = material_id) WHERE id_orcamento = '$orcamento_id'";
$resultado_orcamentos = mysqli_query($conn, $result_orcamentos);
$orcamento = mysqli_fetch_assoc($resultado_orcamentos);

$orc_mat1 = "SELECT * FROM orcamento_material WHERE orcamento_id = '$orcamento_id'";
$resul_orc_mat = mysqli_query($conn, $orc_mat1);

$tot_mat1 = "SELECT SUM(total_mat) FROM `orcamento_material` WHERE orcamento_id = '$orcamento_id'";
$tot_mat = mysqli_query($conn, $tot_mat1);
$soma_tot_mat1 = mysqli_fetch_assoc($tot_mat);
$soma_tot_mat = $soma_tot_mat1['SUM(total_mat)'];
$data = date ('d/m/Y', strtotime ($orcamento['data_orca']));

//var_dump($orcamento);


//Criando a Instancia
$dompdf = new DOMPDF();


$html= "<!DOCTYPE html>";
$html.= "<html lang= pt-br>";
$html.= "<head>";
$html.= "<meta charset= utf-8>";
$html.= "<title>Orçamento</title>";
$html.= "<style>";
$html.= "table, th, td {";
$html.= "border: 1px solid black;";
$html.= "border-collapse: collapse;";
$html.= "}";
$html.= "th, td {";
$html.= "padding: 5px;";
$html.= "text-align: left;";
$html.= "}";
$html.= "</style>";
$html.= "</head>";
$html.= "<body>";
$html.= "<h2>ORÇAMENTO ATELIÊ DOS ESTOFADOS</h2>";
$html.= "<h4>ORÇAMENTO PARA: $orcamento[tipo_orca]</h4>";
$html.= "<table style= width:100%>";
$html.= "<tr>";
$html.= "<th>id Orçamento</th>";
$html.= "<th>Funcionário</th>";
$html.= "<th>Cliente</th>";
$html.= "<th>Data do orçamento</th>";
$html.= "<th>Mão de obra (R$)</th>";
$html.= "<th>Total Materiais (R$)</th>";
$html.= "<th>Total do Orcamento (R$)</th>";
$html.= "</tr>";
$html.= "<tr>";
$html.= "<td> $orcamento[id_orcamento]</td>";
$html.= "<td> $orcamento[nome] </td>";
$html.= "<td> $orcamento[cliente_nome] </td>";
$html.= "<td> $data</td>";
$html.= "<td> $orcamento[mao_obra],00 </td>";
$html.= "<td> $soma_tot_mat </td>";
$html.= "<td> $orcamento[valor_total] </td>";
$html.= "</tr>";
$html.= "</table>";
$html.= "<br><br>";
$html.= "<h4>DESCRIÇÃO DOS  MATERIAIS</h4>";
$html.= "<table style= width:100%>";
$html.= "<tr>";
$html.= "<th>Material</th>";
$html.= "<th>Quantidade usada</th>";
$html.= "<th>Medida</th>";
$html.= "<th>Total (R$)</th>";
$html.= "</tr>";
$html.= "<tr><td> $orcamento[nome_mat]</td>";
$html.= "<td> $orcamento[quantidade_mat] </td>";
$html.= "<td> $orcamento[uni_medida] </td>";
$html.= "<td> $orcamento[total_mat] </td></tr>";
while ($orcamento = mysqli_fetch_assoc($resultado_orcamentos)) {
$html.= "<tr><td> $orcamento[nome_mat]</td>";
$html.= "<td> $orcamento[quantidade_mat] </td>";
$html.= "<td> $orcamento[uni_medida] </td>";
$html.= "<td> $orcamento[total_mat] </td></tr>";
}
$html.= "</table>";
$html.= "<br><br>";
$html.= "<table>";
$html.= "<tr>";
$html.= "<th>Observações</th>";
$html.= "</tr>";
$html.= "<tr>";
$html.= "<th>$observacao</th>";
$html.= "</tr>";
$html.= "</table>";
$html.= "<br><br>";
$html.= "Cnpj : 31.470.449/0001-47";
$html.= "</body>";
$html.= "</html>";


// Carrega seu HTML
$dompdf->load_html($html);


$dompdf->setPaper('A4', 'portrait'); //para paisagem trocar 'portrait' para 'landscape'
ob_clean();
//Renderizar o html
$dompdf->render();


//Exibibir a página
$dompdf->stream(
  "orcamento.pdf",
  array(
    "Attachment" => false //Para realizar o download somente alterar para true
  )
);



mysqli_close($conn);
//header('Location: ../../inicial.php?pesquisa=&pagina=1#');

 ?>
