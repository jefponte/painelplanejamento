<?php
                
/**
 * Classe feita para manipulação do objeto Acao
 * feita automaticamente com programa gerador de software inventado por
 * @author Jefferson Uchôa Ponte
 *
 *
 */



class AcaoDAO extends DAO {
    


            
            
    public function atualizar(Acao $acao)
    {
        $id = $acao->getId();
            
            
        $sql = "UPDATE acao
                SET
                descricao = :descricao,
                status = :status,
                percentual = :percentual
                WHERE acao.id = :id;";
			$descricao = $acao->getDescricao();
			$status = $acao->getStatus();
			$percentual = $acao->getPercentual();
            
        try {
            
            $stmt = $this->getConexao()->prepare($sql);
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			$stmt->bindParam(":descricao", $descricao, PDO::PARAM_STR);
			$stmt->bindParam(":status", $status, PDO::PARAM_INT);
			$stmt->bindParam(":percentual", $percentual, PDO::PARAM_STR);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
            
    }
            
            

    public function inserir(Acao $acao){
        $sql = "INSERT INTO acao(descricao, status, percentual) VALUES (:descricao, :status, :percentual);";
		$descricao = $acao->getDescricao();
		$status = $acao->getStatus();
		$percentual = $acao->getPercentual();
		try {
			$db = $this->getConexao();
			$stmt = $db->prepare($sql);
			$stmt->bindParam(":descricao", $descricao, PDO::PARAM_STR);
			$stmt->bindParam(":status", $status, PDO::PARAM_INT);
			$stmt->bindParam(":percentual", $percentual, PDO::PARAM_STR);
			return $stmt->execute();
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
            
    }
    public function inserirComPK(Acao $acao){
        $sql = "INSERT INTO acao(id, descricao, status, percentual) VALUES (:id, :descricao, :status, :percentual);";
		$id = $acao->getId();
		$descricao = $acao->getDescricao();
		$status = $acao->getStatus();
		$percentual = $acao->getPercentual();
		try {
			$db = $this->getConexao();
			$stmt = $db->prepare($sql);
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			$stmt->bindParam(":descricao", $descricao, PDO::PARAM_STR);
			$stmt->bindParam(":status", $status, PDO::PARAM_INT);
			$stmt->bindParam(":percentual", $percentual, PDO::PARAM_STR);
			return $stmt->execute();
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}

    }

	public function excluir(Acao $acao){
		$id = $acao->getId();
		$sql = "DELETE FROM acao WHERE id = :id";
		    
		try {
			$db = $this->getConexao();
			$stmt = $db->prepare($sql);
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			return $stmt->execute();
			    
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}


	public function retornaLista() {
		$lista = array ();
		$sql = "
		SELECT
        acao.id, 
        acao.descricao, 
        acao.status, 
        acao.percentual
		FROM acao
                 LIMIT 1000";

        try {
            $stmt = $this->conexao->prepare($sql);
            
		    if(!$stmt){   
                echo "<br>Mensagem de erro retornada: ".$this->conexao->errorInfo()[2]."<br>";
		        return $lista;
		    }
            $stmt->execute();
		    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    foreach ( $result as $linha ) 
            {
		        $acao = new Acao();
                $acao->setId( $linha ['id'] );
                $acao->setDescricao( $linha ['descricao'] );
                $acao->setStatus( $linha ['status'] );
                $acao->setPercentual( $linha ['percentual'] );
                $lista [] = $acao;

	
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
        return $lista;	
    }
        
                
    public function pesquisaPorId(Acao $acao) {
        $lista = array();
	    $id = $acao->getId();
                
        $sql = "
		SELECT
        acao.id, 
        acao.descricao, 
        acao.status, 
        acao.percentual
		FROM acao
            WHERE acao.id = :id";
                
        try {
                
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $linha ) {
                $acao = new Acao();
    	        $acao->setId( $linha ['id'] );
    	        $acao->setDescricao( $linha ['descricao'] );
    	        $acao->setStatus( $linha ['status'] );
    	        $acao->setPercentual( $linha ['percentual'] );
    			$lista [] = $acao;
    			    
            }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function pesquisaPorDescricao(Acao $acao) {
        $lista = array();
	    $descricao = $acao->getDescricao();
                
        $sql = "
		SELECT
        acao.id, 
        acao.descricao, 
        acao.status, 
        acao.percentual
		FROM acao
            WHERE acao.descricao like :descricao";
                
        try {
                
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindParam(":descricao", $descricao, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $linha ) {
                $acao = new Acao();
    	        $acao->setId( $linha ['id'] );
    	        $acao->setDescricao( $linha ['descricao'] );
    	        $acao->setStatus( $linha ['status'] );
    	        $acao->setPercentual( $linha ['percentual'] );
    			$lista [] = $acao;
    			    
            }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function pesquisaPorStatus(Acao $acao) {
        $lista = array();
	    $status = $acao->getStatus();
                
        $sql = "
		SELECT
        acao.id, 
        acao.descricao, 
        acao.status, 
        acao.percentual
		FROM acao
            WHERE acao.status = :status";
                
        try {
                
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindParam(":status", $status, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $linha ) {
                $acao = new Acao();
    	        $acao->setId( $linha ['id'] );
    	        $acao->setDescricao( $linha ['descricao'] );
    	        $acao->setStatus( $linha ['status'] );
    	        $acao->setPercentual( $linha ['percentual'] );
    			$lista [] = $acao;
    			    
            }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function pesquisaPorPercentual(Acao $acao) {
        $lista = array();
	    $percentual = $acao->getPercentual();
                
        $sql = "
		SELECT
        acao.id, 
        acao.descricao, 
        acao.status, 
        acao.percentual
		FROM acao
            WHERE acao.percentual = :percentual";
                
        try {
                
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindParam(":percentual", $percentual, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $linha ) {
                $acao = new Acao();
    	        $acao->setId( $linha ['id'] );
    	        $acao->setDescricao( $linha ['descricao'] );
    	        $acao->setStatus( $linha ['status'] );
    	        $acao->setPercentual( $linha ['percentual'] );
    			$lista [] = $acao;
    			    
            }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function preenchePorId(Acao $acao) {
        
	    $id = $acao->getId();
	    $sql = "
		SELECT
        acao.id, 
        acao.descricao, 
        acao.status, 
        acao.percentual
		FROM acao
                WHERE acao.id = :id
                 LIMIT 1000";
                
        try {
            $stmt = $this->conexao->prepare($sql);
                
		    if(!$stmt){
                echo "<br>Mensagem de erro retornada: ".$this->conexao->errorInfo()[2]."<br>";
		    }
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
		    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    foreach ( $result as $linha )
            {
                $acao->setId( $linha ['id'] );
                $acao->setDescricao( $linha ['descricao'] );
                $acao->setStatus( $linha ['status'] );
                $acao->setPercentual( $linha ['percentual'] );
                
                
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
		return $acao;
    }
                
    public function preenchePorDescricao(Acao $acao) {
        
	    $descricao = $acao->getDescricao();
	    $sql = "
		SELECT
        acao.id, 
        acao.descricao, 
        acao.status, 
        acao.percentual
		FROM acao
                WHERE acao.descricao = :descricao
                 LIMIT 1000";
                
        try {
            $stmt = $this->conexao->prepare($sql);
                
		    if(!$stmt){
                echo "<br>Mensagem de erro retornada: ".$this->conexao->errorInfo()[2]."<br>";
		    }
            $stmt->bindParam(":descricao", $descricao, PDO::PARAM_STR);
            $stmt->execute();
		    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    foreach ( $result as $linha )
            {
                $acao->setId( $linha ['id'] );
                $acao->setDescricao( $linha ['descricao'] );
                $acao->setStatus( $linha ['status'] );
                $acao->setPercentual( $linha ['percentual'] );
                
                
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
		return $acao;
    }
                
    public function preenchePorStatus(Acao $acao) {
        
	    $status = $acao->getStatus();
	    $sql = "
		SELECT
        acao.id, 
        acao.descricao, 
        acao.status, 
        acao.percentual
		FROM acao
                WHERE acao.status = :status
                 LIMIT 1000";
                
        try {
            $stmt = $this->conexao->prepare($sql);
                
		    if(!$stmt){
                echo "<br>Mensagem de erro retornada: ".$this->conexao->errorInfo()[2]."<br>";
		    }
            $stmt->bindParam(":status", $status, PDO::PARAM_INT);
            $stmt->execute();
		    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    foreach ( $result as $linha )
            {
                $acao->setId( $linha ['id'] );
                $acao->setDescricao( $linha ['descricao'] );
                $acao->setStatus( $linha ['status'] );
                $acao->setPercentual( $linha ['percentual'] );
                
                
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
		return $acao;
    }
                
    public function preenchePorPercentual(Acao $acao) {
        
	    $percentual = $acao->getPercentual();
	    $sql = "
		SELECT
        acao.id, 
        acao.descricao, 
        acao.status, 
        acao.percentual
		FROM acao
                WHERE acao.percentual = :percentual
                 LIMIT 1000";
                
        try {
            $stmt = $this->conexao->prepare($sql);
                
		    if(!$stmt){
                echo "<br>Mensagem de erro retornada: ".$this->conexao->errorInfo()[2]."<br>";
		    }
            $stmt->bindParam(":percentual", $percentual, PDO::PARAM_STR);
            $stmt->execute();
		    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    foreach ( $result as $linha )
            {
                $acao->setId( $linha ['id'] );
                $acao->setDescricao( $linha ['descricao'] );
                $acao->setStatus( $linha ['status'] );
                $acao->setPercentual( $linha ['percentual'] );
                
                
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
		return $acao;
    }
}