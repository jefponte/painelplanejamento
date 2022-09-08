<?php 



class PainelPDTIView
{
    public function calculaPercentual(Meta $meta){
        $percentual = 0;
        foreach($meta->getAcoes() as $acao){
            if($acao->getStatus() == self::ACAO_STATUS_REALIZADA){
                $percentual += $acao->getPercentual();
            }
        }
        return $percentual; 
    }
    public function exibirPlanilha($lista)
    {
        
        echo '
		
			<table class="table table-bordered table-hover table-sm text-success"  width="100%"
				cellspacing="0">
				<thead>
					<tr class="bg-primary text-white text-center">
						<th>ID</th>
						<th>Descrição</th>
                        <th>Situação</th>
						<th>Início Planejado</th>
						<th>Fim Planejado</th>
                        <th>Demandantes</th>
                        <th>Setor Responsável</th>
					</tr>
				</thead>
				<tfoot>
					<tr class="bg-primary text-white text-center">
						<th>ID</th>
						<th>Descrição</th>
                        <th>Situação</th>
						<th>Início Planejado</th>
						<th>Fim Planejado</th>
                        <th>Demandantes</th>
                        <th>Setor Responsável</th>
					</tr>
				</tfoot>
				<tbody>';
        
        foreach($lista as $elemento){
            $pinturaMeta = '';
            $pinturaMeta = $this->retornaPinturaMeta($elemento);
            
            $classeStatusMeta = '';
            $classeStatusMeta = $this->retornaClasseEstadoMeta($elemento);
            
            $classDemandante = "";
            foreach($elemento->getDemandantes() as $demandante){
                $classDemandante .= ' demandante-'.$demandante->getId();
            }
            $classResponsave = "responsavel-".$elemento->getSetorResponsavel()->getId();
            $strTextoModal = "";
            $strCorpo = "";
            $strTextoModal = 'Meta: M'.str_pad($elemento->getId(), 3, 0, STR_PAD_LEFT);
            $strCorpo = $this->formarStrCorpoModal($elemento);
            $acoes = array();
            foreach($elemento->getAcoes() as $acao){
                $acoes[] = $acao->getDescricao().'|'.$acao->getStatus();
            }
            $demandantes = array();
            foreach($elemento->getDemandantes() as $demandante){
                $demandantes[] = $demandante->getNome();
            }
            $strAcoes = implode(";", $acoes);
            $percentual = $this->calculaPercentual($elemento);
            $idMeta = $elemento->getId();
            echo '<tr onclick="mostraModalAcoes(\''.$strTextoModal.'\', \''.$strCorpo.'\', \''.$strAcoes.'\', '.$percentual.', '.$idMeta.')" class="'.$pinturaMeta.' '.$classeStatusMeta.$classResponsave.$classDemandante.'">';
            echo '<td>M'. str_pad($elemento->getId(), 3, 0, STR_PAD_LEFT).'</td>';
            echo '<td>'.$elemento->getDescricao().'</td>';
            $strToltipObs = "";
            if($elemento->getObservacao() != null){
                $strToltipObs = 'data-toggle="tooltip" data-placement="bottom" title="'.$elemento->getObservacao().'"';
            }
            echo '<td '.$strToltipObs.'>'.$this->situacaoStrMeta($elemento).'</td>';
            echo '<td>'.date("d/m/Y", strtotime($elemento->getDataInicioPlanejado())).'</td>';
            echo '<td>'.date("d/m/Y", strtotime($elemento->getDataFimPlanejado())).'</td>';
            echo '<td>'.implode(", ", $demandantes).'</td>';
            echo '<td>'.$elemento->getSetorResponsavel()->getNome().'</td>';
            echo '</tr>';
        }
        
        echo '
				</tbody>
			</table>
		
            
            
';
    }
    public function exibirPainel($lista){

        
        

        echo '





    <form id="painel">
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
          <label class="btn btn-secondary active">
            <input value="0" type="radio" name="painel-pdti" id="option1" autocomplete="off" checked> 2020
          </label>
          <label class="btn btn-secondary">
            <input value="1" type="radio" name="painel-pdti" id="option3" autocomplete="off"> 2021
          </label>
        </div>
    </form>


';

        echo '
            
        <table class="table table-bordered table-hover text-success" id="painel-2020">
          <thead>
            <tr class="bg-primary text-white">
              <th>#</th>';
        for($i = 1; $i< 13; $i++){
            echo '<th>'.$i.'/2020</th>';
        }
        
        
        echo '
            </tr>
          </thead>
          <tbody>';
        
        foreach($lista as $meta){
            $this->linhaMeta($meta, 2020);
        }
        
        echo '
          </tbody>
        </table>';
        echo '
            
        <table class="table table-bordered table-hover escondido" id="painel-2021">
          <thead>
            <tr class="bg-danger text-white">
              <th>#</th>';
        for($i = 1; $i< 13; $i++){
            echo '<th>'.$i.'/2021</th>';
        }
        
        
        echo '
            </tr>
          </thead>
          <tbody class="bg-transparent">';
        
        foreach($lista as $meta){
            $this->linhaMeta($meta, 2021);
        }
        
        
        
        
        echo '
          </tbody>
        </table>';

            
        
    }
    public function formarStrCorpoModal(Meta $meta){
        
        $strCorpo = 'Descrição: '.$meta->getDescricao().'<br>';
        
        $nomes = array();
        foreach($meta->getDemandantes() as $demandante){
            $nomes[] = $demandante->getNome();
        }
        
        $strCorpo .= 'Priorização: '.$meta->getPriorizacao().'<br>';
        $strCorpo .= 'Demandante(s): '.implode(", ", $nomes).'<br>';
        
        $strCorpo .= 'Setor Responsável: '.$meta->getSetorResponsavel()->getNome().'<br>';
        
        
        return $strCorpo;
    }
    //Atrasada, a iniciar, em execucao, concluída, conclusão atrasada.
    //Cinza(A fazer), Azul(Fazendo), Verde(feito), Vermelho(Em atrazo)
    const META_FEITA = 3;
    const META_A_FAZER = 2;
    const META_FAZENDO = 1;
    const META_EM_ATRASO = 4;
    const META_SUSPENSA = 5;
    const ACAO_STATUS_NAO_INICIADA = 0;
    const ACAO_STATUS_EM_ANDAMENTO = 1;
    const ACAO_STATUS_REALIZADA = 2;
    public function situacaoMeta(Meta $meta){
        if($meta->isSuspensa()){
            return self::META_SUSPENSA;
        }
        $concluido = 0;
        $iniciada = false;
        foreach($meta->getAcoes() as $acao){
            if($acao->getStatus() == self::ACAO_STATUS_REALIZADA){
                $concluido += $acao->getPercentual();
            }
            if($acao->getStatus() != self::ACAO_STATUS_NAO_INICIADA){
                if($acao->getPercentual() > 0){
                    $iniciada = true;
                }
            }
        }
        if($concluido == 100){
            return self::META_FEITA;        
        }
        if($iniciada){
            if(time() > strtotime($meta->getDataFimPlanejado().' 23:59:59')){
                return self::META_EM_ATRASO;
            }else{
                return self::META_FAZENDO;
            }
        }else
        {
            if(time() > strtotime($meta->getDataInicioPlanejado().' 23:59:59')){
                return self::META_EM_ATRASO;
            }else{
                return self::META_A_FAZER;
            }
        }
        
    }
    public function situacaoStrMeta(Meta $meta){
        if($meta->isSuspensa()){
            return "Suspensa";
        }
        $concluido = 0;
        $iniciada = false;
        foreach($meta->getAcoes() as $acao){
            if($acao->getStatus() == self::ACAO_STATUS_REALIZADA){
                $concluido += $acao->getPercentual();
            }
            if($acao->getStatus() != self::ACAO_STATUS_NAO_INICIADA){
                if($acao->getPercentual() > 0){
                    $iniciada = true;
                }
            }
        }
        if($concluido == 100){
            return "Feita";
        }
        if($iniciada){
            if(time() > strtotime($meta->getDataFimPlanejado().' 23:59:00')){
                return "Conclusã em Atraso";
            }else{
                return "Fazendo";
            }
        }else
        {
            if(time() > strtotime($meta->getDataInicioPlanejado().' 23:59:00')){
                return "Início em Atraso";
            }else{
                return "A Fazer";
            }
        }
        
    }
    public function linhaMeta(Meta $meta, $ano)
    {
        
        $pinturaMeta = '';
        $pinturaMeta = $this->retornaPinturaMeta($meta);
        
        $classeStatusMeta = '';
        $classeStatusMeta = $this->retornaClasseEstadoMeta($meta);
        
        $strTextoModal = 'Meta: M'.str_pad($meta->getId(), 3, 0, STR_PAD_LEFT);
        $strCorpo = $this->formarStrCorpoModal($meta);
        
        $classResponsave = "responsavel-".$meta->getSetorResponsavel()->getId();
        $classDemandante = "";
        foreach($meta->getDemandantes() as $demandante){
            $classDemandante .= ' demandante-'.$demandante->getId();
        }
        
        
        $acoes = array();
        foreach($meta->getAcoes() as $acao){
            $acoes[] = $acao->getDescricao().'|'.$acao->getStatus();
        }
        $strAcoes = implode(";", $acoes);
        $percentual = $this->calculaPercentual($meta);
        
        $idMeta = $meta->getId();
        echo '<tr  onclick="mostraModalAcoes(\''.$strTextoModal.'\', \''.$strCorpo.'\', \''.$strAcoes.'\', '.$percentual.', '.$idMeta.')" class="bg-light '.$classeStatusMeta.$classResponsave.$classDemandante.'" data-toggle="tooltip" data-placement="top" title="'.$meta->getDescricao()." - Planejamento: (".date("d/m/Y",strtotime($meta->getDataInicioPlanejado())).' - '.date("d/m/Y",strtotime($meta->getDataFimPlanejado())).')">';
        echo '<th scope="row">M'. str_pad($meta->getId(), 3, 0, STR_PAD_LEFT).'</th>';
        
        
        
        $dataInicio = $meta->getDataInicioPlanejado();
        $dataFim = $meta->getDataFimPlanejado();
        
        

        
        $data_inicial = new DateTime( $dataInicio );
        $data_final   = new DateTime( $dataFim );
        $mesesMarcar = array();
        while( $data_inicial <= $data_final ) {
            
            $mesesMarcar[$data_inicial->format( 'Y' )][intval($data_inicial->format( 'm' ))] = 'class="'.$pinturaMeta.'"';
            $data_inicial->add( DateInterval::createFromDateString( '1 days' ) );
            
        }
        
        
        $n = 0;
        for($i = 1; $i< 13; $i++)
        {
            if(isset($mesesMarcar[$ano][$i])){
                $n++;
            }
        }
        
        
        for($i = 1; $i< 13; $i++)
        {
            
//             class="bg-warning"
            $pintar = "";
            $barra = '';
            
            if(isset($mesesMarcar[$ano][$i])){
                $pintar = $mesesMarcar[$ano][$i].' COLSPAN="'.$n.'"';

                $i += $n -1;
                
                $barra = '
<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: '.$percentual.'%" aria-valuenow="'.$percentual.'" aria-valuemin="0" aria-valuemax="100">'.$percentual.'%</div>
</div>

';
                
            }
            
            echo '<td '.$pintar.'" >&nbsp;';
            echo $barra;
            echo '</td>';
            
        }
        echo '</tr>';
    }
    
    
    
