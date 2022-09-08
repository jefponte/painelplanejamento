<?php
            
/**
 * Customize o controller do objeto Meta aqui 
 * @author Jefferson Uchôa Ponte <jefponte@gmail.com>
 */



class MetaCustomController  extends MetaController {
    

	public function __construct(){
		$this->dao = new MetaCustomDAO();
		$this->view = new MetaCustomView();
	}
	public function main(){
	    $sessao = new Sessao();
	    if ($sessao->getNivelAcesso() != Sessao::NIVEL_ADM) {
	        return;
	    }
	    if (isset($_GET['selecionar'])) {
	        
	        $this->selecionar();
	    }
	    
	}
	
	public function listar()
	{
	    
	    $lista = $this->dao->retornaLista();
	    $this->view->exibirLista($lista);
	}
	
	public function selecionar()
	{
	    if (! isset($_GET['selecionar'])) {
	        return;
	    }
	    $selecionado = new Meta();
	    $selecionado->setId($_GET['selecionar']);
	    
	    $this->dao->preenchePorId($selecionado);
	    $this->dao->buscarDemandantes($selecionado);
	    $this->dao->acoesDaMeta($selecionado);
	    
	    $this->editarSelecionado($selecionado);	    
	    
	    $this->view->mostrarSelecionado($selecionado);
	}
	public function deletarDemandantes(Meta $meta){
	    $this->view->modalDeletarDemandantes();
	    if(!isset($_POST['deletar_demandantes'])){
	        return;
	    }
	    
	    foreach($meta->getDemandantes() as $demandante){
	        if($this->dao->removerDemandante($meta, $demandante)){
	            echo '
            <div class="alert alert-success" role="alert">
                Demandante Removido Com Sucesso!
            </div>';
	        }else{
	            echo '
            <div class="alert alert-danger" role="alert">
                Falha ao tentar remover demandantes!
            </div>';
	            
	        }
	    }
	    
	    
	    echo '<META HTTP-EQUIV="REFRESH" CONTENT="2; URL=?pagina=meta&selecionar='.$meta->getId().'">';
	}
	public function addDemandante(Meta $meta){
	    $demandantesDao = new DemandanteCustomDAO($this->dao->getConexao());
	    $lista = $demandantesDao->retornaLista();
	    $this->view->adicionarDemandante($lista);
	    if(!isset($_POST['adicionar_demandante'])){
	        return;
	    }
	    if(!isset($_POST['demandante'])){
	        return;
	    }
	    $demandante = new Demandante();
	    $demandante->setId($_POST['demandante']);
	    if($this->dao->inserirDemandante($meta, $demandante)){
	        echo '
            <div class="alert alert-success" role="alert">
                Demandante Inserido Com Sucesso!
            </div>';
	    }else{
	        echo '
            <div class="alert alert-danger" role="alert">
                Falha ao tentar inserir demandante!
            </div>';
	        
	        
	    }
	    echo '<META HTTP-EQUIV="REFRESH" CONTENT="2; URL=?pagina=meta&selecionar='.$meta->getId().'">';
	    
	    
	    
	}
	public function deletarAcoes(Meta $meta){
	    $this->view->modalDeletarAcoes();
	    if(!isset($_POST['deletar_acoes'])){
	        return;
	    }
	    $acaoDao = new AcaoCustomDAO($this->dao->getConexao());
	    $acao = new Acao();
	    $acao->setMeta($meta);
	    if($acaoDao->excluirPorMeta($acao)){
	        echo '
            <div class="alert alert-success" role="alert">
                Ações deletadas Com Sucesso!
            </div>';
	    }else{
	        echo '
            <div class="alert alert-danger" role="alert">
                Falha ao tentar Remover Ações!
            </div>';
	        
	        
	    }
	    echo '<META HTTP-EQUIV="REFRESH" CONTENT="2; URL=?pagina=meta&selecionar='.$meta->getId().'">';
	}
	
