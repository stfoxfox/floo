$(document).ready(function(){

  	$('[data-main-slider]').owlCarousel({
	    items: 1,
	    nav: true,
	    navRewind: false,
	    navText: ['','']
  	});

  	$('#show_more_pizza').on('click',function(){
		location.href = '/menu/dish/pizza.html';
	});

  	//parallax
  	var scene2 = document.getElementById('parallax-bottom');
  	var parallaxBottom = new Parallax(scene2);

});