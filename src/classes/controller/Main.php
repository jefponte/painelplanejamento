<?php 

class Main{
    
    
    
    public static function mainApp()
    {
        $usuarioController = new UsuarioController();
        $usuarioController->login();
        
        if(isset($_GET['pagina'])){
            switch ($_GET['pagina']){
                
                case 'usuario':
                    $controller = new UsuarioController();
                    $controller->main();
                    break;
                case 'importar':
                    $controller = new Importador();
                    $controller->main();
                    break;
                default: 
                    echo '040 Não existe essa página.';
                    break;
            }
            return;
            
        }else{
            
            $importador = new Importador();
            $metas = $importador->readFile("uploads/metas.csv");
            $importador->exibir($metas);
            
            
        }
        
    }
}






?>