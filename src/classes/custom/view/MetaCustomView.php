<?php
            
/**
 * Classe de visao para Meta
 * @author Jefferson Uchôa Ponte <j.pontee@gmail.com>
 *
 */
class MetaCustomView extends MetaView {
    public function mostraFormInserir($listaSetor) {
        echo '
            
<!-- Button trigger modal -->
<div>
<button type="button" class="btn btn-primary m-3" data-toggle="modal" data-target="#modalAddMeta">
  Adicionar Meta
</button>
</div>
<!-- Modal -->
<div class="modal fade" id="modalAddMeta" tabindex="-1" role="dialog" aria-labelledby="modalAddMetaLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAddMetaLabel">Adicionar Meta</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
						              <form class="user" method="post" id="formAddMeta">
                                        <div class="form-group">
                                            <label for="id">ID</label>
                                            <input type="text" class="form-control"  name="id" id="id" placeholder="ID">
                                        </div>
                                        <div class="form-group">
                                            <label for="descricao">Descrição</label>
                                            <textarea id="descricao" name="descricao" class="form-control" id="exampleFormControlTextarea1" rows="3" required></textarea>
                                        </div>
            
            
                                        <div class="form-group">
                                            <label for="dataInicioPlanejado">Data do Início Planejado</label>
                                            <input type="date" class="form-control"  name="dataInicioPlanejado" id="dataInicioPlanejado" placeholder="Data de início planejada">
                                        </div>
            
                                        <div class="form-group">
                                            <label for="dataFimPlanejado">Data de Finalização Planejada</label>
                                            <input type="date" class="form-control"  name="dataFimPlanejado" id="dataFimPlanejado" placeholder="Data de Finalização Planejada">
                                        </div>
            
            
                                        <div class="form-group">
                                          <label for="responsavel">Setor Responsável</label>
                						  <select class="form-control" id="responsavel" name="responsavel">
                                            <option value="">Selecione o responsavel</option>';
        
        foreach( $listaSetor as $elemento){
            echo '<option value="'.$elemento->getId().'">'.$elemento.'</option>';
        }
        
        echo '
                                          </select>
                						</div>
            
						              </form>
            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="submit" form="formAddMeta"  class="btn btn-primary">Cadastrar</button>
      </div>
    </div>
  </div>
</div>
            
            
            
            
';
    }
    
    
    public function exibirLista($lista){
        echo '
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%"
				cellspacing="0">
				<thead>
					<tr>
						<th>ID</th>
						<th>Descrição</th>
						<th>Início Planejado</th>
						<th>Fim Planejado</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>ID</th>
						<th>Descrição</th>
						<th>Início Planejado</th>
						<th>Fim Planejado</th>
					</tr>
				</tfoot>
				<tbody>';
        
        foreach($lista as $elemento){
            echo '<tr>';
            echo '<td>M'. str_pad($elemento->getId(), 3, 0, STR_PAD_LEFT).'</td>';
            echo '<td>'.$elemento->getDescricao().'</td>';
            echo '<td>'.date("d/m/Y", strtotime($elemento->getDataInicioPlanejado())).'</td>';
            echo '<td>'.date("d/m/Y", strtotime($elemento->getDataFimPlanejado())).'</td>';
            echo '</tr>';
        }
        
        echo '
				</tbody>
			</table>
		</div>
            
            
';
    }
    
    
    public function mostrarSelecionado(Meta $meta){
        
        
        $demandantes = array();
        foreach($meta->getDemandantes() as $demandante){
            $demandantes[] = $demandante->getNome();
        }
        $strDemandantes = implode(', ', $demandantes);
        $acoes = $meta->getAcoes();
        
        
        echo '<div class="row justify-content-center">';
        echo '<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">';
        echo '
            
            
        <h2>META: '.$meta->getId().'</h2>
        Descrição: '.$meta->getDescricao().'<br>
        Datas Planejadas: '.date("d/m/Y", strtotime($meta->getDataInicioPlanejado())).' - '.date("d/m/Y", strtotime($meta->getDataFimPlanejado())).'<br>
        Datas Efetivas: ';
        if($meta->getDataInicio() != null){
            echo date("d/m/Y", strtotime($meta->getDataInicio()));
        }
        echo ' - ';
        if($meta->getDataFim() != null){
            echo date("d/m/Y", strtotime($meta->getDataFim()));
        }
        echo '<br>';
        echo '
        Responsavel: '.$meta->getSetorResponsavel()->getNome().'<br>
        Demandante(s): '.$strDemandantes.'<br>';
        echo $meta->isSuspensa() ? "Meta Suspensa<br>" : "";
        echo 'Observação: '.$meta->getObservacao().'<br>';
        echo '
        Progresso: <br><br>';
        $progresso = 0;
        foreach($acoes as $acao){
            if($acao->getStatus() == PainelPDTIController::ACAO_STATUS_REALIZADA){
                $progresso += $acao->getPercentual();
            }
        }
        echo '
<div class="progress">
  <div id="barra-progresso" class="progress-bar" role="progressbar" style="width: '.$progresso.'%;" aria-valuenow="'.$progresso.'" aria-valuemin="0" aria-valuemax="100">'.$progresso.'%</div>
</div><br>
<a href="index.php" class="btn btn-primary m-2">Voltar ao Painel</a>
      
<button type="button" class="btn btn-primary m-2" data-toggle="modal" data-target="#modalEditarMeta">
  Editar Meta
</button>
      
      
      
            ';
        
        echo '</div>';
        
        echo '<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">';
        echo '
            
<h2>Ações</h2>
        <ul class="list-group">
  ';
        foreach($acoes as $acao){
            
            echo '
          <li class="list-group-item bg-primary text-white">'.$acao->getDescricao().' - '.PainelPDTIController::getStrStatus($acao).'
<div class="row">
<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
    <div class="form-group">
        <input type="number" min="0" max="5000" step="0.01" class="form-control campo-percentual" value="'.$acao->getPercentual().'" name="id_acao_'.$acao->getId().'" placeholder="Percentual">
    </div>
</div>
<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
            
    <div class="form-group">
            <select class="form-control campo-status" name="id_acao_'.$acao->getId().'">';
            echo '
                <option value="'.$acao->getStatus().'" selected>'.PainelPDTIController::getStrStatus($acao).'</option>';
            echo '
                <option value="'.PainelPDTIController::ACAO_STATUS_NAO_INICIADA.'">A FAZER</option>
                <option value="'.PainelPDTIController::ACAO_STATUS_EM_ANDAMENTO.'">FAZENDO</option>
                <option value="'.PainelPDTIController::ACAO_STATUS_REALIZADA.'">FEITA</option>
            </select>
    </div>
</div>
</div>
                    
                    
                    
                    
                    
                    
</li>';
        }
        
        
        echo '
        </ul>
        <button id="editarAcao" class="btn btn-primary m-2">Atualizar</button>';
        echo '</div>';
        echo '</div>';
        
    }
    public function modalDeletarAcoes(){
        echo '
            
            
<!-- Modal -->
<div class="modal fade" id="modalDeletarAcoes" tabindex="-1" role="dialog" aria-labelledby="modalDeletarAcoesLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDeletarAcoesLabel">Deletar Ações da Meta</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Deseja deletar todas as ações dessa meta?
        <form id="form_deletar_acoes" method="post">
            <input type="hidden" name="deletar_acoes" value="1">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="submit" form="form_deletar_acoes" class="btn btn-primary">Deletar Ações</button>
      </div>
    </div>
  </div>
</div>
            
';
    }
    public function modalDeletarDemandantes(){
        echo '
            
            
<!-- Modal -->
<div class="modal fade" id="modalDeletarDemandantes" tabindex="-1" role="dialog" aria-labelledby="modalDeletarDemandantesLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDeletarDemandantesLabel">Deletar Demandantes da Meta</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Deseja deletar todos os demandantes dessa meta?
        <form id="form_deletar_demandantes" method="post">
            <input type="hidden" name="deletar_demandantes" value="1">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="submit" form="form_deletar_demandantes" class="btn btn-primary">Deletar Demandantes</button>
      </div>
    </div>
  </div>
</div>
            
';
    }
    public function mostraFormEditarSelecionado(Meta $meta, array $setores) {

        echo '
            
            
            
<!-- Modal -->
<div class="modal fade" id="modalEditarMeta" tabindex="-1" role="dialog" aria-labelledby="modalEditarMetaLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditarMetaLabel">Editar Meta '.$meta->getId().'</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            
						              <form class="user" method="post" id="formEditarMeta">
                                        <input type="hidden" name="editarMeta" value="1">
            
                                        <div class="form-group">
                                            <label for="descricao">Descrição</label>
                                            <textarea id="descricao" name="descricao" class="form-control" id="exampleFormControlTextarea1" rows="3" required>'.$meta->getDescricao().'</textarea>
                                          </div>
                                                
                                                
                                        <div class="form-group">
                                          <label for="dataInicioPlanejado">Data do Início Planejado</label>
                						  <input type="date" class="form-control" value="'.$meta->getDataInicioPlanejado().'" id="dataInicioPlanejado" name="dataInicioPlanejado" placeholder="dataInicioPlanejado" required>
                						</div>
                                        <div class="form-group">
                                            <label for="dataFimPlanejado">Data do Fim Planejado</label>
                						  <input type="date" class="form-control" value="'.$meta->getDataFimPlanejado().'" id="dataFimPlanejado" name="dataFimPlanejado" placeholder="dataFimPlanejado" required>
                						</div>
                                        <div class="form-group">
                                          <label for="dataInicio">Data do Início</label>
                						  <input type="date" class="form-control" value="'.$meta->getDataInicio().'" id="dataInicio" name="dataInicio" placeholder="dataInicio">
                						</div>
                                        <div class="form-group">
                                            <label for="dataFim">Data do Fim</label>
                						  <input type="date" class="form-control" value="'.$meta->getDataFim().'" id="dataFim" name="dataFim" placeholder="dataFim">
                						</div>
                						      
                                        <div class="form-group">
                                          <label for="responsavel">Setor Responsável</label>
                						  <select class="form-control" id="responsavel" name="responsavel" required>
                                            <option value="">Selecione o responsavel</option>';
        
        foreach($setores as $elemento){
            $selected = '';
            if($meta->getSetorResponsavel()->getId() == $elemento->getId() ){
                $selected = 'selected';
            }
            echo '<option value="'.$elemento->getId().'" '.$selected.'>'.$elemento.'</option>';
        }
        
        echo '
                                          </select>
                						</div>
                            <div class="form-group">
                              <label for="suspensa">Suspensa</label>
                                                    
                              <select class="form-control" id="suspensa" name="suspensa" required>
                                    <option>Selecione Um Valor</option>
                                    ';
                                    if($meta->isSuspensa()){
                                      echo '
                                      <option value="1" selected>Sim</option>
                                      <option value="0">Não</option>';
                                    }else{
                                      echo '
                                      <option value="1">Sim</option>
                                      <option value="0" selected>Não</option>';
                                    }
                                    
                                    echo '
                              </select>
                              <div class="form-group">
                                <label for="observacao">Observacao</label>
                                <input type="text" class="form-control" value="'.$meta->getObservacao().'"  name="observacao" id="observacao" placeholder="Observacao">
                              </div>
                            </div>
            
						              </form>
            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="submit" form="formEditarMeta" class="btn btn-primary">Salvar</button>
      </div>
    </div>
  </div>
</div>
            
';
    }
    
