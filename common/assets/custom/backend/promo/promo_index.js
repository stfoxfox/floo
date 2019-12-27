/**
 * Created by anatoliypopov on 19/12/2016.
 */


$(document).ready(function() {

    var dell_catalog_item = function () {

        var item_name = $(this).data('item-name');
        var item_id = $(this).data('item-id');

        swal({

                title: "Удалить акцию?",
                text: "" + item_name,
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                animation: "slide-from-top",
                showLoaderOnConfirm: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Удалить",
                cancelButtonText: "Отмена"


            },
            function () {

                var csrfToken = $('meta[name="csrf-token"]').attr("content");
                $.ajax({
                    type: "post",
                    url: "/promo/item-dell.html",
                    data: {
                        'item_id': item_id,
                        _csrf: csrfToken
                    },
                    success: function (json) {


                        if (json.error) {
                            swal("Error", "%(", "error");
                        }
                        else {
                            $("#item_" + json.item_id).remove();

                            swal("Готово!", "\n", "success");
                        }


                    },
                    dataType: 'json'
                });

                //  swal("Nice!", "You wrote: " + inputValue, "success");
            });

        return false;

    };



    $('.dell-catalog-item').click(dell_catalog_item);



    $( "#sortable" ).sortable({
        update: function( event, ui ) {
            var data = $(this).sortable('toArray',{ attribute: "sort-id" });

            var csrfToken = $('meta[name="csrf-token"]').attr("content");
            $.ajax({
                type: "POST",
                url:"/promo/item-sort.html",
                data: {
                    item_order:data,
                    _csrf : csrfToken
                },
                success: function(json){


                    if(json.error){
                        swal("Error", "%(", "error");
                    }



                },
                dataType: 'json'
            });
        }
    });
});

