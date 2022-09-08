<?php
            
/**
 * Classe feita para manipulação do objeto Usuario
 * feita automaticamente com programa gerador de software inventado por
 * @author Jefferson Uchôa Ponte <j.pontee@gmail.com>
 */



class UsuarioController {

	protected  $view;
    protected $dao;

	public function __construct(){
		$this->dao = new UsuarioDAO();
		$this->view = new UsuarioView();
	}

    public function editarNivel(){
	    $this->view->mostraFormEditar2();
	    
	    if(!isset($_POST['editar_usuario'])){
	        return;
	    }
	    if (! ( isset ( $_POST ['id_usuario'] ) && isset ( $_POST ['nivel'] ))) {
	        echo "Incompleto";
	        return;
	    }
	    
	    $selecionado = new Usuario();
	    $selecionado->setId ( $_POST ['id_usuario'] );
	    $selecionado->setNivel ( $_POST ['nivel'] );
	    
	    
	    if ($this->dao->atualizarNivel($selecionado ))
	    {
	        
	        echo "Sucesso";
	    } else {
	        echo "Fracasso";
	    }
	    echo '<META HTTP-EQUIV="REFRESH" CONTENT="3; URL=index.php?pagina=usuario">';
	    
	}         
    
	public function login(){
	    $sessao2 = new Sessao();
	    if($sessao2->getNivelAcesso() != Sessao::NIVEL_DESLOGADO){
	        return;
	    }
	    
	    if(!isset($_POST['form_login'])){
	        $this->view->formLogin();
	        return;
	    }
	    if (! (isset($_POST['login']) && isset ( $_POST ['senha'] ))) {
			echo '
			<div class="alert alert-danger" role="alert">
			É necessário digitar Login e a senha para autenticar.
			</div>';
	        $this->view->formLogin();
	        return;
	    }
	    
	    $usuarioDAO = new UsuarioDAO();
	    $usuario = new Usuario();
	    $usuario->setLogin($_POST['login']);
	    $usuario->setSenha($_POST['senha']);
	    if($usuarioDAO->autentica($usuario)){
	        
	        
	        $sessao2->criaSessao($usuario->getId(), $usuario->getNivel(), $usuario->getLogin());
	        echo '<meta http-equiv="refresh" content=0;url="./index.php">';
	        
	    }else{
			echo '
			<div class="alert alert-danger" role="alert">
				Errou usuario ou senha! Tente outra vez. 
			</div>
	';
	        echo '<meta http-equiv="refresh" content=1;url="./index.php">';
	    }
	    
	    
	}
	public function main(){
	    $sessao = new Sessao();
	    if($sessao->getNivelAcesso() != Sessao::NIVEL_ADM){
	        return;
	    }
	    
	    
	    $this->editarNivel();
	    echo '
		<div class="row justify-content-center">';
	    echo '<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">';
	    $this->listar();
	    echo '</div>';
	    echo '</div>';
	    
	}
	public function listar() {
	    $usuarioDao = new UsuarioDAO ();
	    $lista = $usuarioDao->retornaLista ();
	    $this->view->exibirLista($lista);
	}	
}
?>