    public function confirmarDeletar(Meta $meta) {
        echo '
            
            
            
				<div class="card o-hidden border-0 shadow-lg my-5">
					<div class="card-body p-0">
						<!-- Nested Row within Card Body -->
						<div class="row">
            
							<div class="col-lg-12">
								<div class="p-5">
									<div class="text-center">
										<h1 class="h4 text-gray-900 mb-4"> Deletar Meta</h1>
									</div>
						              <form class="user" method="post">                    Tem Certeza que deseja deletar o'.$meta->getDescricao().'
                                        <input type="submit" class="btn btn-primary btn-user btn-block" value="Deletar" name="deletar_meta">
                                        <hr>
						                  
						              </form>
						                  
								</div>
							</div>
						</div>
					</div>
						                  
						                  
						                  
						                  
	</div>';
    }
    
    public function mensagem($mensagem) {
        echo '
            
            
            
				<div class="card o-hidden border-0 shadow-lg my-5">
					<div class="card-body p-0">
						<!-- Nested Row within Card Body -->
						<div class="row">
            
							<div class="col-lg-12">
								<div class="p-5">
									<div class="text-center">
										<h1 class="h4 text-gray-900 mb-4">'.$mensagem.'</h1>
									</div>
										    
										    
								</div>
							</div>
						</div>
					</div>
										    
										    
	</div>';
    }
    
    
    
    
    
