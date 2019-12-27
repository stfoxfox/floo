/**
 * Created by anatoliypopov on 07.11.15.
 */

$(document).ready(function() {


    var dell_item = function () {

        var cat_name = $(this).data('cat_name');
        var cat_id = $(this).data('cat');

        swal({

                title: "Delete category?",
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
                    url: "/catalog/category-dell.html",
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

    var add_spot_catalog_item = function() {
        $('#edit-modal').removeData('bs.modal')
            .modal({remote: '/catalog/add-item.html?category_id='+$(this).data('category-id')})
            .modal('show').on('shown.bs.modal',function(){
                $('#spotcatalogitemform-category_id').chosen();

            });



    };

    var edit_spot_catalog_item = function() {
        $('#edit-modal').removeData('bs.modal')
            .modal({remote: '/catalog/edit-item.html?item_id=' + $(this).data('item-id')})
            .modal('show').on('shown.bs.modal',function(){
                $('#spotcatalogitemform-category_id').chosen();

            });



    };

    $('.item-price').editable();

    $('#add_item').on('click',add_spot_catalog_item);

    $('#edit-category').on('click',function(){


        var category_id = $(this).data('category-id');
        var category_title = $(this).data('category-title');

        swal({

                title: "Edit Category",
                text: "Category Title:",
                type: "input",
                showCancelButton: true,
                closeOnConfirm: false,
                animation: "slide-from-top",
                showLoaderOnConfirm: true,
                confirmButtonText: "Edit",
                cancelButtonText:"Cancel",
            inputValue:category_title,
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
                    url:"/catalog/edit-category.html",
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
    $('.edit-catalog-item').click(edit_spot_catalog_item);
    $('.dell-catalog-item').click(dell_catalog_item);

    $('#createCategory').click(function () {


        swal({

                title: "Add Category",
                text: "Category Title:",
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
                    url:"/catalog/add-category.html",
                    data: {
                        title:inputValue,
                        _csrf : csrfToken

                    },
                    success: function(json){


                        if(json.error){
                            swal("Error", "%(", "error");
                        }
                        else{
                            $('#folder_list li:eq(0)').before('<li id="cat_'+json.category_id+'"><a href="/catalog/'+json.category_id+'.html"><i class="fa fa-folder"></i>'+json.category_title+'</a></li>');
                            swal("Added!", "Spot type category added!", "success");
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
                url:"/catalog/category-sort.html",
                data: {
                    category_order:data,
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
                url:"/catalog/item-sort.html",
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
