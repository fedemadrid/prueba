/* Mostrar/ocultar barra de login */
$(document).ready(function(){
        /* login */
	$('#btn-open-login').click(function(){
		$('#bottom-nav').slideToggle();
	});
        
        /* signin */
        $('#btn-open-signin').click(function(){
		$('#bottom-nav-2').slideToggle();
	});
});
