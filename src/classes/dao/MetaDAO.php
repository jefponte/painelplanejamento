<?php
                
/**
 * Classe feita para manipulação do objeto Meta
 * feita automaticamente com programa gerador de software inventado por
 * @author Jefferson Uchôa Ponte
 *
 *
 */



class MetaDAO extends DAO {
    


            
            
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
                priorizacao = :priorizacao,
                observacao = :observacao,
                suspensa = :suspensa
                WHERE meta.id = :id;";
			$descricao = $meta->getDescricao();
			$dataInicioPlanejado = $meta->getDataInicioPlanejado();
			$dataFimPlanejado = $meta->getDataFimPlanejado();
			$dataInicio = $meta->getDataInicio();
			$dataFim = $meta->getDataFim();
			$priorizacao = $meta->getPriorizacao();
            $observacao = $meta->getObservacao();
            $suspensa = $meta->isSuspensa();
            
        try {
            
            $stmt = $this->getConexao()->prepare($sql);
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			$stmt->bindParam(":descricao", $descricao, PDO::PARAM_STR);
			$stmt->bindParam(":dataInicioPlanejado", $dataInicioPlanejado, PDO::PARAM_STR);
			$stmt->bindParam(":dataFimPlanejado", $dataFimPlanejado, PDO::PARAM_STR);
			$stmt->bindParam(":dataInicio", $dataInicio, PDO::PARAM_STR);
			$stmt->bindParam(":dataFim", $dataFim, PDO::PARAM_STR);
			$stmt->bindParam(":priorizacao", $priorizacao, PDO::PARAM_INT);
            $stmt->bindParam(":observacao", $observacao, PDO::PARAM_STR);
            $stmt->bindParam(":suspensa", $suspensa, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
            
    }
            
            

    public function inserir(Meta $meta){
        $sql = "INSERT INTO meta(descricao, data_inicio_planejado, data_fim_planejado, data_inicio, data_fim, id_setor_responsavel, priorizacao) VALUES (:descricao, :dataInicioPlanejado, :dataFimPlanejado, :dataInicio, :dataFim, :setorResponsavel, :priorizacao);";
		$descricao = $meta->getDescricao();
		$dataInicioPlanejado = $meta->getDataInicioPlanejado();
		$dataFimPlanejado = $meta->getDataFimPlanejado();
		$dataInicio = $meta->getDataInicio();
		$dataFim = $meta->getDataFim();
		$setorResponsavel = $meta->getSetorResponsavel()->getId();
		$priorizacao = $meta->getPriorizacao();
		try {
			$db = $this->getConexao();
			$stmt = $db->prepare($sql);
			$stmt->bindParam(":descricao", $descricao, PDO::PARAM_STR);
			$stmt->bindParam(":dataInicioPlanejado", $dataInicioPlanejado, PDO::PARAM_STR);
			$stmt->bindParam(":dataFimPlanejado", $dataFimPlanejado, PDO::PARAM_STR);
			$stmt->bindParam(":dataInicio", $dataInicio, PDO::PARAM_STR);
			$stmt->bindParam(":dataFim", $dataFim, PDO::PARAM_STR);
			$stmt->bindParam(":setorResponsavel", $setorResponsavel, PDO::PARAM_INT);
			$stmt->bindParam(":priorizacao", $priorizacao, PDO::PARAM_INT);
			return $stmt->execute();
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
            
    }
    public function inserirComPK(Meta $meta){
        $sql = "INSERT INTO meta(id, descricao, data_inicio_planejado, data_fim_planejado, data_inicio, data_fim, id_setor_setor_responsavel, priorizacao) VALUES (:id, :descricao, :dataInicioPlanejado, :dataFimPlanejado, :dataInicio, :dataFim, :setorResponsavel, :priorizacao);";
		$id = $meta->getId();
		$descricao = $meta->getDescricao();
		$dataInicioPlanejado = $meta->getDataInicioPlanejado();
		$dataFimPlanejado = $meta->getDataFimPlanejado();
		$dataInicio = $meta->getDataInicio();
		$dataFim = $meta->getDataFim();
		$setorResponsavel = $meta->getSetorResponsavel()->getId();
		$priorizacao = $meta->getPriorizacao();
		try {
			$db = $this->getConexao();
			$stmt = $db->prepare($sql);
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			$stmt->bindParam(":descricao", $descricao, PDO::PARAM_STR);
			$stmt->bindParam(":dataInicioPlanejado", $dataInicioPlanejado, PDO::PARAM_STR);
			$stmt->bindParam(":dataFimPlanejado", $dataFimPlanejado, PDO::PARAM_STR);
			$stmt->bindParam(":dataInicio", $dataInicio, PDO::PARAM_STR);
			$stmt->bindParam(":dataFim", $dataFim, PDO::PARAM_STR);
			$stmt->bindParam(":setorResponsavel", $setorResponsavel, PDO::PARAM_INT);
			$stmt->bindParam(":priorizacao", $priorizacao, PDO::PARAM_INT);
			return $stmt->execute();
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}

    }

	public function excluir(Meta $meta){
		$id = $meta->getId();
		$sql = "DELETE FROM meta WHERE id = :id";
		    
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
        meta.id, 
        meta.descricao, 
        meta.data_inicio_planejado, 
        meta.data_fim_planejado, 
        meta.data_inicio, 
        meta.data_fim, 
        meta.priorizacao, 
        setor_responsavel.id as id_setor_setor_responsavel, 
        setor_responsavel.nome as nome_setor_setor_responsavel
		FROM meta
		INNER JOIN setor as setor_responsavel ON setor_responsavel.id = meta.id_setor_responsavel
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
		        $meta = new Meta();
                $meta->setId( $linha ['id'] );
                $meta->setDescricao( $linha ['descricao'] );
                $meta->setDataInicioPlanejado( $linha ['data_inicio_planejado'] );
                $meta->setDataFimPlanejado( $linha ['data_fim_planejado'] );
                $meta->setDataInicio( $linha ['data_inicio'] );
                $meta->setDataFim( $linha ['data_fim'] );
                $meta->setPriorizacao( $linha ['priorizacao'] );
                $meta->getSetorResponsavel()->setId( $linha ['id_setor_setor_responsavel'] );
                $meta->getSetorResponsavel()->setNome( $linha ['nome_setor_setor_responsavel'] );
                $lista [] = $meta;

	
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
        return $lista;	
    }
        
                
    public function pesquisaPorId(Meta $meta) {
        $lista = array();
	    $id = $meta->getId();
                
        $sql = "
		SELECT
        meta.id, 
        meta.descricao, 
        meta.data_inicio_planejado, 
        meta.data_fim_planejado, 
        meta.data_inicio, 
        meta.data_fim, 
        meta.priorizacao, 
        setor_responsavel.id as id_setor_setor_responsavel, 
        setor_responsavel.nome as nome_setor_setor_responsavel
		FROM meta
		INNER JOIN setor as setor_responsavel ON setor_responsavel.id = meta.id_setor_responsavel
            WHERE meta.id = :id";
                
        try {
                
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $linha ) {
                $meta = new Meta();
    	        $meta->setId( $linha ['id'] );
    	        $meta->setDescricao( $linha ['descricao'] );
    	        $meta->setDataInicioPlanejado( $linha ['data_inicio_planejado'] );
    	        $meta->setDataFimPlanejado( $linha ['data_fim_planejado'] );
    	        $meta->setDataInicio( $linha ['data_inicio'] );
    	        $meta->setDataFim( $linha ['data_fim'] );
    	        $meta->setPriorizacao( $linha ['priorizacao'] );
    			$meta->getSetorResponsavel()->setId( $linha ['id_setor_setor_responsavel'] );
    			$meta->getSetorResponsavel()->setNome( $linha ['nome_setor_setor_responsavel'] );
    			$lista [] = $meta;
    			    
            }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function pesquisaPorDescricao(Meta $meta) {
        $lista = array();
	    $descricao = $meta->getDescricao();
                
        $sql = "
		SELECT
        meta.id, 
        meta.descricao, 
        meta.data_inicio_planejado, 
        meta.data_fim_planejado, 
        meta.data_inicio, 
        meta.data_fim, 
        meta.priorizacao, 
        setor_responsavel.id as id_setor_setor_responsavel, 
        setor_responsavel.nome as nome_setor_setor_responsavel
		FROM meta
		INNER JOIN setor as setor_responsavel ON setor_responsavel.id = meta.id_setor_responsavel
            WHERE meta.descricao like :descricao";
                
        try {
                
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindParam(":descricao", $descricao, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $linha ) {
                $meta = new Meta();
    	        $meta->setId( $linha ['id'] );
    	        $meta->setDescricao( $linha ['descricao'] );
    	        $meta->setDataInicioPlanejado( $linha ['data_inicio_planejado'] );
    	        $meta->setDataFimPlanejado( $linha ['data_fim_planejado'] );
    	        $meta->setDataInicio( $linha ['data_inicio'] );
    	        $meta->setDataFim( $linha ['data_fim'] );
    	        $meta->setPriorizacao( $linha ['priorizacao'] );
    			$meta->getSetorResponsavel()->setId( $linha ['id_setor_setor_responsavel'] );
    			$meta->getSetorResponsavel()->setNome( $linha ['nome_setor_setor_responsavel'] );
    			$lista [] = $meta;
    			    
            }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function pesquisaPorDataInicioPlanejado(Meta $meta) {
        $lista = array();
	    $dataInicioPlanejado = $meta->getDataInicioPlanejado();
                
        $sql = "
		SELECT
        meta.id, 
        meta.descricao, 
        meta.data_inicio_planejado, 
        meta.data_fim_planejado, 
        meta.data_inicio, 
        meta.data_fim, 
        meta.priorizacao, 
        setor_responsavel.id as id_setor_setor_responsavel, 
        setor_responsavel.nome as nome_setor_setor_responsavel
		FROM meta
		INNER JOIN setor as setor_responsavel ON setor_responsavel.id = meta.id_setor_responsavel
            WHERE meta.data_inicio_planejado like :dataInicioPlanejado";
                
        try {
                
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindParam(":dataInicioPlanejado", $dataInicioPlanejado, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $linha ) {
                $meta = new Meta();
    	        $meta->setId( $linha ['id'] );
    	        $meta->setDescricao( $linha ['descricao'] );
    	        $meta->setDataInicioPlanejado( $linha ['data_inicio_planejado'] );
    	        $meta->setDataFimPlanejado( $linha ['data_fim_planejado'] );
    	        $meta->setDataInicio( $linha ['data_inicio'] );
    	        $meta->setDataFim( $linha ['data_fim'] );
    	        $meta->setPriorizacao( $linha ['priorizacao'] );
    			$meta->getSetorResponsavel()->setId( $linha ['id_setor_setor_responsavel'] );
    			$meta->getSetorResponsavel()->setNome( $linha ['nome_setor_setor_responsavel'] );
    			$lista [] = $meta;
    			    
            }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function pesquisaPorDataFimPlanejado(Meta $meta) {
        $lista = array();
	    $dataFimPlanejado = $meta->getDataFimPlanejado();
                
        $sql = "
		SELECT
        meta.id, 
        meta.descricao, 
        meta.data_inicio_planejado, 
        meta.data_fim_planejado, 
        meta.data_inicio, 
        meta.data_fim, 
        meta.priorizacao, 
        setor_responsavel.id as id_setor_setor_responsavel, 
        setor_responsavel.nome as nome_setor_setor_responsavel
		FROM meta
		INNER JOIN setor as setor_responsavel ON setor_responsavel.id = meta.id_setor_responsavel
            WHERE meta.data_fim_planejado like :dataFimPlanejado";
                
        try {
                
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindParam(":dataFimPlanejado", $dataFimPlanejado, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $linha ) {
                $meta = new Meta();
    	        $meta->setId( $linha ['id'] );
    	        $meta->setDescricao( $linha ['descricao'] );
    	        $meta->setDataInicioPlanejado( $linha ['data_inicio_planejado'] );
    	        $meta->setDataFimPlanejado( $linha ['data_fim_planejado'] );
    	        $meta->setDataInicio( $linha ['data_inicio'] );
    	        $meta->setDataFim( $linha ['data_fim'] );
    	        $meta->setPriorizacao( $linha ['priorizacao'] );
    			$meta->getSetorResponsavel()->setId( $linha ['id_setor_setor_responsavel'] );
    			$meta->getSetorResponsavel()->setNome( $linha ['nome_setor_setor_responsavel'] );
    			$lista [] = $meta;
    			    
            }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function pesquisaPorDataInicio(Meta $meta) {
        $lista = array();
	    $dataInicio = $meta->getDataInicio();
                
        $sql = "
		SELECT
        meta.id, 
        meta.descricao, 
        meta.data_inicio_planejado, 
        meta.data_fim_planejado, 
        meta.data_inicio, 
        meta.data_fim, 
        meta.priorizacao, 
        setor_responsavel.id as id_setor_setor_responsavel, 
        setor_responsavel.nome as nome_setor_setor_responsavel
		FROM meta
		INNER JOIN setor as setor_responsavel ON setor_responsavel.id = meta.id_setor_responsavel
            WHERE meta.data_inicio like :dataInicio";
                
        try {
                
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindParam(":dataInicio", $dataInicio, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $linha ) {
                $meta = new Meta();
    	        $meta->setId( $linha ['id'] );
    	        $meta->setDescricao( $linha ['descricao'] );
    	        $meta->setDataInicioPlanejado( $linha ['data_inicio_planejado'] );
    	        $meta->setDataFimPlanejado( $linha ['data_fim_planejado'] );
    	        $meta->setDataInicio( $linha ['data_inicio'] );
    	        $meta->setDataFim( $linha ['data_fim'] );
    	        $meta->setPriorizacao( $linha ['priorizacao'] );
    			$meta->getSetorResponsavel()->setId( $linha ['id_setor_setor_responsavel'] );
    			$meta->getSetorResponsavel()->setNome( $linha ['nome_setor_setor_responsavel'] );
    			$lista [] = $meta;
    			    
            }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function pesquisaPorDataFim(Meta $meta) {
        $lista = array();
	    $dataFim = $meta->getDataFim();
                
        $sql = "
		SELECT
        meta.id, 
        meta.descricao, 
        meta.data_inicio_planejado, 
        meta.data_fim_planejado, 
        meta.data_inicio, 
        meta.data_fim, 
        meta.priorizacao, 
        setor_responsavel.id as id_setor_setor_responsavel, 
        setor_responsavel.nome as nome_setor_setor_responsavel
		FROM meta
		INNER JOIN setor as setor_responsavel ON setor_responsavel.id = meta.id_setor_responsavel
            WHERE meta.data_fim like :dataFim";
                
        try {
                
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindParam(":dataFim", $dataFim, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $linha ) {
                $meta = new Meta();
    	        $meta->setId( $linha ['id'] );
    	        $meta->setDescricao( $linha ['descricao'] );
    	        $meta->setDataInicioPlanejado( $linha ['data_inicio_planejado'] );
    	        $meta->setDataFimPlanejado( $linha ['data_fim_planejado'] );
    	        $meta->setDataInicio( $linha ['data_inicio'] );
    	        $meta->setDataFim( $linha ['data_fim'] );
    	        $meta->setPriorizacao( $linha ['priorizacao'] );
    			$meta->getSetorResponsavel()->setId( $linha ['id_setor_setor_responsavel'] );
    			$meta->getSetorResponsavel()->setNome( $linha ['nome_setor_setor_responsavel'] );
    			$lista [] = $meta;
    			    
            }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function pesquisaPorPriorizacao(Meta $meta) {
        $lista = array();
	    $priorizacao = $meta->getPriorizacao();
                
        $sql = "
		SELECT
        meta.id, 
        meta.descricao, 
        meta.data_inicio_planejado, 
        meta.data_fim_planejado, 
        meta.data_inicio, 
        meta.data_fim, 
        meta.priorizacao, 
        setor_responsavel.id as id_setor_setor_responsavel, 
        setor_responsavel.nome as nome_setor_setor_responsavel
		FROM meta
		INNER JOIN setor as setor_responsavel ON setor_responsavel.id = meta.id_setor_responsavel
            WHERE meta.priorizacao = :priorizacao";
                
        try {
                
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindParam(":priorizacao", $priorizacao, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $linha ) {
                $meta = new Meta();
    	        $meta->setId( $linha ['id'] );
    	        $meta->setDescricao( $linha ['descricao'] );
    	        $meta->setDataInicioPlanejado( $linha ['data_inicio_planejado'] );
    	        $meta->setDataFimPlanejado( $linha ['data_fim_planejado'] );
    	        $meta->setDataInicio( $linha ['data_inicio'] );
    	        $meta->setDataFim( $linha ['data_fim'] );
    	        $meta->setPriorizacao( $linha ['priorizacao'] );
    			$meta->getSetorResponsavel()->setId( $linha ['id_setor_setor_responsavel'] );
    			$meta->getSetorResponsavel()->setNome( $linha ['nome_setor_setor_responsavel'] );
    			$lista [] = $meta;
    			    
            }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function preenchePorId(Meta $meta) {
        
	    $id = $meta->getId();
	    $sql = "
		SELECT
        meta.id, 
        meta.descricao, 
        meta.data_inicio_planejado, 
        meta.data_fim_planejado, 
        meta.data_inicio, 
        meta.data_fim, 
        meta.observacao, meta.suspensa,
        meta.priorizacao, 
        setor_responsavel.id as id_setor_setor_responsavel, 
        setor_responsavel.nome as nome_setor_setor_responsavel
		FROM meta
		INNER JOIN setor as setor_responsavel ON setor_responsavel.id = meta.id_setor_responsavel
                WHERE meta.id = :id
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
                $meta->setId( $linha ['id'] );
                $meta->setDescricao( $linha ['descricao'] );
                $meta->setDataInicioPlanejado( $linha ['data_inicio_planejado'] );
                $meta->setDataFimPlanejado( $linha ['data_fim_planejado'] );
                $meta->setDataInicio( $linha ['data_inicio'] );
                $meta->setDataFim( $linha ['data_fim'] );
                $meta->setPriorizacao( $linha ['priorizacao'] );
                $meta->setObservacao($linha['observacao']);
                $meta->setSuspensa($linha['suspensa']);
                $meta->getSetorResponsavel()->setId( $linha ['id_setor_setor_responsavel'] );
                $meta->getSetorResponsavel()->setNome( $linha ['nome_setor_setor_responsavel'] );
                
                
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
		return $meta;
    }
                
    public function preenchePorDescricao(Meta $meta) {
        
	    $descricao = $meta->getDescricao();
	    $sql = "
		SELECT
        meta.id, 
        meta.descricao, 
        meta.data_inicio_planejado, 
        meta.data_fim_planejado, 
        meta.data_inicio, 
        meta.data_fim, 
        meta.priorizacao, 
        setor_responsavel.id as id_setor_setor_responsavel, 
        setor_responsavel.nome as nome_setor_setor_responsavel
		FROM meta
		INNER JOIN setor as setor_responsavel ON setor_responsavel.id = meta.id_setor_responsavel
                WHERE meta.descricao = :descricao
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
                $meta->setId( $linha ['id'] );
                $meta->setDescricao( $linha ['descricao'] );
                $meta->setDataInicioPlanejado( $linha ['data_inicio_planejado'] );
                $meta->setDataFimPlanejado( $linha ['data_fim_planejado'] );
                $meta->setDataInicio( $linha ['data_inicio'] );
                $meta->setDataFim( $linha ['data_fim'] );
                $meta->setPriorizacao( $linha ['priorizacao'] );
                $meta->getSetorResponsavel()->setId( $linha ['id_setor_setor_responsavel'] );
                $meta->getSetorResponsavel()->setNome( $linha ['nome_setor_setor_responsavel'] );
                
                
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
		return $meta;
    }
                
    public function preenchePorDataInicioPlanejado(Meta $meta) {
        
	    $dataInicioPlanejado = $meta->getDataInicioPlanejado();
	    $sql = "
		SELECT
        meta.id, 
        meta.descricao, 
        meta.data_inicio_planejado, 
        meta.data_fim_planejado, 
        meta.data_inicio, 
        meta.data_fim, 
        meta.priorizacao, 
        setor_responsavel.id as id_setor_setor_responsavel, 
        setor_responsavel.nome as nome_setor_setor_responsavel
		FROM meta
		INNER JOIN setor as setor_responsavel ON setor_responsavel.id = meta.id_setor_responsavel
                WHERE meta.data_inicio_planejado = :dataInicioPlanejado
                 LIMIT 1000";
                
        try {
            $stmt = $this->conexao->prepare($sql);
                
		    if(!$stmt){
                echo "<br>Mensagem de erro retornada: ".$this->conexao->errorInfo()[2]."<br>";
		    }
            $stmt->bindParam(":dataInicioPlanejado", $dataInicioPlanejado, PDO::PARAM_STR);
            $stmt->execute();
		    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    foreach ( $result as $linha )
            {
                $meta->setId( $linha ['id'] );
                $meta->setDescricao( $linha ['descricao'] );
                $meta->setDataInicioPlanejado( $linha ['data_inicio_planejado'] );
                $meta->setDataFimPlanejado( $linha ['data_fim_planejado'] );
                $meta->setDataInicio( $linha ['data_inicio'] );
                $meta->setDataFim( $linha ['data_fim'] );
                $meta->setPriorizacao( $linha ['priorizacao'] );
                $meta->getSetorResponsavel()->setId( $linha ['id_setor_setor_responsavel'] );
                $meta->getSetorResponsavel()->setNome( $linha ['nome_setor_setor_responsavel'] );
                
                
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
		return $meta;
    }
                
    public function preenchePorDataFimPlanejado(Meta $meta) {
        
	    $dataFimPlanejado = $meta->getDataFimPlanejado();
	    $sql = "
		SELECT
        meta.id, 
        meta.descricao, 
        meta.data_inicio_planejado, 
        meta.data_fim_planejado, 
        meta.data_inicio, 
        meta.data_fim, 
        meta.priorizacao, 
        setor_responsavel.id as id_setor_setor_responsavel, 
        setor_responsavel.nome as nome_setor_setor_responsavel
		FROM meta
		INNER JOIN setor as setor_responsavel ON setor_responsavel.id = meta.id_setor_responsavel
                WHERE meta.data_fim_planejado = :dataFimPlanejado
                 LIMIT 1000";
                
        try {
            $stmt = $this->conexao->prepare($sql);
                
		    if(!$stmt){
                echo "<br>Mensagem de erro retornada: ".$this->conexao->errorInfo()[2]."<br>";
		    }
            $stmt->bindParam(":dataFimPlanejado", $dataFimPlanejado, PDO::PARAM_STR);
            $stmt->execute();
		    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    foreach ( $result as $linha )
            {
                $meta->setId( $linha ['id'] );
                $meta->setDescricao( $linha ['descricao'] );
                $meta->setDataInicioPlanejado( $linha ['data_inicio_planejado'] );
                $meta->setDataFimPlanejado( $linha ['data_fim_planejado'] );
                $meta->setDataInicio( $linha ['data_inicio'] );
                $meta->setDataFim( $linha ['data_fim'] );
                $meta->setPriorizacao( $linha ['priorizacao'] );
                $meta->getSetorResponsavel()->setId( $linha ['id_setor_setor_responsavel'] );
                $meta->getSetorResponsavel()->setNome( $linha ['nome_setor_setor_responsavel'] );
                
                
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
		return $meta;
    }
                
    public function preenchePorDataInicio(Meta $meta) {
        
	    $dataInicio = $meta->getDataInicio();
	    $sql = "
		SELECT
        meta.id, 
        meta.descricao, 
        meta.data_inicio_planejado, 
        meta.data_fim_planejado, 
        meta.data_inicio, 
        meta.data_fim, 
        meta.priorizacao, 
        setor_responsavel.id as id_setor_setor_responsavel, 
        setor_responsavel.nome as nome_setor_setor_responsavel
		FROM meta
		INNER JOIN setor as setor_responsavel ON setor_responsavel.id = meta.id_setor_responsavel
                WHERE meta.data_inicio = :dataInicio
                 LIMIT 1000";
                
        try {
            $stmt = $this->conexao->prepare($sql);
                
		    if(!$stmt){
                echo "<br>Mensagem de erro retornada: ".$this->conexao->errorInfo()[2]."<br>";
		    }
            $stmt->bindParam(":dataInicio", $dataInicio, PDO::PARAM_STR);
            $stmt->execute();
		    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    foreach ( $result as $linha )
            {
                $meta->setId( $linha ['id'] );
                $meta->setDescricao( $linha ['descricao'] );
                $meta->setDataInicioPlanejado( $linha ['data_inicio_planejado'] );
                $meta->setDataFimPlanejado( $linha ['data_fim_planejado'] );
                $meta->setDataInicio( $linha ['data_inicio'] );
                $meta->setDataFim( $linha ['data_fim'] );
                $meta->setPriorizacao( $linha ['priorizacao'] );
                $meta->getSetorResponsavel()->setId( $linha ['id_setor_setor_responsavel'] );
                $meta->getSetorResponsavel()->setNome( $linha ['nome_setor_setor_responsavel'] );
                
                
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
		return $meta;
    }
                
    public function preenchePorDataFim(Meta $meta) {
        
	    $dataFim = $meta->getDataFim();
	    $sql = "
		SELECT
        meta.id, 
        meta.descricao, 
        meta.data_inicio_planejado, 
        meta.data_fim_planejado, 
        meta.data_inicio, 
        meta.data_fim, 
        meta.priorizacao, 
        setor_responsavel.id as id_setor_setor_responsavel, 
        setor_responsavel.nome as nome_setor_setor_responsavel
		FROM meta
		INNER JOIN setor as setor_responsavel ON setor_responsavel.id = meta.id_setor_responsavel
                WHERE meta.data_fim = :dataFim
                 LIMIT 1000";
                
        try {
            $stmt = $this->conexao->prepare($sql);
                
		    if(!$stmt){
                echo "<br>Mensagem de erro retornada: ".$this->conexao->errorInfo()[2]."<br>";
		    }
            $stmt->bindParam(":dataFim", $dataFim, PDO::PARAM_STR);
            $stmt->execute();
		    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    foreach ( $result as $linha )
            {
                $meta->setId( $linha ['id'] );
                $meta->setDescricao( $linha ['descricao'] );
                $meta->setDataInicioPlanejado( $linha ['data_inicio_planejado'] );
                $meta->setDataFimPlanejado( $linha ['data_fim_planejado'] );
                $meta->setDataInicio( $linha ['data_inicio'] );
                $meta->setDataFim( $linha ['data_fim'] );
                $meta->setPriorizacao( $linha ['priorizacao'] );
                $meta->getSetorResponsavel()->setId( $linha ['id_setor_setor_responsavel'] );
                $meta->getSetorResponsavel()->setNome( $linha ['nome_setor_setor_responsavel'] );
                
                
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
		return $meta;
    }
                
    public function preenchePorPriorizacao(Meta $meta) {
        
	    $priorizacao = $meta->getPriorizacao();
	    $sql = "
		SELECT
        meta.id, 
        meta.descricao, 
        meta.data_inicio_planejado, 
        meta.data_fim_planejado, 
        meta.data_inicio, 
        meta.data_fim, 
        meta.priorizacao, 
        setor_responsavel.id as id_setor_setor_responsavel, 
        setor_responsavel.nome as nome_setor_setor_responsavel
		FROM meta
		INNER JOIN setor as setor_responsavel ON setor_responsavel.id = meta.id_setor_responsavel
                WHERE meta.priorizacao = :priorizacao
                 LIMIT 1000";
                
        try {
            $stmt = $this->conexao->prepare($sql);
                
		    if(!$stmt){
                echo "<br>Mensagem de erro retornada: ".$this->conexao->errorInfo()[2]."<br>";
		    }
            $stmt->bindParam(":priorizacao", $priorizacao, PDO::PARAM_INT);
            $stmt->execute();
		    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    foreach ( $result as $linha )
            {
                $meta->setId( $linha ['id'] );
                $meta->setDescricao( $linha ['descricao'] );
                $meta->setDataInicioPlanejado( $linha ['data_inicio_planejado'] );
                $meta->setDataFimPlanejado( $linha ['data_fim_planejado'] );
                $meta->setDataInicio( $linha ['data_inicio'] );
                $meta->setDataFim( $linha ['data_fim'] );
                $meta->setPriorizacao( $linha ['priorizacao'] );
                $meta->getSetorResponsavel()->setId( $linha ['id_setor_setor_responsavel'] );
                $meta->getSetorResponsavel()->setNome( $linha ['nome_setor_setor_responsavel'] );
                
                
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
		return $meta;
    }
    public function buscarDemandantes(Meta $meta)
    {
        $id = $meta->getId();
        $sql = "SELECT * FROM
                meta_demandante
                INNER JOIN demandante
                ON  meta_demandante.id_demandante = demandante.id
                 WHERE meta_demandante.id_meta = $id";
        $result = $this->getConexao ()->query ( $sql );
                     
        foreach ($result as $linha) {
            $demandante = new Demandante();
	        $demandante->setId( $linha ['id'] );
	        $demandante->setNome( $linha ['nome'] );
            $meta->addDemandante($demandante);
                
        }
        return $meta;
    }
                
                
	public function inserirDemandante(Meta $meta, Demandante $demandante)
    {
        $idMeta =  $meta->getId();
        $idDemandante = $demandante->getId();
		$sql = "INSERT INTO meta_demandante(
                    id_meta,
                    id_demandante)
				VALUES(
                :idMeta,
                :idDemandante)";
		try {
			$db = $this->getConexao();
			$stmt = $db->prepare($sql);
		    $stmt->bindParam(":idMeta", $idMeta, PDO::PARAM_INT);
            $stmt->bindParam(":idDemandante", $idDemandante, PDO::PARAM_INT);
                

			return $stmt->execute();
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}
	public function removerDemandante(Meta $meta, Demandante $demandante){
        $idmeta =  $meta->getId();
        $iddemandante = $demandante->getId();
		$sql = "DELETE FROM  meta_demandante WHERE 
                    idmeta = :idmeta
                    AND
                    iddemandante = :iddemandante";
		try {
			$db = $this->getConexao();
			$stmt = $db->prepare($sql);
		    $stmt->bindParam(":idmeta", $idmeta, PDO::PARAM_INT);
            $stmt->bindParam(":iddemandante", $iddemandante, PDO::PARAM_INT);

			return $stmt->execute();
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}
                
                

}