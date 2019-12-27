$(document).ready(function(){

  $('[data-constructor-slider]').each(function(){
    var length = $(this).find('.item').length;
    var nav;

    if(length > 6){

      nav = true;

    } else {

      nav = false;
    }

    $(this).owlCarousel({
      nav: nav,
      items:6,
      dots:false,
      navRewind: false,
      pullDrag: false,
      navText: ['',''],
      responsive:{
        0:{
          items:2
        },
        640:{
          items:2
        },
        700:{
          items:4
        },
        930:{
          items:6
        }
      }
    });
  });

  var view = $('[data-constructor-view]');
  var element = $('[data-constructor-change]');
  var base = $('[data-constructor-base]');
  var list = $('[data-constructor-list]');

  function clear (id) {
    $('[data-constructor-change="'+id+'"]').removeClass('active');
    $('[data-constructor-img="'+id+'"]').remove();
    $('[data-constructor-row="'+id+'"]').remove();
  }

  function add (id) {
    view.append('<img style="z-index:'+id+';" class="view-img" src="img/constructor/view/'+id+'.png" data-constructor-img="'+id+'">');
    var el = $('[data-constructor-change="'+id+'"]');
    var text = el.attr('data-text');
    var rub = el.attr('data-rub');
    var html =
        '<div class="row" data-constructor-row="'+id+'">'+
          '<div class="col col_2">'+
            '<div class="name">'+text+'</div>'+
          '</div>'+
          '<div class="col col_2 _r">'+
            '<div class="rub">'+rub+' руб.</div>'+
            '<div class="close">'+
            '<button data-constructor-clear="'+id+'" class="close-icon"></button>'+
            '</div>'+
            '<div class="btn-group number-group">'+
              '<button data-btn-constructor="'+id+'" type="button" class="btn border btn-number" data-type="minus"></button>'+
              '<input data-input-constructor="'+id+'" type="text" name="" class="btn border input-number" value="1" min="1" readonly="">'+
              '<button data-btn-constructor="'+id+'" type="button" class="btn border btn-number" data-type="plus"></button>'+
            '</div>'+
          '</div>'+
        '</div>';

    if(id == 1 || id == 2) {
      base.append(html);
    } else {
      list.append(html);
    }

  };

  element.on('click', function (e){
    e.preventDefault();
    var $this = $(this);
    var id = $this.attr('data-constructor-change');
    if(!$this.hasClass('active')) {
      $this.addClass('active');
      if(id == 1) {
        clear(2);
      }
      if(id == 2) {
        clear(1);
      }
      add (id);
    }

  });

  $('body').on('click', '[data-btn-constructor]', function(e){
    e.preventDefault();
    var type = $(this).attr('data-type');
    var id = $(this).attr('data-btn-constructor');
    var input = $('[data-input-constructor="'+id+'"]');
    var currentVal = parseFloat(input.val());
    var max = parseFloat(input.attr('max'));
    var min = parseFloat(input.attr('min'));

    if (!currentVal || currentVal == "" || currentVal == "NaN") currentVal = 0;
    if (max == "" || max == "NaN") max = '';
    if (min == "" || min == "NaN") min = 0;

    if (type == 'plus') {
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

  $('body').on('click', '[data-constructor-clear]', function(e){
    e.preventDefault();
    var id = $(this).attr('data-constructor-clear');
    clear(id);
    $('[data-input-constructor="'+id+'"]').val(1).trigger('change');
  });

  $('[data-constructor-refreshed]').on('click', function(){
    $('[data-constructor-change]').removeClass('active');
    $('[data-constructor-img]').remove();
    $('[data-constructor-row]').remove();
    add (1);
    $('[data-constructor-change="1"]').addClass('active');
    $('[data-input-constructor]').val(1).trigger('change');
  });

});