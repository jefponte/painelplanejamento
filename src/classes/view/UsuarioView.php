<?php
            
/**
 * Classe de visao para Usuario
 * @author Jefferson Uchôa Ponte <j.pontee@gmail.com>
 *
 */
class UsuarioView {
    
    public function formLogin(){
      

      echo '
	        
      <div class="container">
          <!-- Button trigger modal -->

      </div>';
      echo '
          
<!-- Modal -->
<div class="modal fade" id="modalLogin" tabindex="-1" role="dialog" aria-labelledby="labelModalLogin" aria-hidden="true">
<form class="user" method="post">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="labelModalLogin">Fazer Login</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
          
          
    <div class="row">
          
          
      <div class="col-lg-12">
          
        <div class="p-2">                    
            <div class="form-group">
              <input type="text" name="login"
                class="form-control" id="exampleInputEmail"
                aria-describedby="emailHelp"
                placeholder="Seu Login" required>
            </div>
            <div class="form-group">
              <input type="password" name="senha"
                class="form-control"
                id="exampleInputPassword" placeholder="Sua Senha" required>
            </div>
                              
                              
                              
                              
        </div>
      </div>
    </div>
                              
                              
                              
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      <input type="submit" name="form_login" class="btn btn-primary" value="Login" >
    </div>
  </div>
</div>
  </form>
</div>
                              
';
  }
  
  
  
  public function exibirLista($lista){
    $sessao = new Sessao();
      echo '
          
      <h1>Lista de Usuários</h1>
  <div class="table-responsive">
    <table class="table table-bordered" id="dataTable" width="100%"
      cellspacing="0">
      <thead>
        <tr>
          <th>id</th>
          <th>nome</th>
          <th>Nivel</th>
          
                      <th>Ações</th>
        </tr>
      </thead>
      <tfoot>
        <tr>
                      <th>id</th>
                      <th>nome</th>
                      <th>Nivel</th>
                      
                      <th>Ações</th>
        </tr>
      </tfoot>
      <tbody>';
      
      foreach($lista as $elemento){
          echo '<tr>';
          echo '<td>'.$elemento->getId().'</td>';
          echo '<td>'.$elemento->getNome().'</td>';
          echo '<td>'.$sessao->getStrNivel(intval($elemento->getNivel())).'</td>';
          
          echo '<td>';
          if($elemento->getNivel() == Sessao::NIVEL_ADM){
              echo '<button type="button" class="btn btn-primary botao-altear-nivel" id-usuario="'.$elemento->getId().'" nivel="'.Sessao::NIVEL_COMUM.'">
                          Tornar Comum
                      </button>';
          }else{
              echo '<button type="button" class="btn btn-primary botao-altear-nivel" id-usuario="'.$elemento->getId().'" nivel="'.Sessao::NIVEL_ADM.'">
                          Tornar Admin
                      </button>';
              
          }
          
          echo '
                    </td>';
          echo '</tr>';
      }
      
      echo '
      </tbody>
    </table>
  </div><br><br><br><br><br>
          
          
          
          
';
  }
  
  
  public function mostrarSelecionado(Usuario $usuario){
      echo '
          
<div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card mb-4">
          <div class="card-header">
                Usuario selecionado
          </div>
          <div class="card-body">
              Id: '.$usuario->getId().'<br>
              Nome: '.$usuario->getNome().'<br>
              Email: '.$usuario->getEmail().'<br>
              Login: '.$usuario->getLogin().'<br>
              Senha: '.$usuario->getSenha().'<br>
              Nivel: '.$usuario->getNivel().'<br>
              IdBaseExterna: '.$usuario->getIdBaseExterna().'<br>
                  
          </div>
      </div>
  </div>
                  
                  
';
  }
  
  public function mostraFormEditar2() {
      echo '
          
<!-- Modal -->
<div class="modal fade" id="modalEditarNivel" tabindex="-1" role="dialog" aria-labelledby="modalEditarNivelLabel" aria-hidden="true">
 <form class="user" method="post">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="modalEditarNivelLabel">Alterar Nível de Acesso</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
          
      Tem certeza que deseja alterar o nível de acesso deste usuário?
      <input type="hidden" value="0" id="input-nivel" name="nivel">
      <input type="hidden" value="0" id="input-id-usuario" name="id_usuario">
          
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      <input type="submit" class="btn btn-primary" value="Alterar" name="editar_usuario">
    </div>
  </div>
</div>
</form>
</div>
          
          
                           ';
  }
  
  public function confirmarDeletar(Usuario $usuario) {
      echo '
          
          
          
      <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
          <!-- Nested Row within Card Body -->
          <div class="row">
          
            <div class="col-lg-12">
              <div class="p-5">
                <div class="text-center">
                  <h1 class="h4 text-gray-900 mb-4"> Deletar Usuario</h1>
                </div>
                        <form class="user" method="post">                    Tem Certeza que deseja deletar o'.$usuario->getNome().'
                                      <input type="submit" class="btn btn-primary btn-user btn-block" value="Deletar" name="deletar_usuario">
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