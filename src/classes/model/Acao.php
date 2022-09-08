
<?php
            
/**
 * Classe feita para manipulação do objeto Acao
 * feita automaticamente com programa gerador de software inventado por
 * @author Jefferson Uchôa Ponte <j.pontee@gmail.com>
 */



class Acao {
	private $id;
	private $descricao;
	private $status;
	private $percentual;
    public function __construct(){

    }
	public function setId($id) {
		$this->id = $id;
	}
		    
	public function getId() {
		return $this->id;
	}
	public function setDescricao($descricao) {
		$this->descricao = $descricao;
	}
		    
	public function getDescricao() {
		return $this->descricao;
	}
	public function setStatus($status) {
		$this->status = $status;
	}
		    
	public function getStatus() {
		return $this->status;
	}
	public function setPercentual($percentual) {
		$this->percentual = $percentual;
	}
		    
	public function getPercentual() {
		return $this->percentual;
	}
	public function __toString(){
	    return $this->id.' - '.$this->descricao.' - '.$this->status.' - '.$this->percentual;
	}
                

}
?>