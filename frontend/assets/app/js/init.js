$(document).ready(function() {

	$.fn.andSelf = function() { return this.addBack.apply(this, arguments); }
	
  	MainManager = new MainManager_f();
  	MainManager.init();
  	MainManager.initHeight();
  	$(window).resize(function(){MainManager.initHeight()});


    if(typeof DeliveryManager_f =='function') {
        DeliveryManager = new DeliveryManager_f();
        DeliveryManager.init();
    }
    if(typeof RestaurantManager_f =='function') {
        RestaurantManager = new RestaurantManager_f();
        RestaurantManager.init();
    }


    if(typeof LocationManager_f =='function') {
        LocationManager = new LocationManager_f();
        LocationManager.init();
    }

  	$('[data-scroll-agreement]').mCustomScrollbar({
        theme:'dark',
        autoHideScrollbar: false,
        scrollInertia: 400,
        advanced: {
            updateOnContentResize:true
        },
        callbacks:{
            onInit: function(){

            }
        }
    });

  	$("#callback-pjax").on("pjax:end", function() {
	    $("#modal-callback").modal("hide");
	    MainManager.showModalById("modal-callback-success");
	});

	$( ".basket-catalogItem-delete" ).on( "click", function() {
  		var cart_item_id = $( this ).parents('.basket-catalogItem-id').data("id");
		
	  	// console.log( "item = " + cart_item_id + ": " + catalogItem_count );
	  	// console.log( "size = " + catalogItem_size );
	  	// for (var i in modificators) {
		//   	console.log( "mody = " + i + ": " + modificators[i] );
		// }

		var csrfToken = $('meta[name="csrf-token"]').attr("content");
		$.ajax({
		    url: '/cart/delete.html',
		    type: 'post',
		    data: {
		    	"_csrf-frontend" : csrfToken,
		    	cart_item_id: cart_item_id
		    },
		    dataType: 'json',
		    success: function (json) {
		    	if (json.error) {
                    swal("Error", "%(", "error");
                }
                else {
                	$(".basket-catalogItem-id[data-id='"+cart_item_id+"']").remove();
		   			//console.log( "result = " + JSON.stringify(json) );
                }
		    } 
		});
	});

    $('.checkbox').click(function(){
        if($(this).is(':checked')){


            $( "#item_price" ).html($(this).data('price') + " руб.");

        }
    });

    $( "select.basket-catalogItem-size" ).change(function() {
        var catalogItem_id = $( this ).parents('.basket-catalogItem-id').data("id");
        var catalogItem_size = $( ".basket-catalogItem-id[data-id='"+catalogItem_id+"'] select.basket-catalogItem-size" ).val();
        var catalogItem_price = $(".basket-catalogItem-id[data-id='"+catalogItem_id+"'] .basket-catalogItem-price:selected").data("price");
        $( ".basket-catalogItem-id[data-id='"+catalogItem_id+"'] .rub" ).html(catalogItem_price + " руб.");

        console.log( "catalogItem_id = " + catalogItem_id );
        console.log( "catalogItem_size = " + catalogItem_size );
        console.log( "catalogItem_price = " + catalogItem_price );
        //alert($( this ).val());
    });


	$( "select.basket-catalogItem-size" ).change(function() {
  		var catalogItem_id = $( this ).parents('.basket-catalogItem-id').data("id");
  		var catalogItem_size = $( ".basket-catalogItem-id[data-id='"+catalogItem_id+"'] select.basket-catalogItem-size" ).val();
  		var catalogItem_price = $(".basket-catalogItem-id[data-id='"+catalogItem_id+"'] .basket-catalogItem-price:selected").data("price");
  		$( ".basket-catalogItem-id[data-id='"+catalogItem_id+"'] .rub" ).html(catalogItem_price + " руб.");

		console.log( "catalogItem_id = " + catalogItem_id );
		console.log( "catalogItem_size = " + catalogItem_size );
		console.log( "catalogItem_price = " + catalogItem_price );
		//alert($( this ).val());
	});

  	$( ".basket-catalogItem-addtocart" ).on( "click", function() {
  		var catalogItem_id = $( this ).parents('.basket-catalogItem-id').data("id");
  		var catalogItem_count = $( ".basket-catalogItem-id[data-id='"+catalogItem_id+"'] .basket-catalogItem-count" ).val();
  		var catalogItem_size = $( ".basket-catalogItem-id[data-id='"+catalogItem_id+"'] select.basket-catalogItem-size" ).val();

  		var sizeCheckBox = $("input[name=radio]:checked");



  		console.log(typeof(sizeCheckBox));



        if (sizeCheckBox[0]){
            catalogItem_size=sizeCheckBox.val();
        }





  		var modificators = [];
  		$( ".basket-catalogItem-id[data-id='"+catalogItem_id+"'] .basket-modificator-count" ).each(function( index ) {
		  	if( $( this ).val() > 0 ) 
		  		modificators[$( this ).data("id")] = $( this ).val();
		});
		
	  	// console.log( "item = " + catalogItem_id + ": " + catalogItem_count );
	  	// console.log( "size = " + catalogItem_size );
	  	// for (var i in modificators) {
		//   	console.log( "mody = " + i + ": " + modificators[i] );
		// }

		var csrfToken = $('meta[name="csrf-token"]').attr("content");
		$.ajax({
		    url: '/cart/add.html',
		    type: 'post',
		    data: {
		    	"_csrf-frontend" : csrfToken,
		    	catalogItem_id: catalogItem_id,
		    	catalogItem_count: catalogItem_count,
		    	catalogItem_size: catalogItem_size,
		    	modificators: modificators
		    },
		    dataType: 'json',
		    success: function (json) {
		    	if (json.error) {
                    swal("Error", "%(", "error");
                }
                else {
                	$(".basket-summary-price").html(json.summary_price);
					$(".basket-summary-count").html(json.summary_count);
					var c = $('.product-slider').length;
					// console.log(c);
					if(c == 0 && $('.section').length == 0 && $('.category').length == 0){
						swal('', "success");
						swal({
							title: "Открытка в корзину добавлена", 
							text: "",  
							type: "success",
							showCancelButton: false,
							closeOnConfirm: false 
						},
						function() { 
							window.location.href = '/cart.html';
						});
					}else{
						// swal("", '', "success");
						swal({
							title: "Букет добавлен", 
							text: "",  
							type: "success",
							showCancelButton: false,
							closeOnConfirm: false 
						},
						function() { 
							window.location.href = '/cart.html';
						});
						
					}
                    
                }
		    } 
		});
	});
	
});
