$(document).ready(function() {
	
	$("#signin").click(function() {
	
		var action = $("#form_signin").attr('action');
		var form_data = {
			username_signin: $("#username_signin").val(),
			password_signin: $("#password_signin").val(),
			signin_ajax: 1
		};
		
		$.ajax({
			type: "POST",
			url: action,
			data: form_data,
			success: function(response)
			{
				if(response == 'creado'){
					$("#message_signin").html("EXITO: Por favor, ingrese al sistema.");

				}
				if(response == 'existente'){
					$("#message_signin").html("ERROR: Usuario existente. Por favor, ingrese otro.");

				}
				if(response == 'vacio'){
					$("#message_signin").html("ERROR: Complete los campos.");

				}
			}
		});
		
		return false;
	});
	
});
