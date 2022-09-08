<?php

class Importador
{
    public function __construct()
    {

    }
    public function main(){
        echo '<div class="container">';
        $this->upload();
        echo '</div>';
    }

	public function upload() {
        if(isset($_POST['enviar_planilha'])){
            if($_FILES['arquivo']['name'] != null){
                if(!file_exists('uploads/')) {
                    mkdir('uploads/', 0777, true);
                }	
            }
            
            if(!move_uploaded_file($_FILES['arquivo']['tmp_name'], 'uploads/metas.csv'))
            {
                echo '
                <div class="alert alert-danger" role="alert">
                    Falta na tentativa de upload
                </div>  
                ';
            }else{
                echo '
                <div class="alert alert-success" role="alert">
                    Arquivo enviado com sucesso!
                </div>';
            }
           
        }
        $this->showInsertForm();
        // $registros = $this->readFile();
        // $this->exibir($registros);
	}
    public function exibir($registros){
        
        echo '<div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%"
            cellspacing="0">
            <thead>
            ';
            foreach($registros as $n => $linha){
                $i = 0;
                echo '<tr>';
                foreach($linha as $key => $value) {
                    $i++;
                    if($i == 7) {
                        break;
                    }
                    echo '<th>'.
                    $key.
                    '</th>';    
                }
                echo '</tr>';
                break;

            }
            echo '
            </thead>
            <tfoot>
            ';
            foreach($registros as $n => $linha){
                echo '<tr>';
                $i = 0;
                foreach($linha as $key => $value) {
                    $i++;
                    if($i == 7) {
                        break;
                    }
                    echo '<th>'.
                    $key.
                    '</th>';    
                }
                echo '</tr>';
                break;
            }
            echo '
            </tfoot>
            <tbody>';
        
            foreach($registros as $n => $linha){
                echo '<tr>';
                $i = 0; 
                foreach($linha as $key => $value) {
                    $i++;
                    if($i == 7) {
                        break;
                    }
                    echo '<td>'.
                    $value.
                    '</td>';    
                }
                echo '</tr>';

            }
        
    echo '
            </tbody>
        </table>
    </div>';
    }
        
    public function readFile($path){
        
        $delimitador = '$';
        $cerca = '"';
        $linhas = array();
        $cabecalho = array();
        if (($handle = fopen($path, "r")) == FALSE) {
            echo 'Falha ao tentar abrir a planilha de metas';
            return false;
        }
        $i = 0;
        while (!feof($handle)) {
            $i++;
            $linha = fgetcsv($handle, 0, $delimitador, $cerca);
            if (!$linha) {
                continue;
            }
            if($i == 1){
                $cabecalho = $linha;
                continue;
            }

            $registro = array_combine($cabecalho, $linha);
            $linhas[] = $registro;
        }
        fclose($handle);
        return $linhas;
    }
            


    public function showInsertForm() {
        echo '

<div class="row">
<div class="card m-5">
  <div class="card-body">
    <form id="insert_form_planilha" class="user" method="post" enctype="multipart/form-data" >
            <input type="hidden" name="enviar_planilha" value="1">
            Utilize o formulário abaixo para sobrescrever o arquivo CSV.<br><br>  
            <div class="custom-file">
              <input type="file" class="custom-file-input" name="arquivo" id="arquivo" accept=".csv">
              <label class="custom-file-label" for="anexo" data-browse="Anexar">Planilha de Metas CSV </label>
            </div>
          </form>
        <button form="insert_form_planilha" type="submit" class="btn btn-primary m-4">Enviar</button>

  </div>
</div>
<div class="card m-5">
  <div class="card-body">
    <form id="insert_form_planilha" class="user" method="post" enctype="multipart/form-data" >
            <input type="hidden" name="enviar_planilha" value="1">
            Utilize o formulário abaixo para sobrescrever o arquivo CSV.<br><br>  
            <div class="custom-file">
              <input disabled type="file" class="custom-file-input" name="arquivo" id="arquivo" accept=".csv">
              <label class="custom-file-label" for="anexo" data-browse="Anexar">Planilha de Ações CSV </label>
            </div>


          </form>
        <button form="insert_form_planilha" type="submit" class="btn btn-primary m-4" disabled>Enviar</button>

  </div>
</div>

</div> 

';
    }


    /**
     * 
     * @param string $data no formatoi d/m/Y
     * @return string no formato Y-m-d
     */
    public function formatarData($data){
        
        $dia = intval(explode('/', $data)[0]);
        $mes = intval(explode('/', $data)[1]);
        $ano = intval(explode('/', $data)[2]);
        $dataNova = $ano . '-' . ($mes < 10 ? '0' . $mes : $mes) . '-' . ($dia < 10 ? '0' . $dia : $dia);
        return $dataNova;
        
    }

}
