$('#select-demandante').selectize({
	create: false,
	sortField: {
		field: 'text',
		direction: 'asc'
	}
});

$('#select-status-meta').selectize({
	create: false,
	sortField: {
		field: 'text',
		direction: 'asc'
	}
});
$('#select-demandante').change(aplicarFiltro);
$('#select-status-meta').change(aplicarFiltro);
function aplicarFiltro(){
	
	$("tbody tr").show();
	var demandante =  'demandante-'+$('#select-demandante').val();
	var status =  $('#select-status-meta').val();
	
	if(!($('#select-demandante').val() == "" || $('#select-demandante').val() == 'todos')){
		$("tbody tr:not(."+demandante+")").hide();
	}
	if(!($('#select-status-meta').val() == "" || $('#select-status-meta').val() == 'todos')){
		$("tbody tr:not(."+status+")").hide();
	}
	
}


$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
$('#painel').change(function() {
	var tipoPainel = $('input[name="painel-pdti"]:checked').val();
	if (tipoPainel == 1) {
		$('#painel-2021').removeClass('escondido');
		$('#painel-2020').addClass('escondido');
	} else {
		$('#painel-2020').removeClass('escondido');
		$('#painel-2021').addClass('escondido');
		
	}

});



function mostraModal(rotulo, corpo){
	
	$('#textoCorpoModal').html(corpo);
	$('#labelModalMeta').html(rotulo);
	$('[data-toggle="tooltip"]').tooltip('hide');
	$('#modalMeta').modal('show');
}

function mostraModalAcoes(rotulo, corpo, percentual, idMeta){
	
	var urlAdm = "?pagina=meta&selecionar="+idMeta;
	$('#admMeta').attr("href", urlAdm);
	
	
	$('#barra-progresso').attr("style", "width: "+percentual+"%");//style="width: 45%;"
	$('#barra-progresso').attr("aria-valuenow", percentual);
	$('#barra-progresso').text(percentual+"%");
	
	$('#textoCorpoModal').html(corpo);
	$('#labelModalMeta').html(rotulo);
	$('[data-toggle="tooltip"]').tooltip('hide');
	$('#modalMeta').modal('show');
	
	
}


