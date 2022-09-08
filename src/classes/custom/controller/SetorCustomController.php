<?php
            
/**
 * Customize o controller do objeto Setor aqui 
 * @author Jefferson Uchôa Ponte <jefponte@gmail.com>
 */



class SetorCustomController  extends SetorController {
    

	public function __construct(){
		$this->dao = new SetorCustomDAO();
		$this->view = new SetorCustomView();
	}


	        
}
?>