<?php
            
/**
 * Classe feita para manipulação do objeto Meta
 * feita automaticamente com programa gerador de software inventado por
 * @author Jefferson Uchôa Ponte <j.pontee@gmail.com>
 */



class MetaController {

	protected  $view;
    protected $dao;

	public function __construct(){
		$this->dao = new MetaDAO();
		$this->view = new MetaView();
	}


    public function deletar(){
	    if(!isset($_GET['deletar'])){
	        return;
	    }
        $selecionado = new Meta();
	    $selecionado->setId($_GET['deletar']);
        if(!isset($_POST['deletar_meta'])){
            $this->view->confirmarDeletar($selecionado);
            return;
        }
        if($this->dao->excluir($selecionado)){
            echo '<div class="alert alert-success" role="alert">
                        Meta excluído com sucesso!
                    </div>';
        }else{
            echo '
                    <div class="alert alert-danger" role="alert">
                        Falha ao tentar excluir   Meta 
                    </div>

                ';
        }
    	echo '<META HTTP-EQUIV="REFRESH" CONTENT="2; URL=index.php?pagina=meta">';
    }



	public function listar() 
    {
		$lista = $this->dao->retornaLista ();
		$this->view->exibirLista($lista);
	}


	public function cadastrar() {
            
        if(!isset($_POST['enviar_meta'])){
            $setorDao = new SetorDAO($this->dao->getConexao());
            $listaSetor = $setorDao->retornaLista();

            $this->view->mostraFormInserir($listaSetor);
		    return;
		}
		if (! ( isset ( $_POST ['descricao'] ) && isset ( $_POST ['data_inicio_planejado'] ) && isset ( $_POST ['data_fim_planejado'] ) && isset ( $_POST ['data_inicio'] ) && isset ( $_POST ['data_fim'] ) && isset ( $_POST ['priorizacao'] ) &&  isset($_POST ['setor_responsavel']))) {
			echo '
                <div class="alert alert-danger" role="alert">
                    Falha ao cadastrar. Algum campo deve estar faltando. 
                </div>

                ';
			return;
		}
            
		$meta = new Meta ();
		$meta->setDescricao ( $_POST ['descricao'] );
		$meta->setDataInicioPlanejado ( $_POST ['data_inicio_planejado'] );
		$meta->setDataFimPlanejado ( $_POST ['data_fim_planejado'] );
		$meta->setDataInicio ( $_POST ['data_inicio'] );
		$meta->setDataFim ( $_POST ['data_fim'] );
		$meta->setPriorizacao ( $_POST ['priorizacao'] );
		$meta->getSetorResponsavel()->setId ( $_POST ['setor_responsavel'] );
            
		if ($this->dao->inserir ( $meta ))
        {
			echo '

<div class="alert alert-success" role="alert">
  Sucesso ao inserir Meta
</div>

';
		} else {
			echo '

<div class="alert alert-danger" role="alert">
  Falha ao tentar Inserir Meta
</div>

';
		}
        echo '<META HTTP-EQUIV="REFRESH" CONTENT="3; URL=index.php?pagina=meta">';
	}



    
    public function main(){
        
        if (isset($_GET['selecionar'])){
            echo '<div class="row justify-content-center">';
                $this->selecionar();
            echo '</div>';
            return;
        }
        echo '
		<div class="row justify-content-center">';
        echo '<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">';
        
        if(isset($_GET['editar'])){
            $this->editar();
        }else if(isset($_GET['deletar'])){
            $this->deletar();
	    }else{
            $this->cadastrar();
        }
        $this->listar();
        
        echo '</div>';
        echo '</div>';
            
    }
    public static function mainREST()
    {
        if(!isset($_SERVER['PHP_AUTH_USER'])){
            header("WWW-Authenticate: Basic realm=\"Private Area\" ");
            header("HTTP/1.0 401 Unauthorized");
            echo '{"erro":[{"status":"error","message":"Authentication failed"}]}';
            return;
        }
        if($_SERVER['PHP_AUTH_USER'] == 'usuario' && ($_SERVER['PHP_AUTH_PW'] == 'senha@12')){
            header('Content-type: application/json');
            $controller = new MetaController();
            $controller->restGET();
            //$controller->restPOST();
            //$controller->restPUT();
            $controller->resDELETE();
        }else{
            header("WWW-Authenticate: Basic realm=\"Private Area\" ");
            header("HTTP/1.0 401 Unauthorized");
            echo '{"erro":[{"status":"error","message":"Authentication failed"}]}';
        }

    }

