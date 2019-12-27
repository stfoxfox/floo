/**
 * Created by anatoliypopov on 30/06/2017.
 */
$(document).ready(function() {

    $('.save-item').editable();

    $("#sortable").sortable({
        forcePlaceholderSize: true,
        opacity: 0.8,
        update: function (event, ui) {
            var data = $(this).sortable('toArray', {attribute: "sort-id"});

            var csrfToken = $('meta[name="csrf-token"]').attr("content");
            $.ajax({
                type: "POST",
                url: "/gallery/gallery-sort.html",
                data: {
                    sort_data: data,
                    _csrf: csrfToken
                },
                success: function (json) {


                    if (json.error) {
                        swal("Error", "%(", "error");
                    }


                },
                dataType: 'json'
            });
        }
    });

    var dell_item = function () {

        var user_name = $(this).data('item-name');
        var item_id = $(this).data('item-id');

        swal({

                title: "Удалить файл?",
                text: "" ,
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                animation: "slide-from-top",
                showLoaderOnConfirm: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Удалить",
                cancelButtonText: "НЕТ"


            },
            function () {

                var csrfToken = $('meta[name="csrf-token"]').attr("content");
                $.ajax({
                    type: "post",
                    url: "/gallery/dell-gallery-item.html",
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

    var edit_item = function () {

        var picture_url = $(this).data('picture-url');
        var item_id = $(this).data('item-id');

        $('#galleryform-image_id').val(item_id);



        $("#crop_img").attr('src', picture_url);

        console.log(picture_url);
        $('#photo_submit').fadeIn(300);
        //$inputImage.val("");
        var res = this.result;
        $('#cropper-example-2-modal').modal('show').on('shown.bs.modal', function () {
            $image.cropper({
                autoCropArea: 0.5,
                minContainerHeight:300,
              //  aspectRatio: 0.94,
                //  preview: ".img-preview",
                // minContainerHeight:300,
                crop: function(data) {
                    // Output the result data for cropping image.
                    showCoords(data);
                },
                built: function () {
                    // Strict mode: set crop box data first
                    // $image.cropper('setCropBoxData', cropBoxData);
                    //  $image.cropper('setCanvasData', canvasData);
                }
            }).cropper("reset", true);
        }).on('hidden.bs.modal', function () {
            // cropBoxData = $image.cropper('getCropBoxData');
            // canvasData = $image.cropper('getCanvasData');
            $image.cropper('destroy');
            $('#gallery-image_id').val(null);
        });



    };








    $('.dell-blog-item').click(dell_item);
    $('.edit-blog-item').click(edit_item);


    var $image = $("#crop_img");

    var $inputImage = $("#inputImage");
    if (window.FileReader) {
        $inputImage.change(function() {
            var fileReader = new FileReader(),
                files = this.files,
                file;

            if (!files.length) {
                return;
            }

            file = files[0];

            if (/^image\/\w+$/.test(file.type)) {
                fileReader.readAsDataURL(file);
                fileReader.onload = function () {
                    $('#photo_submit').fadeIn(300);
                    //$inputImage.val("");
                    var res = this.result;
                    $('#cropper-example-2-modal').modal('show').on('shown.bs.modal', function () {
                        $image.cropper({
                            autoCropArea: 0.5,
                            minContainerHeight:300,
                            //aspectRatio: 0.94,
                            //  preview: ".img-preview",
                            // minContainerHeight:300,
                            crop: function(data) {
                                // Output the result data for cropping image.
                                showCoords(data);
                            },
                            built: function () {
                                // Strict mode: set crop box data first
                                // $image.cropper('setCropBoxData', cropBoxData);
                                //  $image.cropper('setCanvasData', canvasData);
                            }
                        }).cropper("reset", true).cropper("replace", res);
                    }).on('hidden.bs.modal', function () {
                        // cropBoxData = $image.cropper('getCropBoxData');
                        // canvasData = $image.cropper('getCanvasData');
                        $image.cropper('destroy');
                    });

                };
            } else {
                showMessage("Please choose an image file.");
            }
        });

    } else {
        $inputImage.addClass("hide");
    }





    function showCoords(c) {
        $('#gallaryform-x').val(c.x);
        $('#galleryform-y').val(c.y);
        $('#galleryform-h').val(c.height);
        $('#galleryform-w').val(c.width);
    }



    $('#picture-done-button').on('click',function(){

        $('#cropper-example-2-modal').modal('hide');

        swal({

            title:"Uploading..." ,
            showCancelButton: false,
            showConfirmButton:false,
            closeOnConfirm: false,
            text: '<div class="sk-spinner sk-spinner-cube-grid"><div class="sk-cube"></div><div class="sk-cube"></div><div class="sk-cube"></div><div class="sk-cube"></div><div class="sk-cube"></div><div class="sk-cube"></div><div class="sk-cube"></div><div class="sk-cube"></div><div class="sk-cube"></div></div>',
            html: true

        });

        $("#upload-picture-form").ajaxSubmit({
            url: '/gallery/gallery-add-picture.html',
            type: 'post',

            success: function(json){


                if(json.error){
                    swal("Error", "%(", "error");
                }else if(json.replace_block){

                     $('#item_'+json.picture_id).replaceWith('<tr id="item_'+json.picture_id+'" sort-id="'+json.picture_id+'" ><td><span class="label label-info dd-h"><i class="fa fa-list"></i></span></td><td><a class="galery_img" data-lightbox="roadtrip" href="'+json.picture_src+'"><img alt="image" class="img-responsive" src="'+json.picture_thumb+'"></a></td><td>' +
                        '<a id="text_'+json.picture_id+'" href="#" data-url="'+json.save_url+'"  data-block-id ="'+json.picture_id+'"   data-emptytext="Текст" data-mode="inline"  data-type="textarea"  data-pk="'+json.picture_id+'"  data-name="text" data-placement="right" data-placeholder="Текст"  class="editable editable-click item-settings myeditable save-item" data-original-title="" title="" style="background-color: rgba(0, 0, 0, 0);"></a>' +
                        '</td><td><a href="#" class="edit-blog-item" data-picture-url="'+json.picture_src+'" data-item-id="'+json.picture_id+'">Изменить</a> |<a href="#" class="dell-blog-item" data-item-id="'+json.picture_id+'" >Удалить</a></td></tr>').
                    on('click', '.dell-blog-item', dell_item).on('click', '.edit-blog-item', edit_item);
                    $('.save-item').editable();
                    swal("Done!", null, "success");
                }
                else{


                    $('#sortable').append('<tr id="item_'+json.picture_id+'" sort-id="'+json.picture_id+'" ><td><span class="label label-info dd-h"><i class="fa fa-list"></i></span></td><td><a class="galery_img" data-lightbox="roadtrip" href="'+json.picture_src+'"><img alt="image" class="img-responsive" src="'+json.picture_thumb+'"></a></td><td>' +
                        '<a id="text_'+json.picture_id+'" href="#" data-url="'+json.save_url+'"  data-block-id ="'+json.picture_id+'"   data-emptytext="Текст" data-mode="inline"  data-type="textarea"  data-pk="'+json.picture_id+'"  data-name="text" data-placement="right" data-placeholder="Текст"  class="editable editable-click item-settings myeditable save-item" data-original-title="" title="" style="background-color: rgba(0, 0, 0, 0);"></a>' +
                        '</td><td><a href="#" class="edit-blog-item" data-picture-url="'+json.picture_src+'" data-item-id="'+json.picture_id+'">Изменить</a> |<a href="#" class="dell-blog-item" data-item-id="'+json.picture_id+'" >Удалить</a></td></tr>').
                    on('click', '.dell-blog-item', dell_item).on('click', '.edit-blog-item', edit_item);
                    $('.save-item').editable();
                    swal("Done!", null, "success");
                }



            },
            dataType: 'json'
        })



    });





});