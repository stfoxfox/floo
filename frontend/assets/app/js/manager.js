'use strict';

function MainManager_f() {

	this.init = function () {
		var scene = document.getElementById('parallax');
		if (scene != null) {
			var parallax = new Parallax(scene);
		}
		MainManager.initHeight();

        MainManager.initCounter();

		$('[data-btn-select]').selectpicker();
		$('[data-dropdown-menu]').click(function (event) {
			if (event.target.className != 'close-icon') {
				event.stopPropagation();
			}
		});

		$('[data-scroll]').mCustomScrollbar({
			autoHideScrollbar: false,
			scrollInertia: 400,
			advanced: {
				updateOnContentResize: true
			},
			callbacks: {
				onInit: function () {
				}
			}
		});

		var owl = $('[data-product-slider]');
		owl.on('initialized.owl.carousel resize.owl.carousel refreshed.owl.carousel', function (event) {
			var top = $(event.target).find('img').height();
			$(event.target).find('.owl-nav div').css('top', top / 2 - 7);
		});

		owl.owlCarousel({
			nav: true,
			items: 6,
			dots: false,
			navRewind: false,
			navText: ['', ''],
			responsive: {
				0: {
					items: 2
				},
				640: {
					items: 2
				},
				700: {
					items: 4
				},
				930: {
					items: 6
				}
			}
		});

		$(window).scroll(function () {
			var row = $('[data-row-fixed]');
			if ($(this).scrollTop() > 180) {
				row.addClass('to-fix');
			} else {
				row.removeClass('to-fix');
			}
		});
		$(document)
			.on("click", ".button-auth", MainManager.auth)
			.on("click", ".button-reg", MainManager.reg)
			.on("click", ".callme", MainManager.callme)
			//.on("click", ".send-order", MainManager.sendOrder)
			.on("submit", "#sendReview", MainManager.sendReview)
			.on("click", ".sl", MainManager.recoveryForm)
			.on("click", ".in-basket", MainManager.inBasket)
			.on("click", ".button-recover", MainManager.recoverySend)
			.on("click", "[data-stoplist]", MainManager.stopListOK)
			.on("click", "[data-order-go]", MainManager.basketOrder)
			.on("click", "[data-check-present]", MainManager.chooseGift);


		$('[data-restaurant-ul],[data-set-scroll]').mCustomScrollbar({
			theme: 'light',
			autoHideScrollbar: false,
			scrollInertia: 400,
			advanced: {
				updateOnContentResize: true
			},
			callbacks: {
				onInit: function () {

				}
			}
		});
		$("[data-phone]").mask("+7(999)999-99-99");
		$("#orderform-phone").mask("+7(999)999-99-99");
	};

	this.chooseGift = function() {
		$('[data-check-present]').removeClass('select');
		$(this).addClass('select');
		var gift = $(this).attr('data-check-present');
		$.post(
			"/cart/select-gift.html",
			{ gift: gift},
			function () {}, "json");
		return false;
	};

	this.stopListOK = function() {
		document.location.href = '/basket/';
	};

	this.basketOrder = function() {
		if($('div.basket-row.error').length > 0) {
			MainManager.showModal('stoplist.basket');
		}
		else {
			if(parseInt($('.total.basket-price').text()) >= 650) {
				window.location.href = '/basket/order/';
			}
		}
	};

	this.recoverySend = function () {
		var login = $('#login').val();
		$.post(
			"/ajax/",
			{action: 'ajaxRecover', login: login},
			function (data) {
				if (data.result == 'ok') {
					$('#modal').hide();
					MainManager.showTextAlert('Вам отправлен новый пароль на указанный номер');
				}
				else {
					MainManager.showTextAlert('Пользователь не найден');
				}
			}, "json");
		return false;
	};

	this.recoveryForm = function () {
		MainManager.showModal('recovery');
		return false;
	};

	this.checkForSales = function () {
		var idLastUpdated = MainManager.getCookie("lastOrderId");
		var lastUpdated = MainManager.getCookie("lastUpdated");
		var now = Date.now();

		if ((now - lastUpdated) > 300000 || typeof lastUpdated == 'undefined' || lastUpdated == null) {
			$.post(
				"/ajax/",
				{action: 'getLastOrder'},
				function (data) {
					if (data.result == 'ok') {
						if (idLastUpdated < data.order.id) {
							MainManager.setCookie("lastOrderId", data.order.id);
							MainManager.setCookie("lastUpdated", Date.now());
							MainManager.showAlertProduct(data.order);
						}
					}
				}, "json");
		}
	};

	this.sendReview = function (e) {
		var name = $('[name=name]').val();
		var theme = $('[name=theme]').val();
		var text = $('[name=text]').val();
		var login = $('[name=phone]').val();

		if (name.length < 3 || theme.length < 5 || text.length < 20 || ($('[name=phone]').length == 1 && login.length < 8)) {
			MainManager.showTextAlert('Все поля обязательны к заполнению!');
			e.preventDefault();
			return false;
		}
	};
	
	this.clearHints = function() {
		LocationManager.address = '';
		LocationManager.addressName = '';
		LocationManager.restaurant = false;
		LocationManager.zone = false;
		LocationManager.lat = '';
		LocationManager.lon = '';
		LocationManager.section = '';
		LocationManager.stage = '';
		LocationManager.flat = '';
		MainManager.showAddressError(false);
	};
	
	this.showAddressError = function(trueOrFalse) {
		if(trueOrFalse) {
			$('.hint._error').show();
			$('.addr-input').addClass('error');
			// $('.send-order').attr("disabled","disabled");
            // $("#orderform-lat").val("");
            // $("#orderform-lng").val("") ;

            $('#map').hide();
		}
		else {
			$('.hint._error').hide();
			$('.addr-input').removeClass('error');
			var address = $("#orderform-address").val();
			if(address.length > 5) {
				$('.send-order').removeAttr("disabled");
			}
			else {
				// $('.send-order').attr("disabled","disabled");
			}
		}
	};

	this.reg = function () {
		var login = $('#login').val();
		if ($('#ac').prop("checked")) {
			$.post(
				"/ajax/",
				{action: 'registration', login: login},
				function (data) {
					if (data.result == 'ok') {
						$('#modal').modal('hide');
						MainManager.showTextAlert('Пароль отправлен на телефон');
					}
					else {
						if (data.error == 'double') {
							MainManager.showTextAlert('Вы уже зарегистрированы. Воспользуйтесь восстановлением пароля');
						}
						else {
							if (data.error == 'mobileRegistration') {
								MainManager.showTextAlert('Зарегистрировать возможно только мобильный телефон');
							}
							else {
								MainManager.showTextAlert('Укажите номер вашего телефона в верном формате');
							}
						}
					}
				}, "json");
		}
		else {
			MainManager.showTextAlert('Ознакомьтесь пожалуйста с условиями регистрации');
		}
		return false;
	};

	this.inBasket = function () {
		if ($('.basket-cnt-products').text() > 0) {
			document.location.href = '/basket/';
		}
		else {
			$('#basket').modal('show');
		}
	};

	this.sendOrder = function () {
		var name = $('[data-name]').val();
		var login = $('[data-phone]').val();
		if(name && login) {
			if (LocationManager.address && LocationManager.addressName && LocationManager.zone && LocationManager.restaurant) {
				var paySystem = $('[name=PAY_SYSTEM_ID]:checked').val();
				var address = LocationManager.address;
				var addressName = LocationManager.addressName;
				var locationID = LocationManager.locationID;
				var section = $('[data-section]').val();
				var stage = $('[data-stage]').val();
				var flat = $('[data-flat]').val();
				var zone = LocationManager.zone;
				var restaurant = LocationManager.restaurant;
				var comment = $('[data-comment]').val();
				var change = $('[data-change]').val();

				$.post(
					"/ajax/",
					{
						action: 'orderDetails',
						name: name,
						login: login,
						paySystem: paySystem,
						address: address,
						addressName: addressName,
						locationID: locationID,
						section: section,
						stage: stage,
						flat: flat,
						zone: zone,
						change: change,
						comment: comment,
						restaurant: restaurant
					},
					function (data) {
						if (data.result == 'ok') {
							if (typeof data.paySystemType != 'undefined') {
								document.location.href = "/payment/pay.php?pay_system=" + data.paySystem + "&ORDER_ID=" + data.order, '_blank';
							}
							else {
								document.location.href = '/basket/completed/';
							}
						}
						else if(data.result == 'error') {
							if (data.error == 'summ') {
								MainManager.showTextAlert('Минимальная сумма доставки для данной зоны - ' + data.summ + ' рублей.');
							}

							if (data.error == 'time') {
								MainManager.showTextAlert('Извините, но в данный момент из-за графика работы ресторана доставка не возможна');
							}

							if (data.error == 'address') {
								MainManager.showTextAlert('Введите пожалуйста корректный адрес доставки');
							}

							if (data.error == 'stoplist') {
								MainManager.showModal('stoplist');
							}
						}
					}, "json");
			}
			else {
				if($('[data-address]').val() == '')
					MainManager.showTextAlert('Поле адрес обязательно к заполнению');
				else {
					MainManager.showTextAlert('По указанному вами адресу доставка не осуществляется.');
				}
			}
		}
		else {
			MainManager.showTextAlert('Поля имя и телефон обязательны к заполнению');
		}
	};

	this.initHeight = function () {
		var box = $('[data-height]');
		var big = -1;
		box.each(function () {
			big = big > $(this).height() ? big : $(this).height();
		});
		box.each(function () {
			$(this).css('min-height', big);
		});
	};

	this.closeAC = function () {
		MainManager.clear(this);
		MainManager.showTextAlert('Пароль отправлен на телефон');
	};

	this.showModal = function (template) {
		var modal = $('#modal');
		modal.removeData('bs.modal').removeClass('phone authorization registration reviews');
		modal.modal({
			backdrop: 'static',
			remote: '/forms/' + template + '/'
		});
		modal.addClass(template);
		modal.modal('show');

		$('#modal').on('shown.bs.modal', function () {
			$("#login").mask("+7(999)999-99-99");
			$("#signupform-username").mask("+7(999)999-99-99");
			$("#loginform-username").mask("+7(999)999-99-99");
			$("#callbackform-phone").mask("+7(999)999-99-99");
		});
	};

	this.getFileName = function () {
		var files = document.getElementById('vacancies-file').files;
		for (var i = 0; i < files.length; i++) {
			$('[data-list-vacancies-file]').append('<li data-list="' + i + '">' +
				'<span class="close-icon" onclick="MainManager.clear(this)"></span>' + files[i].name + '</li>');
		}
	};

	this.clear = function (e) {
		$('#modal').hide();
	};

	this.showTextAlert = function(text) {
		var boxAlert = $('[data-alert]');
		var boxAlertText = $('[data-alert-text]');

		boxAlertText.html(text);
		boxAlert.addClass('show');

		setTimeout(function () {
			boxAlert.removeClass('show');
			boxAlertText.html('');
		}, 7000)
	};

	this.addrAdd = function () {
		var s = $('[data-addr-street]').val();
		var h = $('[data-addr-house]').val();

		if (s != '' && h != '') {
			$('[data-addr-list]').append('<button class="btn border">' + s + ',' + h + '</button>')
		}
	};

	this.showAlertProduct = function (order) {
		$('[data-widget-img]').attr('src', order.src);
		$('[data-widget-text]').text(order.user + ' заказал ' + order.product_name + ' за ' + order.price + ' рублей.');
		$('[data-widget-href]').attr('href', order.url);
		$('[data-alert-by]').addClass('show');
		MainManager.setCookie("lastUpdated", Date.now() + 86400000);
	};

	this.hideAlertProduct = function () {
		$('[data-alert-by]').removeClass('show');
	};

	this.auth = function () {
		var login = $('#login').val();
		var password = $('#password').val();
		$.post(
			"/ajax/",
			{action: 'auth', login: login, password: password},
			function (data) {
				if (data.result == 'ok') {
					location.reload();
				}
				else {
					MainManager.showTextAlert('Пользователь не найден');
				}
			}, "json");
		return false;
	};

	this.callme = function () {
		var phone = $('[data-phone]').val();
		var name = $('[data-name]').val();
		$.post(
			"/ajax/",
			{action: 'callme', phone: phone, name: name},
			function (data) {
				if (data.result == 'ok') {
					$('#modal').remove();
					MainManager.showTextAlert('Ждите обратного звонка в течении 5 минут.');
				}
				else {
					MainManager.showTextAlert('Оставьте пожалуйста номер телефона и мы Вам перезвоним');
				}
			}, "json");
		return false;
	};

	this.showMenu = function (m) {
		var b = $('[data-back]');
		b.addClass('anim show');
		$('[' + m + ']').addClass('anim show');
		$('[' + m + '] li a, [data-back] ').on('click', function () {
			$('[' + m + ']').removeClass('anim show');
			b.removeClass('anim show');

		});
	};

	this.setCookie = function (name, value) {
		document.cookie = name + "=" + escape(value) + "; path=/;";
	};

	this.getCookie = function (name) {
		var results = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
		if (results)
			return (unescape(results[2]));
		else
			return null;
	};


    this.showModalById = function (id){

        var modal = $('#'+id);
        //modal.removeData('bs.modal').removeClass('phone authorization registration reviews');
        modal.modal({
            backdrop: 'static',
            //remote: './template/' + template +'.html'
        }).on('shown.bs.modal', function () {
            $("#login").mask("+7(999)999-99-99");
            $("#signupform-username").mask("+7(999)999-99-99");
            $("#loginform-username").mask("+7(999)999-99-99");
            $("#callbackform-phone").mask("+7(999)999-99-99");
        });;

        //modal.addClass(template);
        modal.modal('show');
    };

    this.basket = function (col) {

        if(col != 0) {

            window.location.href = "/cart.html";

        } else {

            $('#basket').modal('show');
        }
    };

    this.initCounter = function(){

        var btnCount = $('[data-btn-number]');

        btnCount.click(function(e){

            e.preventDefault();
            var type = $(this).attr('data-type');
            var input = $(this).parent().find('[data-input-number]');
            var currentVal = parseFloat(input.val());
            var max = parseFloat(input.attr('max'));
            var min = parseFloat(input.attr('min'));

            if (!currentVal || currentVal == "" || currentVal == "NaN") currentVal = 0;
            if (max == "" || max == "NaN") max = '';
            if (min == "" || min == "NaN") min = 0;

            if (type == 'plus') {
				var parentBlock = $(this).parent().parent().parent();
				var sum = 0;
				$.each(parentBlock.find('.basket-modificator-count'), function(i){
					sum = sum + Number($(this).val());					
				});
				
				if(sum == 1){
					swal("К выбранному букету можно добавить только один камень - комплимент", '', "warning");
					return false;
				}
                if (max && (max == currentVal || currentVal > max)) {
                    input.val(max);
                } else {
                    input.val(currentVal + 1);
				}				
            } else if(type == 'minus') {
                if (min && (min == currentVal || currentVal < min)) {
                    input.val(min);
                } else if (currentVal > 0) {
                    input.val(currentVal - 1);
                }
            }

            input.trigger('change');

        });
    };

}