    public function selecionar(){
	    if(!isset($_GET['selecionar'])){
	        return;
	    }
        $selecionado = new Meta();
	    $selecionado->setId($_GET['selecionar']);
	        
        $this->dao->preenchePorId($selecionado);

        echo '<div class="col-xl-7 col-lg-7 col-md-12 col-sm-12">';
	    $this->view->mostrarSelecionado($selecionado);
        echo '</div>';
            

        $this->dao->buscarDemandantes($selecionado);
        $demandanteDao = new DemandanteDAO($this->dao->getConexao());
        $lista = $demandanteDao->retornaLista();
            
        echo '<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">';
        $this->view->exibirDemandantes($selecionado);
        echo '</div>';
            
            
        if(!isset($_POST['adddemandante']) && !isset($_GET['removerdemandante'])){
            echo '<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">';
            $this->view->adicionarDemandante($lista);
            echo '</div>';
        }else if(isset($_POST['adddemandante'])){
            $demandante = new Demandante();
            $demandante->setId($_POST['adddemandante']);
            if($this->dao->inserirDemandante($selecionado, $demandante)){
                echo '<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">';
    			$this->view->mensagem("Sucesso ao Inserir!");
                echo '</div>';
    		} else {
                echo '<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">';
    			$this->view->mensagem("Erro ao Inserir!");
                echo '</div>';
    		}
            echo '<META HTTP-EQUIV="REFRESH" CONTENT="2; URL=index.php?pagina=meta&selecionar='.$selecionado->getId().'">';
            return;
        }else  if(isset($_GET['removerdemandante'])){
            
            $demandante = new Demandante();
            $demandante->setId($_GET['removerdemandante']);
            if($this->dao->removerDemandante($selecionado, $demandante)){
                echo '<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">';
    			$this->view->mensagem("Sucesso ao Remover!");
                echo '</div>';
    		} else {
                echo '<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">';
    			$this->view->mensagem("Erro ao tentar Remover!");
                echo '</div>';
    		}
            echo '<META HTTP-EQUIV="REFRESH" CONTENT="2; URL=index.php?pagina=meta&selecionar='.$selecionado->getId().'">';
            return;
        }
                
                
        
            
    }

    public function editar(){
	    if(!isset($_GET['editar'])){
	        return;
	    }
        $selecionado = new Meta();
	    $selecionado->setId($_GET['editar']);
	    $this->dao->pesquisaPorId($selecionado);
	        
        if(!isset($_POST['editar_meta'])){
            $this->view->mostraFormEditar($selecionado);
            return;
        }
            
		if (! ( isset ( $_POST ['descricao'] ) && isset ( $_POST ['dataInicioPlanejado'] ) && isset ( $_POST ['dataFimPlanejado'] ) && isset ( $_POST ['dataInicio'] ) && isset ( $_POST ['dataFim'] ) && isset ( $_POST ['priorizacao'] ) &&  isset($_POST ['setor_responsavel']))) {
			echo "Incompleto";
			return;
		}

		$selecionado->setDescricao ( $_POST ['descricao'] );
		$selecionado->setDataInicioPlanejado ( $_POST ['dataInicioPlanejado'] );
		$selecionado->setDataFimPlanejado ( $_POST ['dataFimPlanejado'] );
		$selecionado->setDataInicio ( $_POST ['dataInicio'] );
		$selecionado->setDataFim ( $_POST ['dataFim'] );
		$selecionado->setPriorizacao ( $_POST ['priorizacao'] );
            
		if ($this->dao->atualizar ($selecionado ))
        {
            
			echo "Sucesso";
		} else {
			echo "Fracasso";
		}
        echo '<META HTTP-EQUIV="REFRESH" CONTENT="3; URL=index.php?pagina=meta">';
            
    }

	public function restGET()
    {

        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            return;
        }

        if(!isset($_REQUEST['api'])){
            return;
        }
        $url = explode("/", $_REQUEST['api']);
        if (count($url) == 0 || $url[0] == "") {
            return;
        }
        if ($url[1] != 'meta') {
            return;
        }