    public function exibirPainelGeral($lista){
        
        
        

        
        echo '
            
        <table class="table table-bordered table-hover table-sm text-success">
          <thead>
            <tr class="bg-primary text-white text-center">
                <th colspan="12">2021</th><th colspan="12">2022</th>
            </tr>
            <tr class="bg-primary text-white">';
        for($i = 1; $i< 13; $i++){
            echo '<th>'.$i.'</th>';
        }
        
        for($i = 1; $i< 13; $i++){
            echo '<th>'.$i.'</th>';
        }
        echo '
            </tr>
          </thead>
          <tbody>';
        
        foreach($lista as $meta){
            $this->linhaMetaGeral($meta, 2021, 2022);
        }
        
        
        echo '
          </tbody>
        </table>';
    
        
        
    }
    public function retornaPinturaMeta(Meta $meta){
        $situacao = $this->situacaoMeta($meta);
        $strPintura = '';
        switch ($situacao){
            case self::META_EM_ATRASO:
                $strPintura = 'bg-danger text-white';
                break;
            case self::META_A_FAZER:
                $strPintura = 'bg-secondary text-white';
                break;
            case self::META_SUSPENSA:
                $strPintura = 'bg-secondary text-white';
                break;
            case self::META_FAZENDO:
                $strPintura = 'bg-info text-white';
                break;
            case self::META_FEITA:
                $strPintura = 'bg-success text-white';
                break;
            default:
                $strPintura = 'bg-transparent text-white';
                break;
        }
        return $strPintura;
    }
    public function retornaPinturaMetaPlanilha(Meta $meta){
        $situacao = $this->situacaoMeta($meta);
        $strPintura = '';
        switch ($situacao){
            case self::META_EM_ATRASO:
                $strPintura = 'bg-light text-danger';
                break;
            case self::META_A_FAZER:
                $strPintura = 'bg-light text-secondary';
                break;
            case self::META_SUSPENSA:
                $strPintura = 'bg-secondary text-white';
                break;
            case self::META_FAZENDO:
                $strPintura = 'bg-light text-info';
                break;
            case self::META_FEITA:
                $strPintura = 'bg-light  text-success';
                break;
            default:
                $strPintura = 'bg-transparent text-white';
                break;
        }
        return $strPintura;
    }
    public function retornaClasseEstadoMeta(Meta $meta){
        $situacao = $this->situacaoMeta($meta);
        $strPintura = '';
        switch ($situacao){
            case self::META_EM_ATRASO:
                $strPintura = ' status-atraso ';
                break;
            case self::META_A_FAZER:
                $strPintura = ' status-fazer ';
                break;
            case self::META_FAZENDO:
                $strPintura = ' status-fazendo ';
                break;
            case self::META_FEITA:
                $strPintura = ' status-feita ';
                break;
            case self::META_SUSPENSA:
                $strPintura = ' status-suspensa ';
                break;
            default:
                $strPintura = '';
                break;
        }
        return $strPintura;
    }
    public function linhaMetaGeral(Meta $meta, $ano, $ano2)
    {
        $pinturaMeta = '';
        $pinturaMeta = $this->retornaPinturaMeta($meta);
        
        $classeStatusMeta = '';
        $classeStatusMeta = $this->retornaClasseEstadoMeta($meta);
        
        $strTextoModal = 'Meta: M'.str_pad($meta->getId(), 3, 0, STR_PAD_LEFT);
        $strCorpo = $this->formarStrCorpoModal($meta);
        $classResponsave = "responsavel-".$meta->getSetorResponsavel()->getId();
        
        $classDemandante = "";
        foreach($meta->getDemandantes() as $demandante){
            $classDemandante .= ' demandante-'.$demandante->getId();
        }
        $acoes = array();
        foreach($meta->getAcoes() as $acao){
            $acoes[] = $acao->getDescricao().'|'.$acao->getStatus();
        }
        
        $percentual = $this->calculaPercentual($meta);
        $idMeta = $meta->getId();
        echo '<tr onclick="mostraModalAcoes(\''.$strTextoModal.'\', \''.$strCorpo.'\', '.$percentual.', '.$idMeta.')" 
        class="bg-light '.$classeStatusMeta.$classResponsave.$classDemandante.'" 
        data-toggle="tooltip" 
        data-placement="top" 
        title="'.$meta->getDescricao()." - Planejamento: (".date("d/m/Y",strtotime($meta->getDataInicioPlanejado())).' - '.date("d/m/Y",strtotime($meta->getDataFimPlanejado())).')">';
        
        
        
        
        
        $dataInicio = $meta->getDataInicioPlanejado();
        $dataFim = $meta->getDataFimPlanejado();
        
        
        
        
        $data_inicial = new DateTime( $dataInicio );
        $data_final   = new DateTime( $dataFim );
        $mesesMarcar = array();
        while( $data_inicial <= $data_final ) {
            
            $mesesMarcar[$data_inicial->format( 'Y' )][intval($data_inicial->format( 'm' ))] = 'class="'.$pinturaMeta.'"';
            $data_inicial->add( DateInterval::createFromDateString( '1 days' ) );
            
        }
        
        
        $n = 0;
        for($i = 1; $i< 13; $i++)
        {
            if(isset($mesesMarcar[$ano][$i])){
                $n++;
            }
        }
        
        
        for($i = 1; $i< 13; $i++)
        {
            $barra = '';
            $pintar = "";
            if(isset($mesesMarcar[$ano][$i])){
                $pintar = $mesesMarcar[$ano][$i].' COLSPAN="'.$n.'"';
                $i += $n -1;

            }
            echo '<td '.$pintar.'>&nbsp;'.$barra.'</td>';
            
        }
        
        $n = 0;
        for($i = 1; $i< 13; $i++)
        {
            if(isset($mesesMarcar[$ano2][$i])){
                $n++;
            }
        }
        
        
        for($i = 1; $i< 13; $i++)
        {
            $barra = '';
            $pintar = "";
            if(isset($mesesMarcar[$ano2][$i])){
                $pintar = $mesesMarcar[$ano2][$i].' COLSPAN="'.$n.'"';
                $i += $n -1;

            }
            echo '<td '.$pintar.'" >&nbsp;'.$barra.'</td>';
            
        }
        
        
        
        echo '</tr>';
    }
    
    
    
    
    
    
    
    
}

?>