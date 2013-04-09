$(document).ready(function() {
	
	$("#login").click(function() {
	
		var action = $("#form_login").attr('action');
		var form_data = {
			username_login: $("#username_login").val(),
			password_login: $("#password_login").val(),
			login_ajax: 1
		};
		
		$.ajax({
			type: "POST",
			url: action,
			data: form_data,
			success: function(response)
			{
				if(response == 'usr')
					window.location.href = "index.php";
				if(response == 'admin' || response == 'sec' )
					window.location.href = "back-end.php";
				if(response == 'error')
					$("#message_login").html("Usuario y/o contrase&ntilde;a incorrectos.");	
			}
		});
		
		return false;
	});
	
});
