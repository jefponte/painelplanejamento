<?php
                


class UsuarioDAO extends DAO {
    
        
    /**
     * Vamos verificar na API e verifica o nível na base local. 
     * @param Usuario $usuario
     * @return boolean
     */
    public function autentica(Usuario $usuario)
    {

        /*
         * Primeiro vou verificar na API
         * Deu verifico se o ID está na base local. 
         * 
         */


        $url = "https://api.unilab.edu.br/api/authenticate";
        
        $data = ['login' =>  $usuario->getLogin(), 'senha' => $usuario->getSenha()];
        

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        $responseJ = json_decode($response);


        if(!isset($responseJ->id)){
            return false;
        }
        if(!is_int($responseJ->id)){
            return false;
        }
        $id = $responseJ->id;
        $nome = $responseJ->name;


        $sql = "SELECT * FROM usuario WHERE id = $id LIMIT 1";
        
        foreach ( $this->getConexao ()->query ( $sql ) as $linha ) {
            $usuario->setId ( $linha ['id'] );
            $usuario->setNivel( $linha ['nivel'] );
            return true;
        }

        $nivel = Sessao::NIVEL_COMUM;

        $sqlCount = "SELECT COUNT(*) FROM usuario;";
        $resultCount = $this->getConexao()->query($sqlCount);
        foreach($resultCount as $line){
            if($line['count'] === 0){
                $nivel = Sessao::NIVEL_ADM;
            }
        }
        
        $sqlInsert = "INSERT INTO usuario (id, nome, nivel) VALUES($id, '$nome', $nivel)";
        if($this->getConexao()->exec($sqlInsert)){
            return true;
        }

        return false;
    }

    public function atualizar(Usuario $usuario)
    {
        $id = $usuario->getId();


        $sql = "UPDATE usuario
                SET
                nome = :nome,
                nivel = :nivel
                WHERE usuario.id = :id;";
        $nome = $usuario->getNome();
        $nivel = $usuario->getNivel();

        try {

            $stmt = $this->getConexao()->prepare($sql);
            $stmt->bindParam("id", $id, PDO::PARAM_STR);
            $stmt->bindParam("nome", $nome, PDO::PARAM_STR);
            $stmt->bindParam("nivel", $nivel, PDO::PARAM_STR);

            return $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function atualizarNivel(Usuario $usuario)
    {
        $id = $usuario->getId();
        $nivel = $usuario->getNivel();

        $sql = "UPDATE usuario
                SET
                nivel = :nivel
                WHERE usuario.id = :id;";

        try {
            $stmt = $this->getConexao()->prepare($sql);
            $stmt->bindParam("id", $id, PDO::PARAM_INT);
            $stmt->bindParam("nivel", $nivel, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }



    public function retornaLista()
    {
        $lista = array();
        $sql = "        SELECT
        usuario.id,
        usuario.nome,
        usuario.nivel
        FROM usuario
                 LIMIT 1000";
        $result = $this->getConexao()->query($sql);

        foreach ($result as $linha) {

            $usuario = new Usuario();
            $usuario->setId($linha['id']);
            $usuario->setNome($linha['nome']);
            $usuario->setNivel($linha['nivel']);
            $lista[] = $usuario;
        }
        return $lista;
    } 
}