<?php
                
/**
 * Customize sua classe
 *
 */



class  MetaCustomDAO extends MetaDAO {
    public function atualizar(Meta $meta)
    {
        $id = $meta->getId();
        
        
        $sql = "UPDATE meta
                SET
                descricao = :descricao,
                data_inicio_planejado = :dataInicioPlanejado,
                data_fim_planejado = :dataFimPlanejado,
                data_inicio = :dataInicio,
                data_fim = :dataFim,
                id_setor_responsavel = :idResponsavel,
                observacao = :observacao,
                suspensa = :suspensa
                WHERE meta.id = :id;";
        
        $descricao = $meta->getDescricao();
        $dataInicioPlanejado = $meta->getDataInicioPlanejado();
        $dataFimPlanejado = $meta->getDataFimPlanejado();
        $dataInicio = $meta->getDataInicio();
        $dataFim = $meta->getDataFim();
        $observacao = $meta->getObservacao();
        $suspensa = $meta->isSuspensa();
        $idResponsavel = $meta->getSetorResponsavel()->getId();
        
        
        try {
            
            $stmt = $this->getConexao()->prepare($sql);
            $stmt->bindParam("id", $id, PDO::PARAM_INT);
            $stmt->bindParam("descricao", $descricao, PDO::PARAM_STR);
            $stmt->bindParam("dataInicioPlanejado", $dataInicioPlanejado, PDO::PARAM_STR);
            $stmt->bindParam("dataFimPlanejado", $dataFimPlanejado, PDO::PARAM_STR);
            $stmt->bindParam(":observacao", $observacao, PDO::PARAM_STR);
            $stmt->bindParam(":suspensa", $suspensa, PDO::PARAM_BOOL);
            if($dataInicio != null){
                $stmt->bindParam("dataInicio", $dataInicio, PDO::PARAM_STR);
            }else{
                $stmt->bindParam("dataInicio", $dataInicio, PDO::PARAM_NULL);
            }
            if($dataFim != null){
                $stmt->bindParam("dataFim", $dataFim, PDO::PARAM_STR);
            }else{
                $stmt->bindParam("dataFim", $dataFim, PDO::PARAM_NULL);
            }
            
            $stmt->bindParam("idResponsavel", $idResponsavel, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        
    }
    
    public function retornaLista() {
        $lista = array ();
        $sql = "        SELECT
        meta.id,
        meta.descricao,
        meta.data_inicio_planejado,
        meta.data_fim_planejado,
        meta.data_inicio,
        meta.data_fim,
        meta.priorizacao,
        meta.observacao,
        meta.suspensa, 
        setor.id as id_setor_responsavel,
        setor.nome as nome_setor_responsavel
        FROM meta
        INNER JOIN setor ON setor.id = meta.id_setor_responsavel
        ORDER BY priorizacao DESC
        LIMIT 1000";
        
        $result = $this->getConexao ()->query ( $sql );
        
        foreach ( $result as $linha ) {
            
            $meta = new Meta();
            
            $meta->setId( $linha ['id'] );
            $meta->setDescricao( $linha ['descricao'] );
            $meta->setDataInicioPlanejado( $linha ['data_inicio_planejado'] );
            $meta->setDataFimPlanejado( $linha ['data_fim_planejado'] );
            $meta->setDataInicio( $linha ['data_inicio'] );
            $meta->setDataFim( $linha ['data_fim'] );
            $meta->getSetorResponsavel()->setId( $linha ['id_setor_responsavel'] );
            $meta->getSetorResponsavel()->setNome( $linha ['nome_setor_responsavel'] );
            $this->acoesDaMeta($meta);
            $meta->setObservacao($linha['observacao']);
            $meta->setSuspensa($linha['suspensa']);
            $this->buscarDemandantes($meta);
            $meta->setPriorizacao($linha['priorizacao']);
            $lista [] = $meta;
        }
        return $lista;
    }
    public function acoesDaMeta(Meta $meta) {
        $lista = array();
        $id = $meta->getId();
        $sql = "SELECT
                acao.id,
                acao.descricao,
                acao.status,
                acao.percentual,
                acao.id_meta
                FROM acao
                WHERE acao.id_meta = $id";
        $result = $this->getConexao ()->query ( $sql );
        
        foreach ( $result as $linha ) {
            $acao = new Acao();
            $acao->setId( $linha ['id'] );
            $acao->setDescricao( $linha ['descricao'] );
            $acao->setStatus( $linha ['status'] );
            $acao->setPercentual( $linha ['percentual'] );
            $meta->addAcao($acao);
            
        }
        
        return $lista;
    }
    

}