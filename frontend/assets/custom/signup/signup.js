$(document).ready(function(){
    $('button[name=signup-button]').on('click', function(e){
        if($( "#ac:checked" ).length > 0){
            $('.checkbox-label').find('.help-block').remove();
            return true;
        }
        $('.checkbox-label').append('<div class="help-block">Ознакомтесь с правилами</div>');
        return false;
    });
});