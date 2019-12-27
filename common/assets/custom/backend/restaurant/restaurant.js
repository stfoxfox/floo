/**
 * Created by anatoliypopov on 07.11.15.
 */

$(document).ready(function() {


    var dell_item = function () {

        var cat_name = $(this).data('cat_name');
        var cat_id = $(this).data('cat');

        swal({

                title: "Удалить регион?",
                text: "" + cat_name,
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                animation: "slide-from-top",
                showLoaderOnConfirm: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Delete",
                cancelButtonText: "NO"


            },
            function () {

                var csrfToken = $('meta[name="csrf-token"]').attr("content");
                $.ajax({
                    type: "post",
                    url: "/restaurant/region-dell.html",
                    data: {
                        'category_id': cat_id,
                        _csrf: csrfToken
                    },
                    success: function (json) {


                        if (json.error) {
                            swal("Error", "%(", "error");
                        }
                        else {
                            $("#cat_" + json.category_id).remove();

                            swal("Deleted!", "\n", "success");
                        }


                    },
                    dataType: 'json'
                });

                //  swal("Nice!", "You wrote: " + inputValue, "success");
            });

        return false;

    };
    var dell_catalog_item = function () {

        var item_name = $(this).data('item-name');
        var item_id = $(this).data('item-id');

        swal({

                title: "Delete item?",
                text: "" + item_name,
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                animation: "slide-from-top",
                showLoaderOnConfirm: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Delete",
                cancelButtonText: "NO"


            },
            function () {

                var csrfToken = $('meta[name="csrf-token"]').attr("content");
                $.ajax({
                    type: "post",
                    url: "/restaurant/item-dell.html",
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

                            swal("Deleted!", "\n", "success");
                        }


                    },
                    dataType: 'json'
                });

                //  swal("Nice!", "You wrote: " + inputValue, "success");
            });

        return false;

    };

    $('#edit-category').on('click',function(){


        var category_id = $(this).data('category-id');
        var category_title = $(this).data('category-title');

        swal({

                title: "Изменить регион",
                text: "Название региона:",
                type: "input",
                showCancelButton: true,
                closeOnConfirm: false,
                animation: "slide-from-top",
                showLoaderOnConfirm: true,
                confirmButtonText: "Изменить",
                cancelButtonText:"Отмена",
            inputValue:category_title,
                inputPlaceholder: ""
            },
            function(inputValue){
                if (inputValue === false) return false;
                if (inputValue === "") {
                    swal.showInputError("Название не модент быть пустым");
                    return false   }


                var csrfToken = $('meta[name="csrf-token"]').attr("content");
                $.ajax({
                    type: "post",
                    url:"/restaurant/edit-region.html",
                    data: {
                        title:inputValue,
                        category_id:category_id,
                        _csrf : csrfToken

                    },
                    success: function(json){


                        if(json.error){
                            swal("Error", "%(", "error");
                        }
                        else{

                            window.location.reload(true);
                        }



                    },
                    dataType: 'json'
                });

                //  swal("Nice!", "You wrote: " + inputValue, "success");
            });





    });
    $('.cat_dell').click(dell_item);
    $('.dell-catalog-item').click(dell_catalog_item);

    $('#createCategory').click(function () {


        swal({

                title: "Добавить регион",
                text: "Название региона:",
                type: "input",
                showCancelButton: true,
                closeOnConfirm: false,
                animation: "slide-from-top",
                showLoaderOnConfirm: true,
                confirmButtonText: "Добавить",
                cancelButtonText:"Отмена",

                inputPlaceholder: ""
            },
            function(inputValue){
                if (inputValue === false) return false;
                if (inputValue === "") {
                    swal.showInputError("Title can not be blank");
                    return false   }


                var csrfToken = $('meta[name="csrf-token"]').attr("content");
                $.ajax({
                    type: "post",
                    url:"/restaurant/add-region.html",
                    data: {
                        title:inputValue,
                        _csrf : csrfToken

                    },
                    success: function(json){


                        if(json.error){
                            swal("Error", "%(", "error");
                        }
                        else{
                            $('#folder_list li:eq(0)').before('<li id="cat_'+json.region_id+'"><a href="/restaurant/'+json.region_id+'.html"><i class="fa fa-folder"></i>'+json.region_title+'</a></li>');
                            swal("Готово!", "Регион добавлен!", "success");
                        }



                    },
                    dataType: 'json'
                });

                //  swal("Nice!", "You wrote: " + inputValue, "success");
            });

        return false;

    });



    $( "#folder_list" ).sortable({
        update: function( event, ui ) {
            var data = $(this).sortable('toArray',{ attribute: "sort-id" });

            var csrfToken = $('meta[name="csrf-token"]').attr("content");
            $.ajax({
                type: "POST",
                url:"/restaurant/region-sort.html",
                data: {
                    region_order:data,
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

    $( "#sortable" ).sortable({
        update: function( event, ui ) {
            var data = $(this).sortable('toArray',{ attribute: "sort-id" });

            var csrfToken = $('meta[name="csrf-token"]').attr("content");
            $.ajax({
                type: "POST",
                url:"/restaurant/item-sort.html",
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
