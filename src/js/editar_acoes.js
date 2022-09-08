
$('#editarAcao').click(editar);


function editar(){

	var somatorio = 0;
	var lista = [];
	$( ".campo-percentual" ).each(function(index, value) {
		var percentual = 0;
		if($.isNumeric($(value).val())){
			somatorio +=  parseFloat($(value).val());	
			percentual = parseFloat($(value).val());
			
		}
		var name = $(value).attr("name");
		var idAcao = name.split('id_acao_')[1];
		var acao = Object();
		acao.percentual = percentual;
		acao.id = idAcao;
		acao.status = 0;
		lista[idAcao] = acao;
	});
	$( ".campo-status" ).each(function(index, value) {
		var status = 0;
		if($.isNumeric($(value).val())){
			status = parseFloat($(value).val());
		}
		var name = $(value).attr("name");
		var idAcao = name.split('id_acao_')[1];
		lista[idAcao].status = status;
	});
	if(somatorio != 100){
		$('#modalMensagemTexto').text("O somatório dos percentuais deve ser igual a 100. ");
		$('#modalMensagem').modal('show');
		return;
	}
	var novaUrl = 'index.php?pagina=ajax&atualizar_metas=1';
	var percentualRealizado = 0;
	
	Object.keys(lista).forEach(function (key) {
		novaUrl += '&status_id_acao_'+key+'='+lista[key].status;
		novaUrl += '&percentual_id_acao_'+key+'='+lista[key].percentual;
		if(lista[key].status == 2){
			percentualRealizado += lista[key].percentual;
		}
	});

	$.ajax({
        url: novaUrl,
        success: function (response) {
        	$('#modalMensagemTexto').html(response);
        	$('#modalMensagem').modal('show');
        	
        	$('#barra-progresso').attr('aria-valuenow', percentualRealizado);
        	$('#barra-progresso').text(percentualRealizado+"%");
        	$('#barra-progresso').attr('style', 'width: '+percentualRealizado+'%;');
        }
    });
}