        if(isset($url[1])){
            $parametro = $url[1];
            $id = intval($parametro);
            $pesquisado = new Meta();
            $pesquisado->setId($id);
            $pesquisado = $this->dao->pesquisaPorId($pesquisado);
            if ($pesquisado == null) {
                echo "{}";
                return;
            }

            $pesquisado = array(
					'id' => $pesquisado->getId (), 
					'descricao' => $pesquisado->getDescricao (), 
					'dataInicioPlanejado' => $pesquisado->getDataInicioPlanejado (), 
					'dataFimPlanejado' => $pesquisado->getDataFimPlanejado (), 
					'dataInicio' => $pesquisado->getDataInicio (), 
					'dataFim' => $pesquisado->getDataFim (), 
					'priorizacao' => $pesquisado->getPriorizacao (), 
            
            
			);
            echo json_encode($pesquisado);
            return;
        }        
        $lista = $this->dao->retornaLista();
        $listagem = array();
        foreach ( $lista as $linha ) {
			$listagem ['lista'] [] = array (
					'id' => $linha->getId (), 
					'descricao' => $linha->getDescricao (), 
					'dataInicioPlanejado' => $linha->getDataInicioPlanejado (), 
					'dataFimPlanejado' => $linha->getDataFimPlanejado (), 
					'dataInicio' => $linha->getDataInicio (), 
					'dataFim' => $linha->getDataFim (), 
					'priorizacao' => $linha->getPriorizacao (), 
            
            
			);
		}
		echo json_encode ( $listagem );
    
		
		
		
		
	}

    public function resDELETE()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'DELETE') {
            return;
        }
        $path = explode('/', $_GET['api']);
        $parametro = "";
        if (count($path) < 2) {
            return;
        }
        $parametro = $path[1];
        if ($parametro == "") {
            return;
        }
    
        $id = intval($parametro);
        $pesquisado = new Meta();
        $pesquisado->setId($id);
        $pesquisado = $this->dao->pesquisaPorId($pesquisado);
        if ($pesquisado == null) {
            echo "{}";
            return;
        }

        if($this->dao->excluir($pesquisado))
        {
            echo "{}";
            return;
        }
        
        echo "Erro.";
        
    }
    public function restPUT()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'PUT') {
            return;
        }

        if (! array_key_exists('api', $_GET)) {
            return;
        }
        $path = explode('/', $_GET['api']);
        if (count($path) == 0 || $path[0] == "") {
            echo 'Error. Path missing.';
            return;
        }
        
        $param1 = "";
        if (count($path) > 1) {
            $parametro = $path[1];
        }

        if ($path[0] != 'info') {
            return;
        }

        if ($param1 == "") {
            echo 'error';
            return;
        }

        $id = intval($parametro);
        $pesquisado = new Meta();
        $pesquisado->setId($id);
        $pesquisado = $this->dao->pesquisaPorId($pesquisado);

        if ($pesquisado == null) {
            return;
        }

        $body = file_get_contents('php://input');
        $jsonBody = json_decode($body, true);
        
        
        if (isset($jsonBody['id'])) {
            $pesquisado->setId($jsonBody['id']);
        }
                    

        if (isset($jsonBody['descricao'])) {
            $pesquisado->setDescricao($jsonBody['descricao']);
        }
                    

        if (isset($jsonBody['data_inicio_planejado'])) {
            $pesquisado->setDataInicioPlanejado($jsonBody['data_inicio_planejado']);
        }
                    

        if (isset($jsonBody['data_fim_planejado'])) {
            $pesquisado->setDataFimPlanejado($jsonBody['data_fim_planejado']);
        }
                    

        if (isset($jsonBody['data_inicio'])) {
            $pesquisado->setDataInicio($jsonBody['data_inicio']);
        }
                    

        if (isset($jsonBody['data_fim'])) {
            $pesquisado->setDataFim($jsonBody['data_fim']);
        }
                    

        if (isset($jsonBody['priorizacao'])) {
            $pesquisado->setPriorizacao($jsonBody['priorizacao']);
        }
                    

        if ($this->dao->atualizar($pesquisado)) {
            echo "Sucesso";
        } else {
            echo "Erro";
        }
    }

    public function restPOST()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return;
        }
        if (! array_key_exists('path', $_GET)) {
            echo 'Error. Path missing.';
            return;
        }

        $path = explode('/', $_GET['path']);

        if (count($path) == 0 || $path[0] == "") {
            echo 'Error. Path missing.';
            return;
        }

        $body = file_get_contents('php://input');
        $jsonBody = json_decode($body, true);

        if (! ( isset ( $jsonBody ['descricao'] ) && isset ( $jsonBody ['dataInicioPlanejado'] ) && isset ( $jsonBody ['dataFimPlanejado'] ) && isset ( $jsonBody ['dataInicio'] ) && isset ( $jsonBody ['dataFim'] ) && isset ( $jsonBody ['priorizacao'] ) &&  isset($_POST ['setor_responsavel']))) {
			echo "Incompleto";
			return;
		}

        $adicionado = new Meta();
        $adicionado->setId($jsonBody['id']);

        $adicionado->setDescricao($jsonBody['descricao']);

        $adicionado->setDataInicioPlanejado($jsonBody['data_inicio_planejado']);

        $adicionado->setDataFimPlanejado($jsonBody['data_fim_planejado']);

        $adicionado->setDataInicio($jsonBody['data_inicio']);

        $adicionado->setDataFim($jsonBody['data_fim']);

        $adicionado->setPriorizacao($jsonBody['priorizacao']);

        if ($this->dao->inserir($adicionado)) {
            echo "Sucesso";
        } else {
            echo "Fracasso";
        }
    }            
            
		
}
?>