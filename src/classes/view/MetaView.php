<?php
            
/**
 * Classe de visao para Meta
 * @author Jefferson Uchôa Ponte <j.pontee@gmail.com>
 *
 */
class MetaView {
    public function mostraFormInserir($listaSetorResponsavel) {
		echo '
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary m-3" data-toggle="modal" data-target="#exampleModal">
  Adicionar
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Adicionar Meta</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        


          <form id="form_enviar_meta" class="user" method="post">
            <input type="hidden" name="enviar_meta" value="1">                



                                        <div class="form-group">
                                            <label for="descricao">descricao</label>
                                            <input type="text" class="form-control"  name="descricao" id="descricao" placeholder="descricao">
                                        </div>

                                        <div class="form-group">
                                            <label for="data_inicio_planejado">data Inicio Planejado</label>
                                            <input type="date" class="form-control"  name="data_inicio_planejado" id="data_inicio_planejado" placeholder="data Inicio Planejado">
                                        </div>

                                        <div class="form-group">
                                            <label for="data_fim_planejado">data Fim Planejado</label>
                                            <input type="date" class="form-control"  name="data_fim_planejado" id="data_fim_planejado" placeholder="data Fim Planejado">
                                        </div>

                                        <div class="form-group">
                                            <label for="data_inicio">data Inicio</label>
                                            <input type="date" class="form-control"  name="data_inicio" id="data_inicio" placeholder="data Inicio">
                                        </div>

                                        <div class="form-group">
                                            <label for="data_fim">data Fim</label>
                                            <input type="date" class="form-control"  name="data_fim" id="data_fim" placeholder="data Fim">
                                        </div>

                                        <div class="form-group">
                                            <label for="priorizacao">priorizacao</label>
                                            <input type="number" class="form-control"  name="priorizacao" id="priorizacao" placeholder="priorizacao">
                                        </div>
                                        <div class="form-group">
                                          <label for="setor_responsavel">setor Responsavel</label>
                						  <select class="form-control" id="setor_responsavel" name="setor_responsavel">
                                            <option value="">Selecione o setor Responsavel</option>';
                                                
        foreach( $listaSetorResponsavel as $elemento){
            echo '<option value="'.$elemento->getId().'">'.$elemento.'</option>';
        }
            
        echo '
                                          </select>
                						</div>

						              </form>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button form="form_enviar_meta" type="submit" class="btn btn-primary">Cadastrar</button>
      </div>
    </div>
  </div>
</div>
            
            
			
';
	}



                                            
                                            
