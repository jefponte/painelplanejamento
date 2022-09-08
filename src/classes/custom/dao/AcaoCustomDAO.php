<?php
                
/**
 * Customize sua classe
 *
 */



class  AcaoCustomDAO extends AcaoDAO {
    
    public function atualizar(Acao $acao)
    {
        $id = $acao->getId();
        
        
        $sql = "UPDATE acao
                SET
                status = :status,
                percentual = :percentual
                WHERE acao.id = :id;";
        $status = $acao->getStatus();
        $percentual = $acao->getPercentual();
        
        try {
            
            $stmt = $this->getConexao()->prepare($sql);
            $stmt->bindParam("id", $id, PDO::PARAM_STR);
            $stmt->bindParam("status", $status, PDO::PARAM_INT);
            $stmt->bindParam("percentual", $percentual, PDO::PARAM_STR);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        
    }
    
    

}