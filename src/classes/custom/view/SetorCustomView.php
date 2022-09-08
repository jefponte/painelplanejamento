<?php
            
/**
 * Classe de visao para Setor
 * @author Jefferson Uchôa Ponte <j.pontee@gmail.com>
 *
 */
class SetorCustomView extends SetorView {

    public function mostraFormInserir() {
        echo '
            
            
            
				<div class="card o-hidden border-0 shadow-lg my-5">
					<div class="card-body p-0">
						<!-- Nested Row within Card Body -->
						<div class="row">
            
							<div class="col-lg-12">
								<div class="p-5">
									<div class="text-center">
										<h1 class="h4 text-gray-900 mb-4"> Adicionar Setor</h1>
									</div>
						              <form class="user" method="post">
            
                                        <div class="form-group">
                                            <label for="nome">nome</label>
                                            <input type="text" class="form-control"  name="nome" id="nome" placeholder="nome">
                                        </div>
                                        <input type="submit" class="btn btn-primary btn-user btn-block" value="Cadastrar" name="enviar_setor">
                                        <hr>
            
						              </form>
            
								</div>
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
						<th>nome</th>
                        <th>Ações</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
                        <th>id</th>
                        <th>nome</th>
                        <th>Ações</th>
					</tr>
				</tfoot>
				<tbody>';
        
        foreach($lista as $elemento){
            echo '<tr>';
            echo '<td>'.$elemento->getId().'</td>';
            echo '<td>'.$elemento->getNome().'</td>';
            echo '<td>
                        <a href="?pagina=setor&selecionar='.$elemento->getId().'" class="btn btn-info">Selecionar</a>
                        <a href="?pagina=setor&editar='.$elemento->getId().'" class="btn btn-success">Editar</a>
                        <a href="?pagina=setor&deletar='.$elemento->getId().'" class="btn btn-danger">Deletar</a>
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
    
    
    public function mostrarSelecionado(Setor $setor){
        echo '
            
	<div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card mb-4">
            <div class="card-header">
                  Setor selecionado
            </div>
            <div class="card-body">
                Id: '.$setor->getId().'<br>
                Nome: '.$setor->getNome().'<br>
                    
            </div>
        </div>
    </div>
                    
                    
';
    }
    
    public function mostraFormEditar(Setor $setor) {
        echo '
            
            
            
				<div class="card o-hidden border-0 shadow-lg my-5">
					<div class="card-body p-0">
						<!-- Nested Row within Card Body -->
						<div class="row">
            
							<div class="col-lg-12">
								<div class="p-5">
									<div class="text-center">
										<h1 class="h4 text-gray-900 mb-4"> Adicionar Setor</h1>
									</div>
						              <form class="user" method="post">
                                        <div class="form-group">
                						  <input type="text" class="form-control" value="'.$setor->getNome().'" id="nome" name="nome" placeholder="nome">
                						</div>
                                        <input type="submit" class="btn btn-primary btn-user btn-block" value="Alterar" name="editar_setor">
                                        <hr>
                						      
						              </form>
                						      
								</div>
							</div>
						</div>
					</div>
                						      
                						      
                						      
	</div>';
    }
    
    public function confirmarDeletar(Setor $setor) {
        echo '
            
            
            
				<div class="card o-hidden border-0 shadow-lg my-5">
					<div class="card-body p-0">
						<!-- Nested Row within Card Body -->
						<div class="row">
            
							<div class="col-lg-12">
								<div class="p-5">
									<div class="text-center">
										<h1 class="h4 text-gray-900 mb-4"> Deletar Setor</h1>
									</div>
						              <form class="user" method="post">                    Tem Certeza que deseja deletar o'.$setor->getNome().'
                                        <input type="submit" class="btn btn-primary btn-user btn-block" value="Deletar" name="deletar_setor">
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