	public function addAcao(Meta $meta)
	{
	    $acaoView = new AcaoView();
	    $acaoView->mostraFormInserir();
	    if(!isset($_POST['add_acao'])){
	        return;
	    }
	    if(!isset($_POST['descricao'])){
	        return;
	    }
	    if(!isset($_POST['id'])){
	        return;
	    }
	    
	    $acao = new Acao();
	    $acao->setMeta($meta);
	    $acao->setId($_POST['id']);
	    $acao->setDescricao($_POST['descricao']);
	    $acaoDao = new AcaoCustomDAO($this->dao->getConexao());
	    
	    if($acaoDao->inserirComPK($acao)){
	        echo '
            <div class="alert alert-success" role="alert">
                Ação adicionada com sucesso!
            </div>';
	    }else{
	        echo '
            <div class="alert alert-danger" role="alert">
                Falha ao tentar adicionar ação!
            </div>';
	        
	        
	    }
	    echo '<META HTTP-EQUIV="REFRESH" CONTENT="2; URL=?pagina=meta&selecionar='.$meta->getId().'">';
	}
	public function editarSelecionado(Meta $selecionado){
	    
	    $setorDao = new SetorCustomDAO($this->dao->getConexao());
	    $listaSetor = $setorDao->retornaLista();
	    
	    $this->view->mostraFormEditarSelecionado($selecionado, $listaSetor);
	    if(!isset($_POST['editarMeta'])){
	        return;
	    }
	    if (! (isset($_POST['dataInicioPlanejado']) 
	        && isset($_POST['dataFimPlanejado'])
	        && isset($_POST['responsavel']))) {
	        echo "Incompleto";
	        return;
	    }
	    
	    
	    $selecionado->setDescricao($_POST['descricao']);
	    $selecionado->setDataInicioPlanejado($_POST['dataInicioPlanejado']);
	    $selecionado->setDataFimPlanejado($_POST['dataFimPlanejado']);
	    $selecionado->setDataInicio($_POST['dataInicio']);
	    $selecionado->setDataFim($_POST['dataFim']);
	    $selecionado->getSetorResponsavel()->setId($_POST['responsavel']);
		$selecionado->setSuspensa($_POST['suspensa']);
		$selecionado->setObservacao($_POST['observacao']);
		
	    if($this->dao->atualizar($selecionado)){
	        echo '
            <div class="alert alert-success" role="alert">
                Meta editada Com sucesso!
            </div>';
	    }else{
	        echo '
            <div class="alert alert-danger" role="alert">
                Falha ao tentar editar meta!
            </div>';
	        
	        
	    }
	    echo '<META HTTP-EQUIV="REFRESH" CONTENT="2; URL=?pagina=meta&selecionar='.$selecionado->getId().'">';
	    
	    
	}
	public function cadastrar()
	{
	    $setorDao = new SetorCustomDAO($this->dao->getConexao());
	    $listaSetor = $setorDao->retornaLista();
	    
	    $this->view->mostraFormInserir($listaSetor);
	    
	    if (! isset($_POST['descricao'])) {
	        return;
	    }
	    if (! (isset($_POST['id'])  && isset($_POST['dataInicioPlanejado']) && isset($_POST['dataFimPlanejado']) && isset($_POST['responsavel']))) {
	        echo "Incompleto";
	        return;
	    }
	    $meta = new Meta();
	    $meta->setId($_POST['id']);
	    $meta->setDescricao($_POST['descricao']);
	    $meta->setDataInicioPlanejado($_POST['dataInicioPlanejado']);
	    $meta->setDataFimPlanejado($_POST['dataFimPlanejado']);
	    $meta->getSetorResponsavel()->setId($_POST['responsavel']);
	    
	    if ($this->dao->inserirComPK($meta)) {
	        echo '
                <div class="alert alert-success" role="alert">
                    Meta inserida com sucesso!
                </div> ';
	    } else {
	        echo '
                <div class="alert alert-danger" role="alert">
                    Erro ao tentar inserir meta!
                </div> ';
	    }
	    echo '<META HTTP-EQUIV="REFRESH" CONTENT="2; URL=index.php?pagina=meta">';
	}
	
	public function atualizar()
	{
	    if (! isset($_GET['atualizar_metas'])) {
	        return;
	    }
	    $acoes = array();
	    foreach ($_GET as $chave => $valor) {
	        $arrChave = explode('_', $chave);
	        if ($arrChave[0] == 'status') {
	            if (! isset($acoes[end($arrChave)])) {
	                $acoes[end($arrChave)] = new Acao();
	            }
	            $acoes[end($arrChave)]->setId(end($arrChave));
	            $acoes[end($arrChave)]->setStatus($valor);
	        }
	        if ($arrChave[0] == 'percentual') {
	            if (! isset($acoes[end($arrChave)])) {
	                $acoes[end($arrChave)] = new Acao();
	            }
	            $acoes[end($arrChave)]->setId(end($arrChave));
	            $acoes[end($arrChave)]->setPercentual($valor);
	        }
	    }
	    $dao = new AcaoCustomDAO($this->dao->getConexao());
	    $dao->getConexao()->beginTransaction();
	    foreach ($acoes as $acao) {
	        if (! $dao->atualizar($acao)) {
	            $dao->getConexao()->rollBack();
	            echo 'Falha ao tentar atualizar ações';
	            return;
	        }
	    }
	    $dao->getConexao()->commit();
	    echo 'Sucesso ao tentar atualizar ações';
	}
	
	public function deletar()
	{
	    if (! isset($_GET['deletar'])) {
	        return;
	    }
	    $selecionado = new Meta();
	    $selecionado->setId($_GET['deletar']);
	    $this->dao->pesquisaPorId($selecionado);
	    if (! isset($_POST['deletar_meta'])) {
	        $this->view->confirmarDeletar($selecionado);
	        return;
	    }
	    if ($this->dao->excluir($selecionado)) {
	        echo "excluido com sucesso";
	    } else {
	        echo "Errou";
	    }
	    echo '<META HTTP-EQUIV="REFRESH" CONTENT="2; URL=index.php?pagina=meta">';
	}
	}
?>