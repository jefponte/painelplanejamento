<?php

define("DB_INI", "../painel_colog_db.ini");

include './classes/autoload.php';


$sessao = new Sessao();

if (isset($_GET['sair'])) {
	$sessao->mataSessao();
	header("location: .");
}
if (isset($_GET['pagina'])) {
	if ($_GET['pagina'] == 'ajax') {
		$controller = new MetaCustomController();
		$controller->atualizar();
		return;
	}
}
?>
<!doctype html>
<html lang="pt-br">

<head>
	<meta charset="utf-8">
	<title>PainelPDTI</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Raleway" />
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" type="text/css" href="css/style_dti.css" />
	<link rel="stylesheet" type="text/css" href="css/selectize.bootstrap3.css" />
	<link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

	<link rel="shortcut icon" href="img/favicon.ico" />
</head>

<body id="topo">

	<!--     Barra do Governo -->
	<div id="barra-brasil" style="background: #7F7F7F; height: 20px; padding: 0 0 0 10px; display: block;">
		<ul id="menu-barra-temp" style="list-style: none;">
			<li style="display: inline; float: left; padding-right: 10px; margin-right: 10px; border-right: 1px solid #EDEDED">
				<a href="http://brasil.gov.br" style="font-family: sans, sans-serif; text-decoration: none; color: white;">Portal
					do Governo Brasileiro</a>
			</li>
		</ul>
	</div>
	<!--     Fim da Barra do Governo -->

	<!-- 	TopBar -->
	<nav class="navbar navbar-expand-lg navbar-light navbar-custom">
		<a class="navbar-brand" href="https://unilab.edu.br"><img src="img/logo-unilab.png" width="300" alt="Logo da DTI"></a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse justify-content-center" id="navbarNav">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item active">
					<a class="nav-link" href="./">Início <span class="sr-only">(current)</span></a>
				</li>
				
				<?php

				if($sessao->getNivelAcesso() == Sessao::NIVEL_ADM){
					echo '
					<li class="nav-item">
					<a class="nav-link" href="?pagina=usuario">Usuários</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="?pagina=importar">Importar</a>
				</li>


					';
				}
				if($sessao->getNivelAcesso() == Sessao::NIVEL_DESLOGADO){
					echo 
					'<li class="nav-item">

					<button type="button" class="nav-link" data-toggle="modal" data-target="#modalLogin">
					Login
				  </button>

						
					</li>';
				}else{
					echo '				<li class="nav-item">
					<a class="nav-link" href="?sair=1">Sair</a>
				</li>
				';

				}
				
				
				?>
				


			</ul>
		</div>
		<a class="navbar-brand" href="https://unilab.edu.br"><img src="img/logo-proplan.png" width="300" alt="Logo da DTI"></a>
	</nav>
	<!-- 	Fim do TopBar -->



	<div class="py-2">
		<div class="container">
			<div class="card p-3 table-responsive">
				<h1 class="text-center">Painel de Acompanhamento de Metas</h1>

				<?php

				Main::mainApp();

				?>

			</div>
		</div>
	</div>





	<footer class="listra">
		<p class="text-center">DTI - Diretoria de Tecnologia da Informação/<?php echo date("Y"); ?></p>
	</footer>



	<!-- 	<footer class="listra"> -->
	<!-- 		<p class="text-center">DTI 2019/2020</p> -->
	<!-- 	</footer> -->


	<!-- Modal -->
	<div class="modal fade" id="modalMeta" tabindex="-1" role="dialog" aria-labelledby="labelModalMeta" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="labelModalMeta">Meta Detalhada</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<span id="textoCorpoModal"></span>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
				</div>
			</div>
		</div>
	</div>



	<!-- Modal -->
	<div class="modal fade" id="modalMensagem" tabindex="-1" role="dialog" aria-labelledby="modalMensagemLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modalMensagemLabel">Aviso</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<span id="modalMensagemTexto"></span>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
				</div>
			</div>
		</div>
	</div>






	<script src="js/jquery-3.4.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script src="js/selectize.js"></script>

	<script src="js/painel_pdti.js?121212"></script>
	<script src="js/editar_acoes.js?1585763212"></script>
	<script src="js/editar_nivel_usuario.js?1585763212"></script>
	<script src="js/barra_2.0.js"></script>


	<script src="vendor/datatables/jquery.dataTables.min.js"></script>
	<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
	<script src="js/datatables-demo.js"></script>
	<!-- Page level custom scripts -->

</body>

</html>