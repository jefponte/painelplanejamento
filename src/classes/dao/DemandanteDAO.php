<?php
                
/**
 * Classe feita para manipulação do objeto Demandante
 * feita automaticamente com programa gerador de software inventado por
 * @author Jefferson Uchôa Ponte
 *
 *
 */



class DemandanteDAO extends DAO {
    


            
            
    public function atualizar(Demandante $demandante)
    {
        $id = $demandante->getId();
            
            
        $sql = "UPDATE demandante
                SET
                nome = :nome
                WHERE demandante.id = :id;";
			$nome = $demandante->getNome();
            
        try {
            
            $stmt = $this->getConexao()->prepare($sql);
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			$stmt->bindParam(":nome", $nome, PDO::PARAM_STR);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
            
    }
            
            

    public function inserir(Demandante $demandante){
        $sql = "INSERT INTO demandante(nome) VALUES (:nome);";
		$nome = $demandante->getNome();
		try {
			$db = $this->getConexao();
			$stmt = $db->prepare($sql);
			$stmt->bindParam(":nome", $nome, PDO::PARAM_STR);
			return $stmt->execute();
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
            
    }
    public function inserirComPK(Demandante $demandante){
        $sql = "INSERT INTO demandante(id, nome) VALUES (:id, :nome);";
		$id = $demandante->getId();
		$nome = $demandante->getNome();
		try {
			$db = $this->getConexao();
			$stmt = $db->prepare($sql);
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			$stmt->bindParam(":nome", $nome, PDO::PARAM_STR);
			return $stmt->execute();
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}

    }

	public function excluir(Demandante $demandante){
		$id = $demandante->getId();
		$sql = "DELETE FROM demandante WHERE id = :id";
		    
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
        demandante.id, 
        demandante.nome
		FROM demandante
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
		        $demandante = new Demandante();
                $demandante->setId( $linha ['id'] );
                $demandante->setNome( $linha ['nome'] );
                $lista [] = $demandante;

	
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
        return $lista;	
    }
        
                
    public function pesquisaPorId(Demandante $demandante) {
        $lista = array();
	    $id = $demandante->getId();
                
        $sql = "
		SELECT
        demandante.id, 
        demandante.nome
		FROM demandante
            WHERE demandante.id = :id";
                
        try {
                
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $linha ) {
                $demandante = new Demandante();
    	        $demandante->setId( $linha ['id'] );
    	        $demandante->setNome( $linha ['nome'] );
    			$lista [] = $demandante;
    			    
            }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function pesquisaPorNome(Demandante $demandante) {
        $lista = array();
	    $nome = $demandante->getNome();
                
        $sql = "
		SELECT
        demandante.id, 
        demandante.nome
		FROM demandante
            WHERE demandante.nome like :nome";
                
        try {
                
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindParam(":nome", $nome, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $linha ) {
                $demandante = new Demandante();
    	        $demandante->setId( $linha ['id'] );
    	        $demandante->setNome( $linha ['nome'] );
    			$lista [] = $demandante;
    			    
            }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function preenchePorId(Demandante $demandante) {
        
	    $id = $demandante->getId();
	    $sql = "
		SELECT
        demandante.id, 
        demandante.nome
		FROM demandante
                WHERE demandante.id = :id
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
                $demandante->setId( $linha ['id'] );
                $demandante->setNome( $linha ['nome'] );
                
                
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
		return $demandante;
    }
                
    public function preenchePorNome(Demandante $demandante) {
        
	    $nome = $demandante->getNome();
	    $sql = "
		SELECT
        demandante.id, 
        demandante.nome
		FROM demandante
                WHERE demandante.nome = :nome
                 LIMIT 1000";
                
        try {
            $stmt = $this->conexao->prepare($sql);
                
		    if(!$stmt){
                echo "<br>Mensagem de erro retornada: ".$this->conexao->errorInfo()[2]."<br>";
		    }
            $stmt->bindParam(":nome", $nome, PDO::PARAM_STR);
            $stmt->execute();
		    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    foreach ( $result as $linha )
            {
                $demandante->setId( $linha ['id'] );
                $demandante->setNome( $linha ['nome'] );
                
                
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
		return $demandante;
    }
}