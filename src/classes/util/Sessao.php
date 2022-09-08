<?php

/**
 * 
 * @author jefponte
 *
 */
class Sessao{
    
    
    public function __construct(){
        if (!isset($_SESSION)) session_start();
    }
    public function criaSessao($id, $nivel){
        $_SESSION['USUARIO_NIVEL'] = $nivel;
        $_SESSION['USUARIO_ID'] = $id;
    }
    public function mataSessao(){
        @session_destroy();
    }
    public function getNivelAcesso(){
        if(isset($_SESSION['USUARIO_NIVEL'])){
            return $_SESSION['USUARIO_NIVEL'];
        }
        else
        {
            return self::NIVEL_DESLOGADO;
        }
        
    }
    public function getIdUsuario(){
        if(isset($_SESSION['USUARIO_ID'])){
            return $_SESSION['USUARIO_ID'];
        }
        else{
            
            return self::NIVEL_DESLOGADO;
        }
    }
    public function getLoginUsuario(){
        if(isset($_SESSION['USUARIO_LOGIN'])){
            return $_SESSION['USUARIO_LOGIN'];
        }
        else
        {
            return self::NIVEL_DESLOGADO;
        }
    }
    public function getStrNivel($nivel){
        if($nivel === self::NIVEL_DESLOGADO){
            return "Deslogado";
        }
        if($nivel === self::NIVEL_COMUM){
            return "Comum";
        }
        if($nivel === self::NIVEL_ADM){
            return "Administrador";
        }
        else {
            return "Nao Encontrado";
        }
    }
    const NIVEL_DESLOGADO = 0;
    const NIVEL_COMUM = 3;
    const NIVEL_ADM = 4;
    
    
}