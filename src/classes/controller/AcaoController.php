<?php
            
/**
 * Classe feita para manipulação do objeto Acao
 * feita automaticamente com programa gerador de software inventado por
 * @author Jefferson Uchôa Ponte <j.pontee@gmail.com>
 */



class AcaoController {

	protected  $view;
    protected $dao;

	public function __construct(){
		$this->dao = new AcaoDAO();
		$this->view = new AcaoView();
	}


    public function deletar(){
	    if(!isset($_GET['deletar'])){
	        return;
	    }
        $selecionado = new Acao();
	    $selecionado->setId($_GET['deletar']);
        if(!isset($_POST['deletar_acao'])){
            $this->view->confirmarDeletar($selecionado);
            return;
        }
        if($this->dao->excluir($selecionado)){
            echo '<div class="alert alert-success" role="alert">
                        Acao excluído com sucesso!
                    </div>';
        }else{
            echo '
                    <div class="alert alert-danger" role="alert">
                        Falha ao tentar excluir   Acao 
                    </div>

                ';
        }
    	echo '<META HTTP-EQUIV="REFRESH" CONTENT="2; URL=index.php?pagina=acao">';
    }



	public function listar() 
    {
		$lista = $this->dao->retornaLista ();
		$this->view->exibirLista($lista);
	}


	public function cadastrar() {
            
        if(!isset($_POST['enviar_acao'])){
            $this->view->mostraFormInserir();
		    return;
		}
		if (! ( isset ( $_POST ['descricao'] ) && isset ( $_POST ['status'] ) && isset ( $_POST ['percentual'] ))) {
			echo '
                <div class="alert alert-danger" role="alert">
                    Falha ao cadastrar. Algum campo deve estar faltando. 
                </div>

                ';
			return;
		}
            
		$acao = new Acao ();
		$acao->setDescricao ( $_POST ['descricao'] );
		$acao->setStatus ( $_POST ['status'] );
		$acao->setPercentual ( $_POST ['percentual'] );
            
		if ($this->dao->inserir ( $acao ))
        {
			echo '

<div class="alert alert-success" role="alert">
  Sucesso ao inserir Acao
</div>

';
		} else {
			echo '

<div class="alert alert-danger" role="alert">
  Falha ao tentar Inserir Acao
</div>

';
		}
        echo '<META HTTP-EQUIV="REFRESH" CONTENT="3; URL=index.php?pagina=acao">';
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
            $controller = new AcaoController();
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
        $selecionado = new Acao();
	    $selecionado->setId($_GET['selecionar']);
	        
        $this->dao->preenchePorId($selecionado);

        echo '<div class="col-xl-7 col-lg-7 col-md-12 col-sm-12">';
	    $this->view->mostrarSelecionado($selecionado);
        echo '</div>';
            

            
    }

    public function editar(){
	    if(!isset($_GET['editar'])){
	        return;
	    }
        $selecionado = new Acao();
	    $selecionado->setId($_GET['editar']);
	    $this->dao->pesquisaPorId($selecionado);
	        
        if(!isset($_POST['editar_acao'])){
            $this->view->mostraFormEditar($selecionado);
            return;
        }
            
		if (! ( isset ( $_POST ['descricao'] ) && isset ( $_POST ['status'] ) && isset ( $_POST ['percentual'] ))) {
			echo "Incompleto";
			return;
		}

		$selecionado->setDescricao ( $_POST ['descricao'] );
		$selecionado->setStatus ( $_POST ['status'] );
		$selecionado->setPercentual ( $_POST ['percentual'] );
            
		if ($this->dao->atualizar ($selecionado ))
        {
            
			echo "Sucesso";
		} else {
			echo "Fracasso";
		}
        echo '<META HTTP-EQUIV="REFRESH" CONTENT="3; URL=index.php?pagina=acao">';
            
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
        if ($url[1] != 'acao') {
            return;
        }

        if(isset($url[1])){
            $parametro = $url[1];
            $id = intval($parametro);
            $pesquisado = new Acao();
            $pesquisado->setId($id);
            $pesquisado = $this->dao->pesquisaPorId($pesquisado);
            if ($pesquisado == null) {
                echo "{}";
                return;
            }

            $pesquisado = array(
					'id' => $pesquisado->getId (), 
					'descricao' => $pesquisado->getDescricao (), 
					'status' => $pesquisado->getStatus (), 
					'percentual' => $pesquisado->getPercentual ()
            
            
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
					'status' => $linha->getStatus (), 
					'percentual' => $linha->getPercentual ()
            
            
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
        $pesquisado = new Acao();
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
        $pesquisado = new Acao();
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
                    

        if (isset($jsonBody['status'])) {
            $pesquisado->setStatus($jsonBody['status']);
        }
                    

        if (isset($jsonBody['percentual'])) {
            $pesquisado->setPercentual($jsonBody['percentual']);
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

        if (! ( isset ( $jsonBody ['descricao'] ) && isset ( $jsonBody ['status'] ) && isset ( $jsonBody ['percentual'] ))) {
			echo "Incompleto";
			return;
		}

        $adicionado = new Acao();
        $adicionado->setId($jsonBody['id']);

        $adicionado->setDescricao($jsonBody['descricao']);

        $adicionado->setStatus($jsonBody['status']);

        $adicionado->setPercentual($jsonBody['percentual']);

        if ($this->dao->inserir($adicionado)) {
            echo "Sucesso";
        } else {
            echo "Fracasso";
        }
    }            
            
		
}
?>