<?php
                
/**
 * Classe feita para manipulação do objeto Setor
 * feita automaticamente com programa gerador de software inventado por
 * @author Jefferson Uchôa Ponte
 *
 *
 */



class SetorDAO extends DAO {
    


            
            
    public function atualizar(Setor $setor)
    {
        $id = $setor->getId();
            
            
        $sql = "UPDATE setor
                SET
                nome = :nome
                WHERE setor.id = :id;";
			$nome = $setor->getNome();
            
        try {
            
            $stmt = $this->getConexao()->prepare($sql);
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			$stmt->bindParam(":nome", $nome, PDO::PARAM_STR);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
            
    }
            
            

    public function inserir(Setor $setor){
        $sql = "INSERT INTO setor(nome) VALUES (:nome);";
		$nome = $setor->getNome();
		try {
			$db = $this->getConexao();
			$stmt = $db->prepare($sql);
			$stmt->bindParam(":nome", $nome, PDO::PARAM_STR);
			return $stmt->execute();
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
            
    }
    public function inserirComPK(Setor $setor){
        $sql = "INSERT INTO setor(id, nome) VALUES (:id, :nome);";
		$id = $setor->getId();
		$nome = $setor->getNome();
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

	public function excluir(Setor $setor){
		$id = $setor->getId();
		$sql = "DELETE FROM setor WHERE id = :id";
		    
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
        setor.id, 
        setor.nome
		FROM setor
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
		        $setor = new Setor();
                $setor->setId( $linha ['id'] );
                $setor->setNome( $linha ['nome'] );
                $lista [] = $setor;

	
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
        return $lista;	
    }
        
                
    public function pesquisaPorId(Setor $setor) {
        $lista = array();
	    $id = $setor->getId();
                
        $sql = "
		SELECT
        setor.id, 
        setor.nome
		FROM setor
            WHERE setor.id = :id";
                
        try {
                
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $linha ) {
                $setor = new Setor();
    	        $setor->setId( $linha ['id'] );
    	        $setor->setNome( $linha ['nome'] );
    			$lista [] = $setor;
    			    
            }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function pesquisaPorNome(Setor $setor) {
        $lista = array();
	    $nome = $setor->getNome();
                
        $sql = "
		SELECT
        setor.id, 
        setor.nome
		FROM setor
            WHERE setor.nome like :nome";
                
        try {
                
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindParam(":nome", $nome, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $result as $linha ) {
                $setor = new Setor();
    	        $setor->setId( $linha ['id'] );
    	        $setor->setNome( $linha ['nome'] );
    			$lista [] = $setor;
    			    
            }
    			    
        } catch(PDOException $e) {
            echo $e->getMessage();
    			    
        }
		return $lista;
    }
                
    public function preenchePorId(Setor $setor) {
        
	    $id = $setor->getId();
	    $sql = "
		SELECT
        setor.id, 
        setor.nome
		FROM setor
                WHERE setor.id = :id
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
                $setor->setId( $linha ['id'] );
                $setor->setNome( $linha ['nome'] );
                
                
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
		return $setor;
    }
                
    public function preenchePorNome(Setor $setor) {
        
	    $nome = $setor->getNome();
	    $sql = "
		SELECT
        setor.id, 
        setor.nome
		FROM setor
                WHERE setor.nome = :nome
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
                $setor->setId( $linha ['id'] );
                $setor->setNome( $linha ['nome'] );
                
                
		    }
		} catch(PDOException $e) {
		    echo $e->getMessage();
 		}
		return $setor;
    }
}