    public function exibirLista($lista){
           echo '
                                            
                                            
                                            

          <div class="card mb-4">
                <div class="card-header">
                  Lista Meta
                </div>
                <div class="card-body">
                                            
                                            
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%"
				cellspacing="0">
				<thead>
					<tr>
						<th>id</th>
						<th>descricao</th>
						<th>data Inicio Planejado</th>
						<th>data Fim Planejado</th>
						<th>setor Responsavel</th>
                        <th>Ações</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
                        <th>id</th>
                        <th>descricao</th>
                        <th>data Inicio Planejado</th>
                        <th>data Fim Planejado</th>
						<th>setor Responsavel</th>
                        <th>Ações</th>
					</tr>
				</tfoot>
				<tbody>';
            
            foreach($lista as $elemento){
                echo '<tr>';
                echo '<td>'.$elemento->getId().'</td>';
                echo '<td>'.$elemento->getDescricao().'</td>';
                echo '<td>'.$elemento->getDataInicioPlanejado().'</td>';
                echo '<td>'.$elemento->getDataFimPlanejado().'</td>';
                echo '<td>'.$elemento->getSetorResponsavel().'</td>';
                echo '<td>
                        <a href="?pagina=meta&selecionar='.$elemento->getId().'" class="btn btn-info text-white">Selecionar</a>
                        <a href="?pagina=meta&editar='.$elemento->getId().'" class="btn btn-success text-white">Editar</a>
                        <a href="?pagina=meta&deletar='.$elemento->getId().'" class="btn btn-danger text-white">Deletar</a>
                      </td>';
                echo '</tr>';
            }
            
        echo '
				</tbody>
			</table>
		</div>
            
            
            
            
  </div>
</div>
            
';
    }
            


            
        public function mostrarSelecionado(Meta $meta){
            echo '
            
	<div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card mb-4">
            <div class="card-header">
                  Meta selecionado
            </div>
            <div class="card-body">
                Id: '.$meta->getId().'<br>
                Descricao: '.$meta->getDescricao().'<br>
                Data Inicio Planejado: '.$meta->getDataInicioPlanejado().'<br>
                Data Fim Planejado: '.$meta->getDataFimPlanejado().'<br>
                Data Inicio: '.$meta->getDataInicio().'<br>
                Data Fim: '.$meta->getDataFim().'<br>
                Priorizacao: '.$meta->getPriorizacao().'<br>
                Setor Responsavel: '.$meta->getSetorResponsavel().'<br>
            
            </div>
        </div>
    </div>
            
            
';
    }


            
	public function mostraFormEditar(Meta $meta) {
		echo '
	    
	    
	    
				<div class="card o-hidden border-0 shadow-lg my-5">
					<div class="card-body p-0">
						<!-- Nested Row within Card Body -->
						<div class="row">
	    
							<div class="col-lg-12">
								<div class="p-5">
									<div class="text-center">
										<h1 class="h4 text-gray-900 mb-4"> Adicionar Meta</h1>
									</div>
						              <form class="user" method="post">
                                        <div class="form-group">
                						  <input type="text" class="form-control" value="'.$meta->getDescricao().'" id="descricao" name="descricao" placeholder="descricao">
                						</div>
                                        <div class="form-group">
                						  <input type="text" class="form-control" value="'.$meta->getDataInicioPlanejado().'" id="dataInicioPlanejado" name="dataInicioPlanejado" placeholder="dataInicioPlanejado">
                						</div>
                                        <div class="form-group">
                						  <input type="text" class="form-control" value="'.$meta->getDataFimPlanejado().'" id="dataFimPlanejado" name="dataFimPlanejado" placeholder="dataFimPlanejado">
                						</div>
                                        <div class="form-group">
                						  <input type="text" class="form-control" value="'.$meta->getDataInicio().'" id="dataInicio" name="dataInicio" placeholder="dataInicio">
                						</div>
                                        <div class="form-group">
                						  <input type="text" class="form-control" value="'.$meta->getDataFim().'" id="dataFim" name="dataFim" placeholder="dataFim">
                						</div>
                                        <div class="form-group">
                						  <input type="text" class="form-control" value="'.$meta->getPriorizacao().'" id="priorizacao" name="priorizacao" placeholder="priorizacao">
                						</div>
                                        <input type="submit" class="btn btn-primary btn-user btn-block" value="Alterar" name="editar_meta">
                                        <hr>
                                            
						              </form>
                                            
								</div>
							</div>
						</div>
					</div>
                                            
                                            
                                            
	</div>';
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
						              <form class="user" method="post">                    Tem Certeza que deseja deletar este objeto?

                                        <input type="submit" class="btn btn-primary btn-user btn-block" value="Deletar" name="deletar_meta">
                                        <hr>
                                            
						              </form>
                                            
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
        
        
        
    <div class="card o-hidden border-0 shadow-lg my-5">
	   <div class="card-body p-0">
		  <div class="row">
        
							<div class="col-lg-12">
								<div class="p-5">
									<div class="text-center">
										<h1 class="h4 text-gray-900 mb-4"> Adicione Demandante ao Meta</h1>
									</div>
						              <form class="user" method="post">
                                        <div class="form-group">
                						  <select type="text" class="form-control" id="adddemandante" name="adddemandante" >
                                                <option>Adicione Demandante</option>';

            foreach($lista as $elemento){
                echo '
                
                                                <option value="'.$elemento->getId().'">'.$elemento->getNome().' - </option>';
                
            }
                

            echo '
                
                                          </select>
                						</div>
                                        <input type="submit" class="btn btn-primary btn-user btn-block" value="Cadastrar" name="enviar_demandante">
                                        <hr>
                                            
						              </form>
                                            
								</div>
							</div>
						</div>
					</div>
                                            
                                            
	   </div>';
                                            
                                            
                                            
                                            
    }
                                            
                                            

}