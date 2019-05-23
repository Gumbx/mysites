﻿<?php
session_start();
require_once("../banco/config.php");
if(isset($_COOKIE['usuario'])&& isset($_COOKIE['senha'])){
	$usuario=base64_decode($_COOKIE['usuario']);
	$senha=base64_decode($_COOKIE['senha']);
}else{
	if(isset($_SESSION["usuario"])&&isset($_SESSION["senha"])){
		setcookie("usuario", $_SESSION["usuario"],time() + (86400 * 2),'/');
		setcookie("senha", $_SESSION["senha"],time() + (86400 * 2),'/');
		$usuario=base64_decode($_SESSION["usuario"]);
		$senha=base64_decode($_SESSION["senha"]);
	}
}
if(!isset($usuario) && !isset($senha)){
	header("Location:../login");
}else{
	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	$sql = "SELECT * FROM user WHERE usuario=? AND senha=?";
	$q = $pdo->prepare($sql);
	$q->execute(array($usuario,$senha));
	$data = $q->fetch(PDO::FETCH_ASSOC);//atribui um array associativo a var data
	$nome = $data["nome"];
	$cargo = $data["cargo"];
	Database::disconnect();	
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>SysShoes</title>
    <!-- Favicon-->
    <link rel="icon" href="../favicon.png" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="../plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="../plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="../plugins/animate-css/animate.css" rel="stylesheet" />
	
    <!-- Sweetalert Css -->
    <link href="../plugins/sweetalert/sweetalert.css" rel="stylesheet" />
	
    <!-- Morris Chart Css-->
    <link href="../plugins/morrisjs/morris.css" rel="stylesheet" />

	<!-- Bootstrap Select Css -->
    <link href="../plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
	
    <!-- Custom Css -->
    <link href="../css/style.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="../css/themes/all-themes.css" rel="stylesheet" />
</head>

<body class="theme-red">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Carregando...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Search Bar -->
    <div class="search-bar">
        <div class="search-icon">
            <i class="material-icons">search</i>
        </div>
        <input type="text" placeholder="START TYPING...">
        <div class="close-search">
            <i class="material-icons">close</i>
        </div>
    </div>
    <!-- #END# Search Bar -->
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="../">SysShoes</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- Call Search -->
                    <li><a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a></li>
                    <!-- #END# Call Search -->
                    <!-- Notifications -->
                    <!--<li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="material-icons">notifications</i>
                            <span class="label-count">7</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">NOTIFICATIONS</li>
                            <li class="body">
                                <ul class="menu">
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="icon-circle bg-light-green">
                                                <i class="material-icons">person_add</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4>12 new members joined</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> 14 mins ago
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="icon-circle bg-cyan">
                                                <i class="material-icons">add_shopping_cart</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4>4 sales made</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> 22 mins ago
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="icon-circle bg-red">
                                                <i class="material-icons">delete_forever</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4><b>Nancy Doe</b> deleted account</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> 3 hours ago
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="javascript:void(0);">View All Notifications</a>
                            </li>
                        </ul>
                    </li>-->
                    <!-- #END# Notifications -->
                </ul>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <img src="../images/user.png" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $nome; ?></div>
                    <div class="email"><?php echo $cargo; ?></div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="../perfil"><i class="material-icons">person</i>Perfil</a></li>
                            <li role="seperator" class="divider"></li>
                            <li><a href="../banco/logout"><i class="material-icons">input</i>Sair</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">MENU</li>
                    
					<li class="active">
                        <a href="../venda/vendas">
                            <i class="material-icons">payment</i>
                            <span>Venda</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">people</i>
                            <span>Clientes</span>
                        </a>
                        <ul class="ml-menu">
                            <li >
                                <a href="../cliente/cadastrar">Cadastrar cliente</a>
                            </li>
                            <li>
                                <a href="../cliente/procurar">Procurar cliente</a>
                            </li>
                        </ul>
                    </li>  
					<?php if($cargo=="Gerente" || $cargo=="Admin"){ ?>
					<li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">local_mall</i>
                            <span>Estoque</span><span style="color: red;font-size: 11px;">Gerente</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="../estoque/cadastrar">Cadastrar produto</a>
                            </li>
                            <li>
                                <a href="../estoque/procurar">Procurar produto</a>
                            </li>
                        </ul>
                    </li> 
					<?php } ?>
					<?php if($cargo=="Admin"){ ?>
					<li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">people_outline</i>
                            <span>Funcionários</span><span style="color: red;font-size: 11px;">Admin</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="../funcionario/cadastrar">Cadastrar funcionário</a>
                            </li>
                            <li>
                                <a href="../funcionario/procurar">Procurar funcionário</a>
                            </li>
                        </ul>
                    </li> 
					<?php } ?>

                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy; 2018 <a href="javascript:void(0);">SysShoes</a>. <b>Versão: </b> 1.0
                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->

    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>NOVA VENDA</h2>
            </div>
           <!-- cadastro -->
            <a href="procurar"><div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="body" style="cursor:pointer;text-align:center">
							<i class="material-icons">add_circle_outline</i>
							<span class="icon-namet">NOVA VENDA</span>
                        </div>
                    </div>
                </div>
            </div></a>
            <!-- #END# cadastro -->
			<div class="block-header">
                <h2>ULTIMAS VENDAS</h2>
            </div>
           <!-- cadastro -->
			<?php	
			$pdo = Database::connect();			
			$sql = "SELECT * FROM venda ORDER BY id_venda DESC";
			foreach($pdo->query($sql) as $row)
			{
				$sql = "SELECT * FROM produto WHERE id_produto=?";
				$q = $pdo->prepare($sql);
				$q->execute(array($row["id_produto"]));
				$data = $q->fetch(PDO::FETCH_ASSOC);//atribui um array associativo a var data
				$nomeproduto = $data["nome"];
				$marca = $data["marca"];
				$preco = $data["preco"];
				$sql = "SELECT * FROM cliente WHERE id_cliente=?";
				$q = $pdo->prepare($sql);
				$q->execute(array($row["id_cliente"]));
				$data = $q->fetch(PDO::FETCH_ASSOC);
				$nomecliente = $data["nome"];
				$cpf = $data["cpf"];
				$sql = "SELECT * FROM user WHERE id_user=?";
				$q = $pdo->prepare($sql);
				$q->execute(array($row["id_user"]));
				$data = $q->fetch(PDO::FETCH_ASSOC);
				$nomeuser = $data["nome"];
				$totalunidades=0;
				$sql2="SELECT * FROM venda_unidades WHERE id_venda=".$row["id_venda"];
				foreach($pdo->query($sql2) as $row2)
				{
					$totalunidades = $totalunidades + $row2["unidades"];
				}
				$precototal = $totalunidades * $preco;
				$desconto = ($precototal*$row["desconto"])/100;
				$precototal = $precototal - $desconto;
			?>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="body">
							<div class="row clearfix">
								<div class="col-sm-4">
									<div class="form-group">
										<div class="form-line">
											<b>ID da venda: <?php echo $row["id_venda"]; ?></b>
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<div class="form-line">
											<b>Hora: <?php echo $row["hora_venda"]; ?></b>
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group form-float">
										<div class="form-line">
											<b>Data: <?php echo $row["data_venda"]; ?></b>
										</div>
									</div>
								</div>
							</div>
							<div class="row clearfix">
								<div class="col-sm-6">
									<div class="form-group">
										<div class="form-line">
											<p>Nome do produto: <?php echo $nomeproduto; ?></p>
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<div class="form-line">
											<p>Marca: <?php echo $marca; ?></p>
										</div>
									</div>
								</div>
							</div>
							<div class="row clearfix">
								<div class="col-sm-4">
									<div class="form-group">
										<div class="form-line">
											<p>Nome do cliente: <?php echo $nomecliente; ?></p>
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<div class="form-line">
											<p>CPF: <?php echo $cpf; ?></p>
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<div class="form-line">
											<p>Vendedor: <?php echo $nomeuser; ?></p>
										</div>
									</div>
								</div>
							</div>
							<div class="row clearfix">
								<div class="col-sm-4">
									<div class="form-group">
										<div class="form-line">
											<p>Preço/unid: R$<?php echo $preco; ?></p>
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<div class="form-line">
											<p>Unidades: <?php echo $totalunidades; ?></p>
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<div class="form-line">
											<p>Desconto(%): <?php echo $row["desconto"]; ?></p>
										</div>
									</div>
								</div>					
							</div>
							<div class="row clearfix">
								<div class="col-sm-6">
									<div class="form-group">
										<div class="form-line">
											<b><p>Preço Total: R$<?php echo $precototal; ?></p></b>
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<div class="form-line">
											<b><p>Forma de pagamento: <?php echo $row["pagamento"]; ?></p></b>
										</div>
									</div>
								</div>
							</div>
                        </div>
                    </div>
                </div>
            </div>
			<?php } 
			Database::disconnect();	
			?>
            <!-- #END# cadastro -->
        </div>
    </section>

    <!-- Jquery Core Js -->
    <script src="../plugins/jquery/jquery.min.js"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Bootstrap Core Js -->
    <script src="../plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <script src="../plugins/bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="../plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="../plugins/node-waves/waves.js"></script>

	<!-- SweetAlert Plugin Js -->
    <script src="../plugins/sweetalert/sweetalert.min.js"></script>
	
    <!-- Autosize Plugin Js -->
    <script src="../plugins/autosize/autosize.js"></script>

    <!-- Moment Plugin Js -->
    <script src="../plugins/momentjs/moment.js"></script>
	
	<!-- Input Mask Plugin Js -->
    <script src="../plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>

    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="../plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

    <!-- Custom Js -->
    <script src="../js/admin.js"></script>
	<script src="../js/pages/forms/basic-form-elements.js"></script>
	<script src="../js/pages/ui/dialogs.js"></script>

    <!-- Demo Js -->
    <script src="../js/demo.js"></script>
<script type="text/javascript">
$(document).ready(function(){
		$('.cadastroForm').submit(function(e){
		e.preventDefault();
		var form = $(this);
		var ajaxUrl = form.attr('action');
		var formData = form.serialize();
        swal({
			title: "Salvar informações do cliente?",
			text: "Confira se todos os campos foram respondidos corretamente",
			showCancelButton: true,
			confirmButtonText: "Salvar",
			cancelButtonText: "Cancelar",
			closeOnConfirm: false,
			showLoaderOnConfirm: true,
		}, function () {
			$.post(ajaxUrl, formData, function(data){
				var data = $.parseJSON(data);
				if(data.success == 'success'){					
				swal({
						title: "Salvo com sucesso!",
					}, function () {
						window.location.href = 'perfil?id='+ data.idcliente;
					});
				}else{
					swal("Não foi possivel salvar");
				}							 
			});
		});
		});
});

</script>
</body>

</html>
<?php
}
?>