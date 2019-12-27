/**
 * Created by anatoliypopov on 07.11.15.
 */

$(document).ready(function() {


    var dell_item = function () {

        var cat_name = $(this).data('cat_name');
        var cat_id = $(this).data('cat');

        swal({

                title: "Удалить тег?",
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
                    url: "/site-settings/tag-dell.html",
                    data: {
                        'tag_id': cat_id,
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
                    url: "/catalog/item-dell.html",
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
    var dell_organisation = function () {

        var cat_name = $(this).data('cat_name');
        var cat_id = $(this).data('cat');

        swal({

                title: "Удалить организацию?",
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
                    url: "/site-settings/organisation-dell.html",
                    data: {
                        'tag_id': cat_id,
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








    $('#edit-category').on('click',function(){


        var category_id = $(this).data('category-id');
        var category_title = $(this).data('category-title');

        swal({

                title: "Изменить тег",
                text: "Тег:",
                type: "input",
                showCancelButton: true,
                closeOnConfirm: false,
                animation: "slide-from-top",
                showLoaderOnConfirm: true,
                confirmButtonText: "Сохранить",
                cancelButtonText:"Отмена",
            inputValue:category_title,
                inputPlaceholder: ""
            },
            function(inputValue){
                if (inputValue === false) return false;
                if (inputValue === "") {
                    swal.showInputError("Тег не может быть пустым");
                    return false   }


                var csrfToken = $('meta[name="csrf-token"]').attr("content");
                $.ajax({
                    type: "post",
                    url:"/site-settings/edit-tag.html",
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
    $('.dell_organisation').click(dell_organisation);
    $('.dell-catalog-item').click(dell_catalog_item);

    $('#createCategory').click(function () {


        swal({

                title: "Добавить тег",
                text: "Тег:",
                type: "input",
                showCancelButton: true,
                closeOnConfirm: false,
                animation: "slide-from-top",
                showLoaderOnConfirm: true,
                confirmButtonText: "Add",
                cancelButtonText:"Cancel",

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
                    url:"/site-settings/add-tag.html",
                    data: {
                        title:inputValue,
                        _csrf : csrfToken

                    },
                    success: function(json){


                        if(json.error){
                            swal("Error", "%(", "error");
                        }
                        else{
                            $('#folder_list li:eq(0)').before('<li id="cat_'+json.tag_id+'"><a href="/catalog/'+json.tag_id+'.html"><i class="fa fa-folder"></i>'+json.tag_title+'</a></li>');
                            swal("Добавлено!", "Тег добавлен!", "success");
                        }



                    },
                    dataType: 'json'
                });

                //  swal("Nice!", "You wrote: " + inputValue, "success");
            });

        return false;

    });

$('#createOrganisation').click(function () {


        swal({

                title: "Добавить организацию",
                text: "Название:",
                type: "input",
                showCancelButton: true,
                closeOnConfirm: false,
                animation: "slide-from-top",
                showLoaderOnConfirm: true,
                confirmButtonText: "Add",
                cancelButtonText:"Cancel",

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
                    url:"/site-settings/add-organisation.html",
                    data: {
                        title:inputValue,
                        _csrf : csrfToken

                    },
                    success: function(json){


                        if(json.error){
                            swal("Error", "%(", "error");
                        }
                        else{
                            $('#organisations_list li:eq(0)').before('<li id="cat_'+json.tag_id+'"><a href="/catalog/'+json.tag_id+'.html"><i class="fa fa-folder"></i>'+json.tag_title+'</a></li>');
                            swal("Добавлено!", "Тег добавлен!", "success");
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
                url:"/site-settings/tag-sort.html",
                data: {
                    tag_order:data,
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
