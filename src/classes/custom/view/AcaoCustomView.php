<?php
            
/**
 * Classe de visao para Acao
 * @author Jefferson Uchôa Ponte <j.pontee@gmail.com>
 *
 */
class AcaoCustomView extends AcaoView {
    
    public function mostraFormInserir() {
        echo '
            
            
            
<!-- Modal -->
<div class="modal fade" id="modalAddAcao" tabindex="-1" role="dialog" aria-labelledby="modalAddAcaoLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAddAcaoLabel">Adicionar Ação</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form class="user" method="post" id="form_add_acao">
                <div class="form-group">
                    <label for="id">ID da Ação</label>
                    <input type="number" class="form-control" step="1" name="id" id="id" placeholder="Id da Ação" required>
                </div>
                <div class="form-group">
                    <label for="descricao">Descrição da Ação</label>
                    <input type="text" class="form-control"  name="descricao" id="descricao" placeholder="Descrição" required>
                </div>
                <input type="hidden" value="1" name="add_acao">
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary" form="form_add_acao">Adicionar</button>
      </div>
    </div>
  </div>
</div>
            
';
    }
    
    
    
    public function exibirLista($lista){
        echo '
            
            
            
	<div class="card o-hidden border-0 shadow-lg my-5">
              <div class="card mb-4">
                <div class="card-header">
                  Lista
                </div>
                <div class="card-body">
            
            
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%"
				cellspacing="0">
				<thead>
					<tr>
						<th>id</th>
						<th>descricao</th>
						<th>status</th>
						<th>percentual</th>
						<th>meta</th>
                        <th>Ações</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
                        <th>id</th>
                        <th>descricao</th>
                        <th>status</th>
                        <th>percentual</th>
						<th>meta</th>
                        <th>Ações</th>
					</tr>
				</tfoot>
				<tbody>';
        
        foreach($lista as $elemento){
            echo '<tr>';
            echo '<td>'.$elemento->getId().'</td>';
            echo '<td>'.$elemento->getDescricao().'</td>';
            echo '<td>'.$elemento->getStatus().'</td>';
            echo '<td>'.$elemento->getPercentual().'</td>';
            echo '<td>'.$elemento->getMeta().'</td>';
            echo '<td>
                        <a href="?pagina=acao&selecionar='.$elemento->getId().'" class="btn btn-info">Selecionar</a>
                        <a href="?pagina=acao&editar='.$elemento->getId().'" class="btn btn-success">Editar</a>
                        <a href="?pagina=acao&deletar='.$elemento->getId().'" class="btn btn-danger">Deletar</a>
                      </td>';
            echo '</tr>';
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
    
    
    public function mostrarSelecionado(Acao $acao){
        echo '
            
	<div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card mb-4">
            <div class="card-header">
                  Acao selecionado
            </div>
            <div class="card-body">
                Id: '.$acao->getId().'<br>
                Descricao: '.$acao->getDescricao().'<br>
                Status: '.$acao->getStatus().'<br>
                Percentual: '.$acao->getPercentual().'<br>
                Meta: '.$acao->getMeta().'<br>
                    
            </div>
        </div>
    </div>
                    
                    
';
    }
    
    public function mostraFormEditar(Acao $acao) {
        echo '
            
            
            
				<div class="card o-hidden border-0 shadow-lg my-5">
					<div class="card-body p-0">
						<!-- Nested Row within Card Body -->
						<div class="row">
            
							<div class="col-lg-12">
								<div class="p-5">
									<div class="text-center">
										<h1 class="h4 text-gray-900 mb-4"> Adicionar Acao</h1>
									</div>
						              <form class="user" method="post">
                                        <div class="form-group">
                						  <input type="text" class="form-control" value="'.$acao->getDescricao().'" id="descricao" name="descricao" placeholder="descricao">
                						</div>
                                        <div class="form-group">
                						  <input type="text" class="form-control" value="'.$acao->getStatus().'" id="status" name="status" placeholder="status">
                						</div>
                                        <div class="form-group">
                						  <input type="text" class="form-control" value="'.$acao->getPercentual().'" id="percentual" name="percentual" placeholder="percentual">
                						</div>
                                        <input type="submit" class="btn btn-primary btn-user btn-block" value="Alterar" name="editar_acao">
                                        <hr>
                						      
						              </form>
                						      
								</div>
							</div>
						</div>
					</div>
                						      
                						      
                						      
	</div>';
    }
    
    public function confirmarDeletar(Acao $acao) {
        echo '
            
            
            
				<div class="card o-hidden border-0 shadow-lg my-5">
					<div class="card-body p-0">
						<!-- Nested Row within Card Body -->
						<div class="row">
            
							<div class="col-lg-12">
								<div class="p-5">
									<div class="text-center">
										<h1 class="h4 text-gray-900 mb-4"> Deletar Acao</h1>
									</div>
						              <form class="user" method="post">                    Tem Certeza que deseja deletar o'.$acao->getDescricao().'
                                        <input type="submit" class="btn btn-primary btn-user btn-block" value="Deletar" name="deletar_acao">
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
    
    
    

}