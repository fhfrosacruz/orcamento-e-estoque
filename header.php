
<?php
@session_start();
require_once './arquivos_de_login/init.php';
require './check.php';
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 60000)) {
	    // last request was more than 10 minutes ago
	    session_unset();     // unset $_SESSION variable for the run-time
	    session_destroy();   // destroy session data in storage
			echo"<script type=\"text/javascript\">alert('TEMPO DE INATIVIDADE, FAÇA LOGIN NOVAMENTE'); window.location='index.php';</script>";
		//	header('Location: http://localhost/arquivos_de_login/form-login.php');
	}
	$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
?>
<!DOCTYPE html>
<html>
<head>
    	<title><?php echo $title; ?></title>
		  <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
      
			<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
			<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
			<!-- MEU CSS -->
      <link rel="stylesheet" type="text/css" href="./css/style.css">
      <!-- Bootstrap local -->
    	<link href="./css/bootstrap.min.css" rel="stylesheet">
			<!-- JavaScript local -->
			<script src="./js/tratativas.js"></script>

			<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
<!--
			<script type="text/javascript">
				jQuery(document).ready(function () {
					jQuery('#material55').change(function() {
						jQuery('#valor').val((jQuery(this).find(':selected').data('valor')));
					});
				});
			</script>
-->
	  </head>

<body>
  <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="inicial.php">Ateliê</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="clientes.php">Clientes</a>
      </li>
      <?php if ($_SESSION['user_nivel'] == '0') {?> <!-- SOMENTE O GERENTE ACESSA -->

      <li class="nav-item">
        <a class="nav-link" href="funcionarios.php">Funcionários</a>
      </li>
        <?php } ?>
      <li class="nav-item">
        <a class="nav-link" href="empresas.php">Empresas</a>
      </li>
			<?php if ($_SESSION['user_nivel'] == '0') {?> <!-- SOMENTE O GERENTE ACESSA -->

				<li class="nav-item">
	        <a class="nav-link" href="materiais.php">Estoque</a>
	      </li>

      <li class="nav-item">
        <a class="nav-link" href="compras.php">Compras</a>
      </li>
        <?php } ?>
			<li class="nav-item">
        <a class="nav-link" href="orcamentos.php">Orçamentos</a>
      </li>
			<?php if ($_SESSION['user_nivel'] == '0') {?> <!-- SOMENTE O GERENTE ACESSA -->

				<li class="nav-item">
					<a class="nav-link" href="relatorios.php">Relatórios</a>
				</li>

				<?php } ?>
    </ul>
    <ul class="nav pull-right">
      <li>
      <a href="#" data-toggle="dropdown"><i class="icon-unlock">&nbsp&nbsp</i><?php echo $_SESSION['user_name']; ?>&nbsp<?php if ($_SESSION['user_nivel'] == 0) {echo "(GERENTE)";}else{echo "(FUNCIONÁRIO)";} echo date("d/m/Y");?><i class="caret"></i></a>
      <ul class="dropdown-menu">
        <li><a href="./logout.php">Sair</a></li>
      </ul>
      </li>
    </ul>
    </nav>
    <br></br>
<!-- cabeçalho final -->
