$(document).ready(function(){

  	$("#password").on("pjax:end", function() {
	    MainManager.showModalById("modal-password-success");
	});

	$("#personnal").on("pjax:end", function() {
	    MainManager.showModalById("modal-personal-success");
	});

	$("#phone").on("pjax:end", function() {
	    MainManager.showModalById("modal-request-success");
	});	

});