    public function exibirDemandantes(Meta $meta){
        echo '
            
    	<div class="card o-hidden border-0 shadow-lg my-5">
              <div class="card mb-4">
                <div class="card-header">
                  Demandante do Meta
                </div>
                <div class="card-body">
            
            
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%"
				cellspacing="0">
				<thead>
					<tr>
						<th>id</th>
						<th>nome</th><th>Ações</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
                        <th>id</th>
                        <th>nome</th><th>Ações</th>
					</tr>
				</tfoot>
				<tbody>';
        
        foreach($meta->getDemandantes() as $elemento){
            echo '<tr>';
            echo '<td>'.$elemento->getId().'</td>';
            echo '<td>'.$elemento->getNome().'</td>';echo '<td>
                        <a href="?pagina=demandante&selecionar='.$elemento->getId().'" class="btn btn-info">Selecionar</a>
                        <a href="?pagina=meta&selecionar='.$meta->getId().'&removerdemandante='.$elemento->getId().'" class="btn btn-danger">Remover</a>
                      </td>';
            echo '<tr>';
        }
        
        echo '
				</tbody>
			</table>
		</div>
            
            
            
            
      </div>
  </div>
</div>
            
            
            
        ';
        
    }
    
    public function adicionarDemandante($lista){
        
        
        echo '
            
            
            
            
<!-- Modal -->
<div class="modal fade" id="modalAdicionarDemandante" tabindex="-1" role="dialog" aria-labelledby="modalAdicionarDemandanteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAdicionarDemandanteLabel">Adicionar Demandante</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
						              <form class="user" method="post" id="form_add_demandante">
                                        <div class="form-group">
                						  <select type="text" class="form-control" id="select-demandante" name="demandante" >
                                                <option value="">Adicione Demandante</option>';
        
        foreach($lista as $elemento){
            echo '
                
                                                <option value="'.$elemento->getId().'">'.$elemento->getNome().'</option>';
            
        }
        
        
        echo '
            
                                          </select>
                						</div>
                                        <input type="hidden" value="1" name="adicionar_demandante">
            
            
						              </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="submit" form="form_add_demandante" class="btn btn-primary">Adicionar Demandante</button>
      </div>
    </div>
  </div>
</div>
            
            
            
                                ';
        
        
        
        
    }
    
    
}