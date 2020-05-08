<?php
//referenciar o DomPDF com namespace
use Dompdf\Dompdf;

// include autoloader
require_once './dompdf/autoload.inc.php';
include './conexao/banco.php';

$orcamento_id = $_POST['visualiza_orc'];

$result_orcamentos = "SELECT * FROM orcamento
  INNER JOIN pessoa ON nome = (SELECT nome FROM pessoa WHERE id_pessoa = (SELECT pessoa_id FROM funcionario WHERE id_funcionario = funcionario_id))
  INNER JOIN orcamento_material ON id_orcamento = orcamento_id
  INNER JOIN material ON nome_mat = (SELECT nome_mat FROM material WHERE id_material = material_id) WHERE id_orcamento = '$orcamento_id'";
$resultado_orcamentos = mysqli_query($conn, $result_orcamentos);
$orcamento = mysqli_fetch_array($resultado_orcamentos);

$orc_mat1 = "SELECT * FROM orcamento_material WHERE orcamento_id = '$orcamento_id'";
$resul_orc_mat = mysqli_query($conn, $orc_mat1);

$tot_mat1 = "SELECT SUM(total_mat) FROM orcamento_material WHERE orcamento_id = '$orcamento_id'";
$tot_mat = mysqli_query($conn, $tot_mat1);
$soma_tot_mat1 = mysqli_fetch_assoc($tot_mat);
$soma_tot_mat = $soma_tot_mat1['SUM(total_mat)'];
$data = date ('d/m/Y', strtotime ($orcamento['data_orca']));
$observacao = $orcamento['observacao'];


//GERA O PDF DO ORÇAMENTO
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
 ?>
