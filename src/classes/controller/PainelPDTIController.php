<?php 


class PainelPDTIController{
    
    const ACAO_STATUS_NAO_INICIADA = 0;
    const ACAO_STATUS_EM_ANDAMENTO = 1;
    const ACAO_STATUS_REALIZADA = 2;
    
    public static function  getStrStatus(Acao $acao){
        $strStatus = "";
        switch($acao->getStatus()){
            case self::ACAO_STATUS_NAO_INICIADA:
                $strStatus = "A FAZER";
                break;
            case self::ACAO_STATUS_EM_ANDAMENTO:
                $strStatus = "FAZENDO";
                break;
            case self::ACAO_STATUS_REALIZADA:
                $strStatus = "FEITA";
                break;
                
        }
        return $strStatus;
    }
    
    public static function main2($list){

        $lista = array();
        $arrDemandantes = array();
        $situacoes = array();
        foreach($list as $key => $element){
                $meta = new Meta();
                $meta->setId(intval($key)+1);
                $meta->setDescricao($element['Objeto']);
                $data1 = $element['Data Estimada da abertura do processo (CALENDÁRIO)'];
                $data2 = $element['Data Estimada de contratação (PAC)'];

                if($data1 == null || $data1 == "NI"){
                        $dataInicio = "";
                }else{
                        $dataInicio = implode('-', array_reverse(explode('/', $data1)));
                }
                if($data2 == null || $data2 == "NI"){
                        $dataFim = "";
                }else{
                        $dataFim = implode('-', array_reverse(explode('/', $data2)));
                }
                $meta->setDataInicioPlanejado($dataInicio);
                $meta->setDataFimPlanejado($dataFim);
                $demandantesStr = $element['Unidade(s) Demandante(s)'];
                $demandantes = explode('/', $demandantesStr);
                $situacoes[$element['Situação']] = $element['Situação'];
                $meta->setSituacao($element['Situação']);
                foreach($demandantes as $dem){
                        $dem2 =  new Demandante();
                        $dem2->setId($dem);
                        $dem2->setNome($dem);
                        $meta->addDemandante($dem2);
                        $arrDemandantes[$dem2->getId()] = $dem2;
                }
                

                /*
                echo '<tr>';
                if($element['LINK'] != null){
                    echo '<td><a target="_blank" href="'.$element['LINK'].'">'.$element['Processo'].'</a></td>';
                }else{
                    echo '<td>'.$element['Processo'].'</td>';
                }
                

                echo '<td></td><td>'..'</td><td>'.</td><td>'..'</td><td>'.$element['Situação'].'</td></tr>';
                */
                $lista[] = $meta;
        }
        $painelView = new PainelPDTIView();
        
        echo '<div class="row justify-content-center">';
        echo '<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">';

    
        
        echo '<br><br>';
        echo '</div>';
        echo '<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">';
        
       
        
        $demandantes = $arrDemandantes;
        
        
        echo '
            
<form>
<div class="form-group">
<select class="form-control" id="select-demandante">';
        echo '
<option value="">Filtrar Por Demandante</option>';
        echo '
<option value="todos">Todos os Demandantes</option>';
        foreach ($demandantes as $demandante) {
            echo '
<option value="' . $demandante->getId() . '">' . $demandante->getNome() . '</option>';
        }
        echo '
</select>

       

<select class="form-control" id="select-status-meta">
        <option value="">Filtrar Por Estado da Meta</option>
        <option value="todos">Todos os Estados</option>
';
foreach( $situacoes as $situacao){
        echo '<option value="'.$situacao.'">'.$situacao.'</option>';
}

        
echo '
          
</select>



</div>
</form>
';
        
        echo '</div>';
        echo '</div>';
        

        
        echo '<div id="painel-resumido" class="table-responsive">';
        
        $painelView->exibirPainelGeral($lista);
        echo '</div>';
        
        
        

        
    }
    
    
    
}





?>