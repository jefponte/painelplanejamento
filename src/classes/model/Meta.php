
<?php
            
/**
 * Classe feita para manipulação do objeto Meta
 * feita automaticamente com programa gerador de software inventado por
 * @author Jefferson Uchôa Ponte <j.pontee@gmail.com>
 */

class Meta {
	private $id;
	private $descricao;
	private $dataInicioPlanejado;
	private $dataFimPlanejado;
	private $dataInicio;
	private $dataFim;
	private $setorResponsavel;
	private $priorizacao;
	private $observacao;
	private $suspensa;
	private $demandantes;
	private $acoes;
	private $situacao;
    public function __construct(){

        $this->setorResponsavel = new Setor();
        $this->demandantes = array();
        $this->acoes = array();
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
	public function setDataInicioPlanejado($dataInicioPlanejado) {
		$this->dataInicioPlanejado = $dataInicioPlanejado;
	}
		    
	public function getDataInicioPlanejado() {
		return $this->dataInicioPlanejado;
	}
	public function setDataFimPlanejado($dataFimPlanejado) {
		$this->dataFimPlanejado = $dataFimPlanejado;
	}
		    
	public function getDataFimPlanejado() {
		return $this->dataFimPlanejado;
	}
	public function setDataInicio($dataInicio) {
		$this->dataInicio = $dataInicio;
	}
		    
	public function getDataInicio() {
		return $this->dataInicio;
	}
	public function setDataFim($dataFim) {
		$this->dataFim = $dataFim;
	}
		    
	public function getDataFim() {
		return $this->dataFim;
	}
	public function setSetorResponsavel(Setor $setor) {
		$this->setorResponsavel = $setor;
	}
		    
	public function getSetorResponsavel() {
		return $this->setorResponsavel;
	}
	public function setPriorizacao($priorizacao) {
		$this->priorizacao = $priorizacao;
	}
		    
	public function getPriorizacao() {
		return $this->priorizacao;
	}
	public function setObservacao($observacao) {
		$this->observacao = $observacao;
	}
		    
	public function getObservacao() {
		return $this->observacao;
	}
	public function setSuspensa($suspensa) {
		$this->suspensa = $suspensa;
	}
		    
	public function isSuspensa() {
		return $this->suspensa;
	}

	public function setDemandantes($demandantes) {
		$this->demandantes = $demandantes;
	}
         
    public function addDemandante(Demandante $demandante){
        $this->demandantes[] = $demandante;
            
    }
	public function getDemandantes() {
		return $this->demandantes;
	}

	public function setAcoes($acoes) {
		$this->acoes = $acoes;
	}
         
    public function addAcao(Acao $acao){
        $this->acoes[] = $acao;
            
    }
	public function getAcoes() {
		return $this->acoes;
	}
	public function setSituacao($situacao){
		$this->situacao = $situacao;
	}
	public function getSituacao(){
		return $this->situacao;
	}
	public function __toString(){
	    return $this->id.' - '.$this->descricao.' - '.$this->dataInicioPlanejado.' - '.$this->dataFimPlanejado.' - '.$this->dataInicio.' - '.$this->dataFim.' - '.$this->setorResponsavel.' - '.$this->priorizacao.' - '.$this->observacao.' - '.$this->suspensa.' - '.'Lista: '.implode(", ", $this->demandantes).' - '.'Lista: '.implode(", ", $this->acoes);
	}
                

}
?>