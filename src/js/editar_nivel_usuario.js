
$('.botao-altear-nivel').click(preparaAlterarNivel);
function preparaAlterarNivel(){
	console.log("Evento chamado.");
	
	var idUsuario = $(this).attr('id-usuario');
	var nivel = $(this).attr('nivel');
	
	$("#input-id-usuario").val(idUsuario);
	$("#input-nivel").val(nivel);
	$('#modalEditarNivel').modal("show");
	
}