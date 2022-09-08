<?php
            
/**
 * Customize o controller do objeto Demandante aqui 
 * @author Jefferson Uchôa Ponte <jefponte@gmail.com>
 */



class DemandanteCustomController  extends DemandanteController {
    

	public function __construct(){
		$this->dao = new DemandanteCustomDAO();
		$this->view = new DemandanteCustomView();
	}


	        
}
?>