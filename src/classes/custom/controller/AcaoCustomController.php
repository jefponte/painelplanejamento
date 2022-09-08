<?php
            
/**
 * Customize o controller do objeto Acao aqui 
 * @author Jefferson Uchôa Ponte <jefponte@gmail.com>
 */



class AcaoCustomController  extends AcaoController {
    

	public function __construct(){
		$this->dao = new AcaoCustomDAO();
		$this->view = new AcaoCustomView();
	}


	        
}
?>