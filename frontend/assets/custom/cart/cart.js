$(document).ready(function(){  	
	document.forms["kassa_form"].submit();

	$('.order-button').on('click',function(){
		var h = (new Date()).getUTCHours();
		console.log(h);
		return false;
	});
});